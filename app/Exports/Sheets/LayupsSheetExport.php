<?php

namespace App\Exports\Sheets;

use App\Models\Layup;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class LayupsSheetExport implements FromCollection, WithHeadings,WithTitle
{
    public function collection()
    {
        return Layup::with('supplier')
            ->get()
            ->map(function ($layup) {
                return [
                    'uid' => $layup->uid,
                    'supplier_uid' => $layup->supplier?->uid,
                    'name' => $layup->name,
                    'species' => $layup->species,
                    'grade' => $layup->grade,
                    'revision' => $layup->revision,
                    'status' => $layup->status,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'uid',
            'supplier_uid',
            'name',
            'species',
            'grade',
            'revision',
            'status',
        ];
    }

        public function title(): string
    {
        return 'Layups';
    }
}