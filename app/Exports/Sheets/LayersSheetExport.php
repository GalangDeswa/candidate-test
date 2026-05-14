<?php

namespace App\Exports\Sheets;

use App\Models\Layer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class LayersSheetExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return Layer::with('layup')
            ->get()
            ->map(function ($layer) {
                return [
                    'layup_uid' => $layer->layup?->uid,
                    'layer_order' => $layer->layer_order,
                    'thickness' => $layer->thickness,
                    'width' => $layer->width,
                    'angle' => $layer->angle,
                    'grade' => $layer->grade,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'layup_uid',
            'layer_order',
            'thickness',
            'width',
            'angle',
            'grade',
        ];
    }

            public function title(): string
    {
        return 'Layers';
    }
}