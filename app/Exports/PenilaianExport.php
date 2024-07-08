<?php

namespace App\Exports;

use App\Models\Penilaian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PenilaianExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Penilaian::all();
    }

    /**
     * Return the headings for the spreadsheet.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Mahasiswa',
            'Dosen',
            'Nilai',
            'Created At',
            'Updated At',
        ];
    }
}
