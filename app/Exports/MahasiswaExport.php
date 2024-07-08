<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;

class MahasiswaExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Mahasiswa::all();
    }
    public function headings(): array
    {
        return [
            'id',
            'nama',
            'email',
            'Program Studi',
            'foto',
            'Created At',
            'Updated At',
        ];
    }
}
