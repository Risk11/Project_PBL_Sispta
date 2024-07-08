<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sidang extends Model
{
    use HasFactory;

    protected $table = 'sidangs';
    protected $fillable = [
        'id_tugasakhir',
        'tanggal',
        'ruangan_id',
        'sesi',
        'ketua_sidang',
        'sekretaris_sidang',
        'penguji1',
        'penguji2',
        'anggota',
        'status_kelulusan'
    ];

    public function tugasAkhir()
    {
        return $this->belongsTo(TugasAkhir::class, 'id_tugasakhir');
    }


    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'id_tugasakhir');
    }
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }
}
