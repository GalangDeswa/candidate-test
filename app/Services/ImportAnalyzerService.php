<?php

namespace App\Services;

use App\Models\Layer;
use App\Models\Layup;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;


class ImportAnalyzerService
{
    protected array $processed = [];


    public function analyze(array $data): array
    {

        $supplierDuplicateUids =
            collect($data['suppliers'])
                ->pluck('uid')
                ->filter()
                ->duplicates();

        $layupDuplicateUids =
            collect($data['layups'])
                ->pluck('uid')
                ->filter()
                ->duplicates();

        $layerDuplicateKeys =
            collect($data['layers'])
                ->map(
                    fn($row) =>
                    ($row['layup_uid'] ?? '') .
                    '|' .
                    ($row['layer_order'] ?? '')
                )
                ->duplicates();

        $supplierUids =
            collect($data['suppliers'])
                ->pluck('uid');

        $layupUids =
            collect($data['layups'])
                ->pluck('uid');


        $result = [
            'suppliers' => [],
            'layups' => [],
            'layers' => [],
            'relation_errors' => [],
        ];



        foreach ($data['suppliers'] as $row) {
            $result['suppliers'][] =
                $this->analyzeSupplier($row, $supplierDuplicateUids);
        }



        foreach ($data['layups'] as $row) {
            $result['layups'][] =
                $this->analyzeLayup(
                    $row,
                    $supplierUids,
                    $layupDuplicateUids
                );
        }



        foreach ($data['layers'] as $row) {
            $result['layers'][] =
                $this->analyzeLayer(
                    $row,
                    $layupUids,
                    $layerDuplicateKeys
                );
        }




        $result['relation_errors'] =
            $this->validateRelations($data);

        $conflictTypes = [
            'INVALID',
            'DUPLICATE_IN_IMPORT',
            'UPDATE',
            'RELATION_ERROR',
            'NAME_DUPLICATE',
            'DUPLICATE_LAYER',
            'CONFLICT',
        ];

        $allResults = collect([
            ...$result['suppliers'],
            ...$result['layups'],
            ...$result['layers'],
            ...$result['relation_errors'],
        ]);



        $result['conflicts'] =
            $allResults
                ->filter(
                    fn($item) =>
                    in_array(
                        $item['type'] ?? null,
                        $conflictTypes
                    )
                )
                ->values()
                ->toArray();

        return $result;
    }




