<?php
namespace App\Exports;

use App\Models\Dosen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DosenExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Dosen::all();
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
            'Nama',
            'NIDN',
            'Jabatan',
            'Email',
            'Created At',
            'Updated At',
        ];
    }
}
