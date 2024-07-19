<?php

namespace App\Models;

use App\Models\Dosen;
use App\Models\TugasAkhir;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penilaian extends Model
{
    use HasFactory;
    protected $table = 'penilaians';
    protected $fillable = [
        'id_tugasakhir',
        'jabatan',
        'id_dosen',
        'nilai',
        'komentar',
        'kategori',
    ];

    public function tugasAkhir()
    {
        return $this->belongsTo(TugasAkhir::class, 'id_tugasakhir');
    }

    public function dosenPenguji()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen');
    }
        public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen');
    }



    public function hitungTotalNilai($request)
    {
        $validatedData = $request->validate([
        ]);
        $totalNilai =
            ($validatedData['presentasi_sikap_penampilan'] * 0.05) +
            ($validatedData['presentasi_komunikasi_sistematika'] * 0.05) +
            ($validatedData['presentasi_penguasaan_materi'] * 0.20) +
            ($validatedData['makalah_identifikasi_masalah'] * 0.05) +
            ($validatedData['makalah_relevansi_teori'] * 0.05) +
            ($validatedData['makalah_metode_algoritma'] * 0.10) +
            ($validatedData['makalah_hasil_pembahasan'] * 0.15) +
            ($validatedData['makalah_kesimpulan_saran'] * 0.05) +
            ($validatedData['makalah_bahasa_tata_tulis'] * 0.05) +
            ($validatedData['produk_kesesuaian_fungsional'] * 0.25);

        return $totalNilai;
    }
}
