<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nama',
        'nip',
        'no_telp',
        'jabatan',
        'email',
        'foto',
    ];
    public function tugasAkhir()
    {
        return $this->hasMany(TugasAkhir::class, 'pembimbing1')
                    ->orWhere('pembimbing2', 'id'); // Specify foreign key on Dosen model
    }
    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'dosen_penguji');
    }

    public function dosenpenguji()
    {
        return $this->hasMany(Penilaian::class, 'id');
    }
}
