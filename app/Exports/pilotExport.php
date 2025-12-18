<?php

namespace App\Exports;

use App\Models\Pilot;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class pilotExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $rowNumber = 0;
    public function collection()
    {
        return Pilot::all();
    }

    public function headings():array
    {
        return ['No','name','email','phone','license_number'];
    }

    public function map($pilot): array
    {
        return [
            ++$this->rowNumber,
            // Carbon
            $pilot->name,
            $pilot->email,
            // konkret tring+ : cotoh 10 +
            $pilot->phone,
            $pilot->license_number
            
        ];
    }
}