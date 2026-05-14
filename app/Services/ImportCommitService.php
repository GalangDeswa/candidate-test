<?php
namespace App\Services;

use App\Models\Layer;
use App\Models\Layup;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportCommitService
{
    protected array $supplierUidMap = [];
    protected array $layupUidMap = [];

    public function commit(array $analysis, array $resolutions): void
    {
        DB::transaction(function () use ($analysis, $resolutions) {
            $this->commitSuppliers(
                $analysis['suppliers'] ?? [],
                $resolutions['suppliers'] ?? []
            );

            $this->commitLayups(
                $analysis['layups'] ?? [],
                $resolutions['layups'] ?? []
            );

            $this->commitLayers(
                $analysis['layers'] ?? [],
                $resolutions['layers'] ?? []
            );
        });
    }

    protected function commitSuppliers(array $results, array $resolutions): void
    {
        foreach ($results as $result) {
            if ($result['type'] === 'IDENTICAL') {
                continue;
            }

            if ($result['type'] === 'NEW') {
                Supplier::create($result['incoming']);
                continue;
            }

            if ($result['type'] === 'CONFLICT') {
                $uid = $result['uid'];
                $resolution = $resolutions[$uid] ?? 'skip';

                if ($resolution === 'skip') {
                    continue;
                }

                if ($resolution === 'overwrite') {
                    Supplier::where('uid', $uid)->update(
                        collect($result['differences'])
                            ->map(fn($x) => $x['incoming'])
                            ->toArray()
                    );


                    $this->supplierUidMap[$uid] = $uid;
                }

                if ($resolution === 'duplicate') {
                    $incoming = $result['incoming'];
                    $oldUid = $incoming['uid'];
                    $newUid = (string) Str::uuid();

                    $incoming['uid'] = $newUid;
                    $incoming['name'] .= ' imported';

                    $supplier = Supplier::create($incoming);

                   
                    $this->supplierUidMap[$oldUid] = $supplier->uid;
                }
            }
        }
    }

    protected function commitLayups(array $results, array $resolutions): void
    {
        foreach ($results as $result) {
            $incomingSupplierUid = $result['incoming']['supplier_uid'];
            $mappedSupplierUid = $this->supplierUidMap[$incomingSupplierUid] ?? $incomingSupplierUid;
            
           
            $parentWasDuplicated = ($mappedSupplierUid !== $incomingSupplierUid);

            
            if (!$parentWasDuplicated && $result['type'] === 'IDENTICAL') {
                continue;
            }

            $supplier = Supplier::where('uid', $mappedSupplierUid)->first();

            if (!$supplier) {
                continue;
            }

          
            if ($parentWasDuplicated) {
                $incoming = $result['incoming'];
                $oldLayupUid = $incoming['uid'];
                $newLayupUid = (string) Str::uuid();

                $layup = Layup::create([
                    ...collect($incoming)->except('supplier_uid', 'uid')->toArray(),
                    'uid' => $newLayupUid,
                    'supplier_id' => $supplier->id,
                ]);

               
                $this->layupUidMap[$oldLayupUid] = $layup->uid;
                continue;
            }

           
            if ($result['type'] === 'NEW') {
                $layup = Layup::create([
                    ...collect($result['incoming'])->except('supplier_uid')->toArray(),
                    'supplier_id' => $supplier->id,
                ]);

                $this->layupUidMap[$result['incoming']['uid']] = $layup->uid;
                continue;
            }

           
            if (in_array($result['type'], ['NAME_DUPLICATE', 'CONFLICT'])) {
                $uid = $result['uid'];
                $resolution = $resolutions[$uid] ?? 'skip';

                if ($resolution === 'skip') {
                    continue;
                }

                if ($resolution === 'overwrite') {
                    Layup::where('uid', $uid)->update([
                        ...collect($result['incoming'])->except('supplier_uid')->toArray(),
                        'supplier_id' => $supplier->id,
                    ]);

                    $this->layupUidMap[$uid] = $uid;
                }

                if ($resolution === 'duplicate') {
                    $incoming = $result['incoming'];
                    $oldLayupUid = $incoming['uid'];
                    $newLayupUid = (string) Str::uuid();

                    $incoming['uid'] = $newLayupUid;
                    $incoming['name'] .= ' imported';

                    $layup = Layup::create([
                        ...collect($incoming)->except('supplier_uid')->toArray(),
                        'supplier_id' => $supplier->id,
                    ]);

                    $this->layupUidMap[$oldLayupUid] = $layup->uid;
                }

              
            }
        }
    }

    protected function commitLayers(array $results, array $resolutions): void
    {
        foreach ($results as $result) {
            $incomingLayupUid = $result['incoming']['layup_uid'];
            $mappedLayupUid = $this->layupUidMap[$incomingLayupUid] ?? $incomingLayupUid;
            
           
            $parentWasDuplicated = ($mappedLayupUid !== $incomingLayupUid);

           
            if (!$parentWasDuplicated && $result['type'] === 'IDENTICAL') {
                continue;
            }

            $layup = Layup::where('uid', $mappedLayupUid)->first();

            if (!$layup) {
                continue;
            }

       
            if ($parentWasDuplicated) {
                $payload = collect($result['incoming'])->except('layup_uid')->toArray();
                
              
                if (isset($payload['uid'])) {
                    $payload['uid'] = (string) Str::uuid();
                }

                Layer::create([
                    ...$payload,
                    'layup_id' => $layup->id,
                ]);
                continue;
            }

            
            if ($result['type'] === 'NEW') {
                Layer::create([
                    ...collect($result['incoming'])->except('layup_uid')->toArray(),
                    'layup_id' => $layup->id,
                ]);
                continue;
            }

          
            if ($result['type'] === 'CONFLICT') {
                $key = $incomingLayupUid . '-' . $result['layer_order'];
                $resolution = $resolutions[$key] ?? 'skip';

                if ($resolution === 'skip') {
                    continue;
                }

                if ($resolution === 'overwrite') {
                    $payload = collect($result['incoming'])->except('layup_uid')->toArray();
                    $payload['layup_id'] = $layup->id;

                    Layer::where('id', $result['old']['id'])->update($payload);
                }

                if ($resolution === 'duplicate') {
                    Layer::create([
                        ...collect($result['incoming'])->except('layup_uid')->toArray(),
                        'layup_id' => $layup->id,
                    ]);
                }
            }

           
            if ($result['type'] === 'DUPLICATE_LAYER') {
                continue;
            }
        }
    }
}