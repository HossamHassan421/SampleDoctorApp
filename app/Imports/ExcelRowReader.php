<?php


namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ExcelRowReader  implements WithHeadingRow
{

    public function headingRow(): int
    {
        return 1; // Set the heading row number (1-based index)
    }

}
