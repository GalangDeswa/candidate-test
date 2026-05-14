<?php

namespace App\Imports;

use App\Models\Layup;
use App\Models\Layer;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class LayupImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {

            $grouped = $rows->groupBy('uid');

            foreach ($grouped as $uid => $items) {

                $first = $items->first();

                $supplier = Supplier::where(
                    'name',
                    $first['supplier']
                )->first();

                $layup = Layup::create([
                    'uid' => $uid ?: 'LY-' . strtoupper(Str::random(6)),
                    'supplier_id' => $supplier?->id,
                    'name' => $first['name'],
                    'species' => $first['species'],
                    'grade' => $first['grade'],
                    'revision' => $first['revision'],
                    'status' => $first['status'],
                ]);

                foreach ($items as $row) {

                    Layer::create([
                        'layup_id' => $layup->id,
                        'layer_order' => $row['layer_order'],
                        'thickness' => $row['thickness'],
                        'width' => $row['width'],
                        'angle' => $row['angle'],
                        'grade' => $row['layer_grade'],
                    ]);
                }
            }
        });
    }
}