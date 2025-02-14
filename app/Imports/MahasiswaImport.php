<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;

class MahasiswaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Mahasiswa([
            'nama'  => $row['nama'], // Pastikan nama kolom sesuai dengan header di file Excel
            'nim'   => $row['nim'],
            'prodi' => $row['prodi'],
        ]);
    }
}
