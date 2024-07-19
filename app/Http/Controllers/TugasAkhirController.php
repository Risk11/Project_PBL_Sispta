<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Notifikasi;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TugasAkhirController extends Controller
{
    public function index()
    {
        if(Auth::user()->level == 'dosen'){
            $dosens = Dosen::where('email', Auth::user()->email)->first();
            $tugas_akhirs = TugasAkhir::where('pembimbing1',$dosens->nama)->orwhere('pembimbing2',$dosens->nama)->get();
        }elseif(Auth::user()->level == 'kaprodi'){
            $tugas_akhirs = TugasAkhir::all();
        }elseif(Auth::user()->level == 'mahasiswa'){
            $mahasiswa = mahasiswa::where('email',Auth::user()->email)->first();
            $tugas_akhirs = TugasAkhir::where('mahasiswa',$mahasiswa->nama)->get();
        } elseif(Auth::user()->level == 'Admin'){
            $tugas_akhirs = TugasAkhir::all();
        }
        $tugas_akhirs = TugasAkhir::paginate(5);
        return view('pages.tugas_akhirs', compact('tugas_akhirs'));
    }
    public function show($id)
    {
        $tugas_akhirs = TugasAkhir::findOrFail($id);

        return view('crud.tugas_akhirshow', compact('tugas_akhirs'));
    }

    public function validasi(Request $request, TugasAkhir $tugas_akhirs)
    {
        $role = $request->input('level');

        if ($role == 'pembimbing1') {
            $tugas_akhirs->validasi_pembimbing1 = true;
        } elseif ($role == 'pembimbing2') {
            $tugas_akhirs->validasi_pembimbing2 = true;
        }elseif ($role == 'ketua_sidang') {
            $tugas_akhirs->validasi_ketua_sidang = true;
        }elseif ($role == 'sekretaris_sidang') {
            $tugas_akhirs->validasi_sekretaris_sidang = true;
        }elseif ($role == 'penguji1') {
            $tugas_akhirs->validasi_penguji1 = true;
        }elseif ($role == 'penguji2') {
            $tugas_akhirs->validasi_penguji2 = true;
        }

        $tugas_akhirs->save();

        return redirect()->route('tugas_akhirs.show', $tugas_akhirs)->with('success', 'Dokumen berhasil divalidasi');
    }

    public function create()
    {
        $dosens = Dosen::all();
        $datamahasiswa = mahasiswa::all();
        $mahasiswalogin=Auth::user()->name;
        $mahasiswas = Mahasiswa::where('nama', 'like', '%' . $mahasiswalogin . '%')->first();

        return view('crud.tugas_akhircreate', compact('mahasiswas', 'dosens','datamahasiswa'));
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'Judul' => 'required|max:255',
        'mahasiswa' => 'required|exists:mahasiswas,nama',
        'pembimbing1' => 'required|exists:dosens,nama',
        'pembimbing2' => 'required|exists:dosens,nama',
        'dokumen_laporan_pkl' => 'nullable|file|mimes:pdf,doc,docx|max:7060',
        'dokumen_lembar_pembimbing' => 'nullable|file|mimes:pdf,doc,docx|max:7060',
        'dokumen_proposal_tugas_akhir' => 'nullable|file|mimes:pdf,doc,docx|max:7060',
        'dokumen_laporan_tugas_akhir' => 'nullable|file|mimes:pdf,doc,docx|max:7060',
        /* 'status' => 'nullable|max:255', */
    ]);

    $tugas_akhirs = new TugasAkhir();
    $tugas_akhirs->fill($validatedData);

    // Handle each document separately
    $documents = [
        'dokumen_laporan_pkl' => 'laporan_pkl',
        'dokumen_lembar_pembimbing' => 'lembar_pembimbing',
        'dokumen_proposal_tugas_akhir' => 'proposal_tugas_akhir',
        'dokumen_laporan_tugas_akhir' => 'laporan_tugas_akhir',
    ];

    foreach ($documents as $inputName => $documentType) {
        if ($request->hasFile($inputName)) {
            $filename = $request->file($inputName)->getClientOriginalName();
            $path = $request->file($inputName)->storeAs("public/upload/{$documentType}", $filename);
            $tugas_akhirs->$inputName = $path;
        }
    }

    $tugas_akhirs->save();

    // Log the activity
    $activityLogController = new ActivityLogController();
    $activityLogController->store('Membuat data tugas akhir dengan id = ' . $tugas_akhirs->id);

    return redirect()->route('tugas_akhirs.index')->with('success', 'Tugas akhir berhasil dibuat!');
}

    public function editStatus($id)
    {
        $tugas_akhirs = TugasAkhir::findOrFail($id);
        $statuses = ['Menunggu', 'Disetujui', 'Ditolak', 'Selesai'];
        return view('crud.edit_status', compact('tugas_akhirs', 'statuses'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|string|in:Menunggu,Disetujui,Ditolak,Selesai',
        ]);

        $tugas_akhirs = TugasAkhir::findOrFail($id);
        $tugas_akhirs->status = $validatedData['status'];
        $tugas_akhirs->save();

        // Log the activity
        $activityLogController = new ActivityLogController();
        $activityLogController->store('Mengubah status tugas akhir dengan id = ' . $tugas_akhirs->id);

        return redirect()->route('tugas_akhirs.show', $tugas_akhirs->id)->with('success', 'Status tugas akhir berhasil diperbarui!');
    }

    public function edit($id)
    {
        $tugas_akhirs = TugasAkhir::findOrFail($id);
        $mahasiswas = Mahasiswa::all();
        $dosens = Dosen::all();
        return view('crud.tugas_akhiredit', compact('tugas_akhirs', 'mahasiswas', 'dosens'));
    }
    public function update(Request $request, $id)
    {
        $tugas_akhirs = TugasAkhir::findOrFail($id);

        $validatedData = $request->validate([
            'Judul' => 'required|max:255',
            'mahasiswa' => 'required|exists:mahasiswas,nama',
            'pembimbing1' => 'required|exists:dosens,nama',
            'pembimbing2' => 'required|exists:dosens,nama',
            'dokumen_laporan_pkl' => 'nullable|file|mimes:pdf,doc,docx|max:7060',
            'dokumen_lembar_pembimbing' => 'nullable|file|mimes:pdf,doc,docx|max:7060',
            'dokumen_proposal_tugas_akhir' => 'nullable|file|mimes:pdf,doc,docx|max:7060',
            'dokumen_laporan_tugas_akhir' => 'nullable|file|mimes:pdf,doc,docx|max:7060',
            'status' => 'required|string|in:Menunggu,Disetujui,Ditolak,Selesai',
        ]);

        $tugas_akhirs->fill($validatedData);
        $documents = [
            'dokumen_laporan_pkl' => 'laporan_pkl',
            'dokumen_lembar_pembimbing' => 'lembar_pembimbing',
            'dokumen_proposal_tugas_akhir' => 'proposal_tugas_akhir',
            'dokumen_laporan_tugas_akhir' => 'laporan_tugas_akhir',
        ];

        foreach ($documents as $inputName => $documentType) {
            if ($request->hasFile($inputName)) {
                // Delete the old document if it exists
                if ($tugas_akhirs->$inputName) {
                    Storage::delete($tugas_akhirs->$inputName);
                }

                // Store the new document
                $filename = $request->file($inputName)->getClientOriginalName();
                $path = $request->file($inputName)->storeAs("public/upload/{$documentType}", $filename);
                $tugas_akhirs->$inputName = $path;
            }
        }

        $tugas_akhirs->save();
        $activityLogController = new ActivityLogController();
        $activityLogController->store('Memperbaharui data tugas akhir dengan id = ' . $tugas_akhirs->id);

        return redirect()->route('tugas_akhirs.index', $tugas_akhirs->id)->with('success', 'Tugas akhir berhasil diperbarui!');
    }
    private function buatnotifikasi($judul, $isi, $mahasiswa)
{
    Notifikasi::create([
        'judul' => $judul,
        'isi' => $isi,
        'user_id' => $mahasiswa->user_id,
    ]);
}
    public function destroy($id)
    {
        $tugas_akhirs = TugasAkhir::findOrFail($id);
        if ($tugas_akhirs->dokumen) {
            Storage::delete($tugas_akhirs->dokumen);
        }
        $tugas_akhirs->delete();
        $activityLogController = new ActivityLogController();
        $activityLogController->store('Menghapus data tugas akhir dengan id = ' . $tugas_akhirs->id);
        return redirect()->route('tugas_akhirs.index')->with('success', 'Tugas akhir berhasil dihapus!');
    }
}
