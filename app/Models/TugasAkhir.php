<?php

namespace App\Models;

use App\Models\Dosen;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TugasAkhir extends Model
{
    use HasFactory;

    protected $fillable = [
        'Judul',
        'mahasiswa',
        'pembimbing1',
        'pembimbing2',
        'dokumen',
        /* 'status', */
    ];
    /* protected $attributes = [
        'status' => 'Menunggu',
    ]; */

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa');
    }

    public function pembimbing1()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing1', 'id');
    }

    public function pembimbing2()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing2', 'id');
    }

    public function penilaians()
    {
        return $this->hasOne(Penilaian::class, 'id_tugasakhir');
    }
}
