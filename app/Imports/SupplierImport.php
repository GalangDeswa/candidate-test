<?php

namespace App\Imports;

use App\Imports\Sheets\SuppliersSheetImport;
use App\Imports\Sheets\LayupsSheetImport;
use App\Imports\Sheets\LayersSheetImport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SupplierImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Suppliers' => new SuppliersSheetImport(),
            'Layups' => new LayupsSheetImport(),
            'Layers' => new LayersSheetImport(),
        ];
    }
}