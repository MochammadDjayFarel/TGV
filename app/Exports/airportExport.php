<?php

namespace App\Exports;

use App\Models\Airport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class airportExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $rowNumber = 0;
    public function collection()
    {
        return Airport::all();
    }

    public function headings():array
    {
        return ['No','name','code','city','country'];
    }

    public function map($airport): array
    {
        return [
            ++$this->rowNumber,
            // Carbon
            $airport->name,
            $airport->code,
            // konkret tring+ : cotoh 10 +
            $airport->city,
            $airport->country
            
        ];
    }
}