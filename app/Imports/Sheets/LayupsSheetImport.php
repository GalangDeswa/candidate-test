<?php

namespace App\Imports\Sheets;

use App\Models\Layup;
use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LayupsSheetImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $supplier = Supplier::where(
            'uid',
            $row['supplier_uid']
        )->first();

        if (!$supplier) {
            return null;
        }

        return Layup::updateOrCreate(
            ['uid' => $row['uid']],
            [
                'supplier_id' => $supplier->id,
                'name' => $row['name'],
                'species' => $row['species'],
                'grade' => $row['grade'],
                'revision' => $row['revision'],
                'status' => $row['status'],
            ]
        );
    }
}