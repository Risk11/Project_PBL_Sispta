<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\sidang;
use App\Models\mahasiswa;
use App\Models\Penilaian;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;
use App\Exports\PenilaianExport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class PenilaianController extends Controller
{
    public function index()
    {
        $penilaians = Penilaian::with('dosenPenguji', 'tugasAkhir')->paginate(5);

        foreach ($penilaians as $penilaian) {
            Log::info('Penilaian: ', ['id' => $penilaian->id, 'dosenPenguji' => $penilaian->dosenPenguji]);
        }

        return view('pages.penilaian', compact('penilaians'));
    }
    public function export()
    {
        return Excel::download(new PenilaianExport, 'penilaian.xlsx');
    }

    public function create()
    {
        $tugasAkhir = TugasAkhir::all();
        $dosen = Dosen::all();

        return view(' crud.penilaiancreate', compact('tugasAkhir', 'dosen'));
    }
    public function tambah_penilaian($id){
        $sidang = sidang::find($id);
        $dosen = dosen::all();
        $datamahasiswa=mahasiswa::where('nama',$sidang->tugasAkhir->mahasiswa)->first();
        if(str_contains($datamahasiswa->prodi, 'D4')){
             return view('crud.tambahpenilaian',['nilai' => $sidang,'dosen' => $dosen]);
        }
        else{
             return view('crud.penilaianD3',['nilai' => $sidang,'dosen' => $dosen]);
        }


    }
    public function store(Request $request)
    {
        if($request->namaproses == "D4"){
           /*  dd('d4'); */
        $validator = Validator::make($request->all(), [
                'id_tugasakhir' => 'required|integer|exists:tugas_akhirs,id',
                'jabatan' => 'required|string',
                'id_dosen' => 'required|string|exists:dosens,id',
                'presentasi_sikap_penampilan' => 'required|numeric|min:0|max:100',
                'presentasi_komunikasi_sistematika' => 'required|numeric|min:0|max:100',
                'presentasi_penguasaan_materi' => 'required|numeric|min:0|max:100',
                'makalah_identifikasi_masalah' => 'required|numeric|min:0|max:100',
                'makalah_relevansi_teori' => 'required|numeric|min:0|max:100',
                'makalah_metode_algoritma' => 'required|numeric|min:0|max:100',
                'makalah_hasil_pembahasan' => 'required|numeric|min:0|max:100',
                'makalah_kesimpulan_saran' => 'required|numeric|min:0|max:100',
                'makalah_bahasa_tata_tulis' => 'required|numeric|min:0|max:100',
                'produk_kesesuaian_fungsional' => 'required|numeric|min:0|max:100',
                'komentar' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $totalNilai = $request->presentasi_sikap_penampilan * 0.05 +
                      $request->presentasi_komunikasi_sistematika * 0.05 +
                      $request->presentasi_penguasaan_materi * 0.20 +
                      $request->makalah_identifikasi_masalah * 0.05 +
                      $request->makalah_relevansi_teori * 0.05 +
                      $request->makalah_metode_algoritma * 0.10 +
                      $request->makalah_hasil_pembahasan * 0.15 +
                      $request->makalah_kesimpulan_saran * 0.05 +
                      $request->makalah_bahasa_tata_tulis * 0.05 +
                      $request->produk_kesesuaian_fungsional * 0.25;

                      $penilaian = Penilaian::create([
                        'id_tugasakhir' => $request->id_tugasakhir,
                        'jabatan' => $request->jabatan,
                        'id_dosen' => $request->id_dosen,
                        'nilai' => $totalNilai,
                        'komentar' => $request->komentar,
                    ]);
                    $activityLogController = new ActivityLogController();
                    $activityLogController->store('Memberi penilaian dengan id = ' . $penilaian->id);
        return redirect()->route('sidang.index')->with('success', 'Penilaian baru telah dibuat!');
        }else{
            /* dd("d3"); */
            $validator = Validator::make($request->all(), [
                'id_tugasakhir' => 'required|integer|exists:tugas_akhirs,id',
                'jabatan' => 'required|string',
                'id_dosen' => 'required|string|exists:dosens,id',
                'presentasi_sikap_penampilan' => 'required|numeric|min:0|max:100',
                'presentasi_komunikasi_sistematika' => 'required|numeric|min:0|max:100',
                'presentasi_penguasaan_materi' => 'required|numeric|min:0|max:100',
                'makalah_identifikasi_masalah' => 'required|numeric|min:0|max:100',
                'makalah_relevansi_teori' => 'required|numeric|min:0|max:100',
                'makalah_metode_algoritma' => 'required|numeric|min:0|max:100',
                'makalah_hasil_pembahasan' => 'required|numeric|min:0|max:100',
                'makalah_kesimpulan_saran' => 'required|numeric|min:0|max:100',
                'makalah_bahasa_tata_tulis' => 'required|numeric|min:0|max:100',
                'produk_kesesuaian_fungsional' => 'required|numeric|min:0|max:100',
                'komentar' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $totalNilai = $request->presentasi_sikap_penampilan * 0.05 +
                          $request->presentasi_komunikasi_sistematika * 0.05 +
                          $request->presentasi_penguasaan_materi * 0.20 +
                          $request->makalah_identifikasi_masalah * 0.05 +
                          $request->makalah_relevansi_teori * 0.05 +
                          $request->makalah_metode_algoritma * 0.10 +
                          $request->makalah_hasil_pembahasan * 0.15 +
                          $request->makalah_kesimpulan_saran * 0.05 +
                          $request->makalah_bahasa_tata_tulis * 0.05 +
                          $request->produk_kesesuaian_fungsional * 0.25;

                          $penilaian = Penilaian::create([
                            'id_tugasakhir' => $request->id_tugasakhir,
                            'jabatan' => $request->jabatan,
                            'id_dosen' => $request->id_dosen,
                            'nilai' => $totalNilai,
                            'komentar' => $request->komentar,
                        ]);

                        $activityLogController = new ActivityLogController();
                        $activityLogController->store('Memberi penilaian dengan id = ' . $penilaian->id);
            return redirect()->route('sidang.index')->with('success', 'Penilaian baru telah dibuat!');
        }
    }

    public function edit($id)
    {
        $penilaian = Penilaian::with('tugasAkhir', 'dosenPenguji')->findOrFail($id);
        $tugasAkhir = TugasAkhir::all();
        $dosen = Dosen::all();

        return view('crud.penilaianedit', compact('penilaian', 'tugasAkhir', 'dosen'));
    }
    public function update(Request $request, $id)
    {
        if($request->namaproses == "D4"){
            /*  dd('d4'); */
         $validator = Validator::make($request->all(), [
             'id_tugasakhir' => 'required|integer|exists:tugas_akhirs,id',
                'jabatan' => 'required|string',
                'id_dosen' => 'required|string|exists:dosens,id',
                'presentasi_sikap_penampilan' => 'required|numeric|min:0|max:100',
                'presentasi_komunikasi_sistematika' => 'required|numeric|min:0|max:100',
                'presentasi_penguasaan_materi' => 'required|numeric|min:0|max:100',
                'makalah_identifikasi_masalah' => 'required|numeric|min:0|max:100',
                'makalah_relevansi_teori' => 'required|numeric|min:0|max:100',
                'makalah_metode_algoritma' => 'required|numeric|min:0|max:100',
                'makalah_hasil_pembahasan' => 'required|numeric|min:0|max:100',
                'makalah_kesimpulan_saran' => 'required|numeric|min:0|max:100',
                'makalah_bahasa_tata_tulis' => 'required|numeric|min:0|max:100',
                'produk_kesesuaian_fungsional' => 'required|numeric|min:0|max:100',
                'komentar' => 'required|string',
         ]);

         if ($validator->fails()) {
             return redirect()->back()->withErrors($validator)->withInput();
         }

         $totalNilai = $request->presentasi_sikap_penampilan * 0.05 +
                       $request->presentasi_komunikasi_sistematika * 0.05 +
                       $request->presentasi_penguasaan_materi * 0.20 +
                       $request->makalah_identifikasi_masalah * 0.05 +
                       $request->makalah_relevansi_teori * 0.05 +
                       $request->makalah_metode_algoritma * 0.10 +
                       $request->makalah_hasil_pembahasan * 0.15 +
                       $request->makalah_kesimpulan_saran * 0.05 +
                       $request->makalah_bahasa_tata_tulis * 0.05 +
                       $request->produk_kesesuaian_fungsional * 0.25;

                       $penilaian = Penilaian::create([
                        'id_tugasakhir' => $request->id_tugasakhir,
                        'jabatan' => $request->jabatan,
                        'id_dosen' => $request->id_dosen,
                        'nilai' => $totalNilai,
                        'komentar' => $request->komentar,
                     ]);
                    $activityLogController = new ActivityLogController();
                    $activityLogController->store('Memperbaharui penilaian dengan id = ' . $penilaian->id);

         return redirect()->route('sidang.index')->with('success', 'Penilaian berhasil diperbaharui!');
         }else{
             /* dd("d3"); */
             $validator = Validator::make($request->all(), [
                 'id_tugasakhir' => 'required|integer|exists:tugas_akhirs,id',
                'jabatan' => 'required|string',
                'id_dosen' => 'required|string|exists:dosens,id',
                'presentasi_sikap_penampilan' => 'required|numeric|min:0|max:100',
                'presentasi_komunikasi_sistematika' => 'required|numeric|min:0|max:100',
                'presentasi_penguasaan_materi' => 'required|numeric|min:0|max:100',
                'makalah_identifikasi_masalah' => 'required|numeric|min:0|max:100',
                'makalah_relevansi_teori' => 'required|numeric|min:0|max:100',
                'makalah_metode_algoritma' => 'required|numeric|min:0|max:100',
                'makalah_hasil_pembahasan' => 'required|numeric|min:0|max:100',
                'makalah_kesimpulan_saran' => 'required|numeric|min:0|max:100',
                'makalah_bahasa_tata_tulis' => 'required|numeric|min:0|max:100',
                'produk_kesesuaian_fungsional' => 'required|numeric|min:0|max:100',
                'komentar' => 'required|string',
             ]);

             if ($validator->fails()) {
                 return redirect()->back()->withErrors($validator)->withInput();
             }

             $totalNilai = $request->presentasi_sikap_penampilan * 0.05 +
                           $request->presentasi_komunikasi_sistematika * 0.05 +
                           $request->presentasi_penguasaan_materi * 0.20 +
                           $request->makalah_identifikasi_masalah * 0.05 +
                           $request->makalah_relevansi_teori * 0.05 +
                           $request->makalah_metode_algoritma * 0.10 +
                           $request->makalah_hasil_pembahasan * 0.15 +
                           $request->makalah_kesimpulan_saran * 0.05 +
                           $request->makalah_bahasa_tata_tulis * 0.05 +
                           $request->produk_kesesuaian_fungsional * 0.25;

                           $penilaian = Penilaian::create([
                            'id_tugasakhir' => $request->id_tugasakhir,
                            'jabatan' => $request->jabatan,
                            'id_dosen' => $request->id_dosen,
                            'nilai' => $totalNilai,
                            'komentar' => $request->komentar,
                         ]);
                         $activityLogController = new ActivityLogController();
                         $activityLogController->store('Memperbaharui penilaian dengan id = ' . $penilaian->id);
             return redirect()->route('sidang.index')->with('success', 'Penilaian berhasi diperbaharui!');
         }
    }

    public function destroy($id)
    {
        $penilaian = Penilaian::findOrFail($id);
        $penilaian->delete();
        $activityLogController = new ActivityLogController();
        $activityLogController->store('Menghapus penilaian dengan id = ' . $penilaian->id);

        return redirect()->route('penilaian.index')->with('success', 'Penilaian telah dihapus!');
    }
}
