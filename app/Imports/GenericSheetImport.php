<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GenericSheetImport implements ToArray, WithHeadingRow
{
    public array $rows = [];

    public function array(array $rows)
    {
        $this->rows = $rows;
    }
}
