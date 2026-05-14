<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SupplierImportReader implements WithMultipleSheets
{
    public GenericSheetImport $suppliers;
    public GenericSheetImport $layups;
    public GenericSheetImport $layers;

    public function __construct()
    {
        $this->suppliers = new GenericSheetImport();
        $this->layups = new GenericSheetImport();
        $this->layers = new GenericSheetImport();
    }

    public function sheets(): array
    {
        return [
            'Suppliers' => $this->suppliers,
            'Layups' => $this->layups,
            'Layers' => $this->layers,
        ];
    }
}