<?php

namespace App\Exports;

use App\Exports\Sheets\SuppliersSheetExport;
use App\Exports\Sheets\LayupsSheetExport;
use App\Exports\Sheets\LayersSheetExport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SupplierExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new SuppliersSheetExport(),
            new LayupsSheetExport(),
            new LayersSheetExport(),
        ];
    }
}