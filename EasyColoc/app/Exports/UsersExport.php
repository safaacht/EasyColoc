<?php

namespace App\Exports;

use App\Models\Membership;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Membership::select('id', 'name', 'email','type','left_at')->get();
    }

    public function headings(): array
    {
        return [
            'Id',
            'Name',
            'Email',
            'Type',
            'Left At'
        ];
    }
}