    public function analyzeSupplier(array $row, $supplierDuplicateUids): array
    {

        $validator = Validator::make($row, [
            'uid' => 'required',
            'name' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {

            return [
                'type' => 'INVALID',
                'uid' => $row['uid'] ?? null,
                'errors' => $validator->errors(),
            ];
        }




        $supplier = Supplier::where('uid', $row['uid'])->first();

        if ($supplierDuplicateUids->contains($row['uid'])) {
            return [
                'type' => 'DUPLICATE_IN_IMPORT',
                'uid' => $row['uid'],
                'name' => $row['name'],
                'incoming' => $row,
                'old' => $supplier,
                'message' => 'Duplicate supplier UID found in import file',
            ];
        }

        if (!$supplier) {
            return [
                'type' => 'NEW',
                'uid' => $row['uid'],
                'name' => $row['name'],
                'contact' => $row['contact'],
                'location' => $row['location'],
                'material_certificate' => $row['material_certificate'],
                'last_audit' => $row['last_audit'],
                'status' => $row['status'],
                'incoming' => $row,
            ];
        }

        $changes = [];

        foreach (
            [
                'name',
                'contact',
                'location',
                'status'
            ] as $field
        ) {

            $dbValue = $this->normalizeValue(
                $supplier->$field
            );

            $incomingValue = $this->normalizeValue(
                $row[$field] ?? null
            );

            if ($dbValue !== $incomingValue) {

                $changes[$field] = [
                    'database' => $supplier->$field,
                    'incoming' => $row[$field] ?? null,
                ];
            }
        }

        if (empty($changes)) {
            return [
                'type' => 'IDENTICAL',
                'uid' => $row['uid'],
                'name' => $row['name'],
                'contact' => $row['contact'],
                'location' => $row['location'],
                'material_certificate' => $row['material_certificate'],
                'last_audit' => $row['last_audit'],
                'status' => $row['status'],
                'incoming' => $row,
                'old' => $supplier,
            ];
        }

        return [
            'type' => 'CONFLICT',
            'uid' => $row['uid'],
            'name' => $row['name'],
            'contact' => $row['contact'],
            'location' => $row['location'],
            'material_certificate' => $row['material_certificate'],
            'last_audit' => $row['last_audit'],
            'status' => $row['status'],
            'incoming' => $row,
            'old' => $supplier,
            'differences' => $changes,
        ];
    }


    protected function analyzeLayup(
        array $row,
        $supplierUids,
        $layupDuplicateUids
    ): array {
        $validator = Validator::make($row, [
            'uid' => 'required',
            'supplier_uid' => 'required',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'type' => 'INVALID',
                'uid' => $row['uid'] ?? null,
                'errors' => $validator->errors(),
            ];
        }



        $supplier = Supplier::where(
            'uid',
            $row['supplier_uid']
        )->first();

        $existsInDb = !!$supplier;

        $existsInImport =
            $supplierUids->contains(
                $row['supplier_uid']
            );

        if (!$existsInDb && !$existsInImport) {

            return [
                'type' => 'RELATION_ERROR',
                'uid' => $row['uid'],
                'message' => 'Supplier not found',
            ];
        }






        $layupByUid = Layup::where(
            'uid',
            $row['uid']
        )->first();

        $layupByName = Layup::whereHas(
            'supplier',
            fn($q) => $q->where(
                'uid',
                $row['supplier_uid']
            )
        )->whereRaw('LOWER(name) = ?', [
                    strtolower(trim($row['name']))
                ])->first();



        if ($layupDuplicateUids->contains($row['uid'])) {
            return [
                'type' => 'DUPLICATE_IN_IMPORT',
                'uid' => $row['uid'],
                'name' => $row['name'],
                'supplier_name' => $supplier?->name,
                'incoming' => $row,
                'old' => $layupByUid,
                'message' => 'Duplicate layup UID found in import file',
            ];
        }

        if ($layupByUid) {
            $changes = [];

            foreach (
                [
                    'name',
                    'species',
                    'grade',
                    'revision',
                    'status'
                ] as $field
            ) {

                $dbValue = $this->normalizeValue(
                    $layupByUid->$field
                );

                $incomingValue = $this->normalizeValue(
                    $row[$field] ?? null
                );

                if ($dbValue !== $incomingValue) {

                    $changes[$field] = [
                        'database' => $layupByUid->$field,
                        'incoming' => $row[$field] ?? null,
                    ];
                }


            }

            if (empty($changes)) {
                return [
                    'type' => 'IDENTICAL',
                    'uid' => $row['uid'],
                    'supplier_uid' => $row['supplier_uid'],
                    'supplier_name' => $supplier?->name,
                    'name' => $row['name'],
                    'species' => $row['species'],
                    'grade' => $row['grade'],
                    'revision' => $row['revision'],
                    'status' => $row['status'],
                    'incoming' => $row,
                    'old' => $layupByUid,
                ];
            }


            return [
                'type' => 'UPDATE',
                'uid' => $row['uid'],
                'supplier_uid' => $row['supplier_uid'],
                'supplier_name' => $supplier?->name,
                'name' => $row['name'],
                'species' => $row['species'],
                'grade' => $row['grade'],
                'revision' => $row['revision'],
                'status' => $row['status'],
                'incoming' => $row,
                'old' => $layupByUid,
                'differences' => $changes
            ];

        }


        if (
            $layupByName &&
            $layupByName->uid !== $row['uid']
        ) {
            $changes = [];

            $changes['name'] = [
                'database' => $layupByName->name,
                'incoming' => $row['name'] ?? null,
            ];
            return [
                'type' => 'NAME_DUPLICATE',
                'uid' => $row['uid'],
                'supplier_uid' => $row['supplier_uid'],
                'supplier_name' => $supplier?->name,
                'name' => $row['name'],
                'species' => $row['species'],
                'grade' => $row['grade'],
                'revision' => $row['revision'],
                'status' => $row['status'],
                'incoming' => $row,
                'old' => $layupByName,
                'differences' => $changes,
                'message' => 'Layup name already exists under this supplier',
            ];
        }




        return [
            'type' => 'NEW',
            'uid' => $row['uid'],
            'supplier_uid' => $row['supplier_uid'],
            'supplier_name' => $supplier?->name,
            'name' => $row['name'],
            'species' => $row['species'],
            'grade' => $row['grade'],
            'revision' => $row['revision'],
            'status' => $row['status'],
            'incoming' => $row,
        ];


    }


    protected function analyzeLayer(
        array $row,
        $layupUids,
        $duplicateKeys
    ): array {

        $validator = Validator::make($row, [
            'layup_uid' => 'required',
            'layer_order' => 'required',
        ]);

        if ($validator->fails()) {

            return [
                'type' => 'INVALID',
                'errors' => $validator->errors(),
            ];
        }

        $layup = Layup::where(
            'uid',
            $row['layup_uid']
        )->first();

        $existsInDb = !!$layup;

        $existsInImport =
            $layupUids->contains(
                $row['layup_uid']
            );

        if (!$existsInDb && !$existsInImport) {

            return [
                'type' => 'RELATION_ERROR',
                'message' => 'Layup not found',
            ];
        }

        $layer = null;

        if ($layup) {

            $layer = Layer::where(
                'layer_order',
                $row['layer_order']
            )
                ->where(
                    'layup_id',
                    $layup->id
                )
                ->first();
        }

        $layupName =
            $layup?->name ??
            $row['layup_uid'];

        $supplierName =
            $layup?->supplier?->name ??
            '-';

        $key =
            ($row['layup_uid'] ?? '') .
            '|' .
            ($row['layer_order'] ?? '');

        if (
            $duplicateKeys->contains($key) &&
            isset($this->processed[$key])
        ) {

          $changes = [];

          $changes['combination'] = [
    'database' => "Layup $layupName - Layer {$row['layer_order']}",
    'incoming' => "Layup $layupName - Layer {$row['layer_order']}",
];

            return [
                'type' => 'DUPLICATE_LAYER',
                'layup_uid' => $row['layup_uid'],
                'layup_name' => $layupName,
                'supplier_name' => $supplierName,
                'layer_order' => $row['layer_order'],
                'incoming' => $row,
                'old' => $layer,
                'differences' => $changes,
                
                'message' =>
                    'Duplicate layer combination found in import file',
            ];
        }

        $this->processed[$key] = true;

        if (!$layer) {

            return [
                'type' => 'NEW',
                'layup_name' => $layupName,
                'supplier_name' => $supplierName,
                'layer_order' => $row['layer_order'],
                'thickness' => $row['thickness'] ?? null,
                'width' => $row['width'] ?? null,
                'angle' => $row['angle'] ?? null,
                'grade' => $row['grade'] ?? null,
                'incoming' => $row,
            ];
        }

        $changes = [];

        foreach (
            [
                'layer_order',
                'thickness',
                'width',
                'angle',
                'grade'
            ] as $field
        ) {

            $dbValue = $this->normalizeValue(
                $layer->$field
            );

            $incomingValue = $this->normalizeValue(
                $row[$field] ?? null
            );

            if ($dbValue !== $incomingValue) {

                $changes[$field] = [
                    'database' => $layer->$field,
                    'incoming' => $row[$field] ?? null,
                ];
            }
        }

        if (empty($changes)) {

            return [
                'type' => 'IDENTICAL',
                'layup_name' => $layupName,
                'supplier_name' => $supplierName,
                'layer_order' => $row['layer_order'],
                'thickness' => $row['thickness'] ?? null,
                'width' => $row['width'] ?? null,
                'angle' => $row['angle'] ?? null,
                'grade' => $row['grade'] ?? null,
                'incoming' => $row,
                'old' => $layer
            ];
        }



        return [
            'type' => 'CONFLICT',
            'layup_name' => $layupName,
            'supplier_name' => $supplierName,
            'layer_order' => $row['layer_order'],
            'thickness' => $row['thickness'] ?? null,
            'width' => $row['width'] ?? null,
            'angle' => $row['angle'] ?? null,
            'grade' => $row['grade'] ?? null,
            'incoming' => $row,
            'old' => $layer,
            'differences' => $changes
        ];
    }


    protected function validateRelations(array $data): array
    {
        $errors = [];

        $supplierUids = collect($data['suppliers'])
            ->pluck('uid');

        $layupUids = collect($data['layups'])
            ->pluck('uid');

        foreach ($data['layups'] as $row) {

            $supplierExistsInDb =
                Supplier::where('uid', $row['supplier_uid'])
                    ->exists();

            $supplierExistsInImport =
                $supplierUids->contains($row['supplier_uid']);

            if (
                !$supplierExistsInDb &&
                !$supplierExistsInImport
            ) {
                $errors[] = [
                    'sheet' => 'Layups',
                    'uid' => $row['uid'],
                    'message' => 'Supplier UID does not exist',
                ];
            }
        }

        foreach ($data['layers'] as $row) {

            $layupExistsInDb =
                Layup::where('uid', $row['layup_uid'])
                    ->exists();

            $layupExistsInImport =
                $layupUids->contains($row['layup_uid']);

            if (
                !$layupExistsInDb &&
                !$layupExistsInImport
            ) {
                $errors[] = [
                    'sheet' => 'Layers',
                    'message' => 'Layup UID does not exist',
                ];
            }
        }

        return $errors;
    }


    protected function buildImportTree(array $data): array
    {
        return collect($data['suppliers'])
            ->map(function ($supplier) use ($data) {

                $layups = collect($data['layups'])
                    ->where('supplier_uid', $supplier['uid'])
                    ->map(function ($layup) use ($data) {

                        $layup['layers'] =
                            collect($data['layers'])
                                ->where('layup_uid', $layup['uid'])
                                ->values();

                        return $layup;
                    })
                    ->values();

                $supplier['layups'] = $layups;

                return $supplier;
            })
            ->values()
            ->toArray();
    }


    protected function normalizeValue($value)
    {
        if ($value === null) {
            return null;
        }


        if (is_numeric($value)) {

            return number_format(
                (float) $value,
                4,
                '.',
                ''
            );
        }


        return trim((string) $value);
    }
}
