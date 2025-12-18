<?php

namespace App\Exports;

use App\Models\CoPilot;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class CoPilotExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $rowNumber = 0;
    public function collection()
    {
        return CoPilot::all();
    }

    public function headings():array
    {
        return ['No','name','license_number','date_of_birth','phone','address'];
    }

    public function map($CoPilot): array
    {
        return [
            ++$this->rowNumber,
            $CoPilot->name,
            $CoPilot->license_number,
            $CoPilot->date_of_birth,
            $CoPilot->phone,
            $CoPilot->address
            
        ];
    }
}