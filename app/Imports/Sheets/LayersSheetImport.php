<?php

namespace App\Imports\Sheets;

use App\Models\Layer;
use App\Models\Layup;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LayersSheetImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $layup = Layup::where(
            'uid',
            $row['layup_uid']
        )->first();

        if (!$layup) {
            return null;
        }

        return Layer::updateOrCreate(
            [
                'layup_id' => $layup->id,
                'layer_order' => $row['layer_order'],
            ],
            [
                'thickness' => $row['thickness'],
                'width' => $row['width'],
                'angle' => $row['angle'],
                'grade' => $row['grade'],
            ]
        );
    }
}