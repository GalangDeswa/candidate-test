<?php

namespace App\Exports;

use App\Models\Layup;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LayupExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $rows = collect();

        $layups = Layup::with(['supplier', 'layers'])->get();

        foreach ($layups as $layup) {

            foreach ($layup->layers as $layer) {

                $rows->push([
                    'uid' => $layup->uid,
                    'supplier' => $layup->supplier?->name,
                    'name' => $layup->name,
                    'species' => $layup->species,
                    'grade' => $layup->grade,
                    'revision' => $layup->revision,
                    'status' => $layup->status,

                    'layer_order' => $layer->layer_order,
                    'thickness' => $layer->thickness,
                    'width' => $layer->width,
                    'angle' => $layer->angle,
                    'layer_grade' => $layer->grade,
                ]);
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'uid',
            'supplier',
            'name',
            'species',
            'grade',
            'revision',
            'status',

            'layer_order',
            'thickness',
            'width',
            'angle',
            'layer_grade',
        ];
    }
}