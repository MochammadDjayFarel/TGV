<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class UserExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $rowNumber = 0;
    public function collection()
    {
        return User::all();
    }

    public function headings():array
    {
        return ['No','name','email','password','role'];
    }

    public function map($user): array
    {
        return [
            ++$this->rowNumber,
            // Carbon
            $user->name,
            $user->email,
            // konkret tring+ : cotoh 10 +
            $user->password,
            $user->role
            
        ];
    }
}