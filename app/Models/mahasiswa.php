<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nim',
        'prodi',
        'email',
        'angkatan',
        'foto',
    ];

    public function mahasiswa()
    {
        return $this->hasMany(TugasAkhir::class, 'nama');
    }
}
