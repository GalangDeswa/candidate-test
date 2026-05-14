<?php

namespace App\Exports\Sheets;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class SuppliersSheetExport implements FromCollection, WithHeadings,WithTitle
{
    public function collection()
    {
        return Supplier::select(
            'uid',
            'name',
            'contact',
            'location',
            'material_certificate',
            'last_audit',
            'status'
        )->get();
    }

    public function headings(): array
    {
        return [
            'uid',
            'name',
            'contact',
            'location',
            'material_certificate',
            'last_audit',
            'status',
        ];
    }

     public function title(): string
    {
        return 'Suppliers';
    }
}