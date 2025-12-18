<?php

namespace App\Exports;

use App\Models\Airline;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class airlineExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $rowNumber = 0;
    public function collection()
    {
        return Airline::all();
    }

    public function headings():array
    {
        return ['No','name','code','country'];
    }

    public function map($airline): array
    {
        return [
            ++$this->rowNumber,
            // Carbon
            $airline->name,
            $airline->code,
            // konkret tring+ : cotoh 10 +
            $airline->Country,
            
        ];
    }
}