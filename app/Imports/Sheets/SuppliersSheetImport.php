<?php

namespace App\Imports\Sheets;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SuppliersSheetImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return Supplier::updateOrCreate(
            ['uid' => $row['uid']],
            [
                'name' => $row['name'],
                'contact' => $row['contact'],
                'location' => $row['location'],
                'material_certificate' => $row['material_certificate'],
                'last_audit' => $row['last_audit'],
                'status' => $row['status'],
            ]
        );
    }
}