<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Sidang;
use App\Models\Ruangan;
use App\Models\mahasiswa;
use App\Models\Penilaian;
use App\Models\Notifikasi;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\Validator;


class SidangController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::user()->level == 'dosen'){
        $dosens = Dosen::where('email', Auth::user()->email)->first();
        $sidangs = Sidang::where('ketua_sidang',$dosens->id)->orwhere('sekretaris_sidang',$dosens->id)->orwhere('penguji1',$dosens->id)->orwhere('penguji2',$dosens->id)->get();
        $tugasakhirs = TugasAkhir::where('pembimbing1', $dosens->nama)
                                        ->orWhere('pembimbing2', $dosens->nama)
                                        ->get();

        $tugasAkhirIds = $tugasakhirs->pluck('id')->toArray();
        $sidangs1 = Sidang::whereIn('id_tugasakhir', $tugasAkhirIds)->get();
        $sidangs = Sidang::paginate(10);

        return view('pages.sidang', compact('sidangs1','sidangs'));

    } elseif (Auth::user()->level == 'kaprodi') {
        $sidangs = Sidang::all();
        return view('pages.sidang', compact('sidangs'));
    } elseif (Auth::user()->level == 'Admin') {
        $sidangs = Sidang::all();
        return view('pages.sidang', compact('sidangs'));
    } else {
        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
    }

    }
    public function filterData(Request $request)
    {
        $query = Sidang::query();
        if ($request->filled('search')) {
            $query->where('id_tugasakhir', 'like', '%' . $request->input('search') . '%');
        }
        $sidangs = $query->paginate(5);
        $sidangs = Sidang::paginate(5);
        return view('pages.sidang', compact('sidangs'));
    }
    public function print($id)
    {
        $sidang = Sidang::findOrFail($id);
        $data = ['sidang' => $sidang];
        $pdf = Pdf::loadView('crud.sidangshow', $data);
        return $pdf->download('sidang_' . $id . '.pdf');
    }
    public function create()
    {
        $tugasAkhirs = TugasAkhir::all();
        $ruangans = Ruangan::all();
        $dosens = Dosen::all();
        return view('crud.sidangcreate', compact('tugasAkhirs', 'ruangans', 'dosens'));
    }

    public function store(Request $request)
{
    $request->validate([
        'id_tugasakhir' => 'required',
        'tanggal' => 'required',
        'ruangan' => 'required',
        'sesi' => 'required',
        'ketua_sidang' => 'required',
        'sekretaris_sidang' => 'required',
        'penguji1' => 'required',
        'penguji2' => 'required',
        /* 'anggota' => 'required', */
        /* 'status_kelulusan' => 'required', */
    ]);

    // Check if the examiners are already assigned on the same date
    $tanggal = $request->input('tanggal');
    $penguji1 = $request->input('penguji1');
    $penguji2 = $request->input('penguji2');
    $ketua_sidang = $request->input('ketua_sidang');
    $sekretaris_sidang = $request->input('sekretaris_sidang');

    $existingSidang = Sidang::where('tanggal', $tanggal)
        ->where(function ($query) use ($penguji1, $penguji2, $ketua_sidang, $sekretaris_sidang) {
            $query->where('penguji1', $penguji1)
                ->orWhere('penguji1', $penguji2)
                ->orWhere('penguji1', $ketua_sidang)
                ->orWhere('penguji1', $sekretaris_sidang)
                ->orWhere('penguji2', $penguji1)
                ->orWhere('penguji2', $penguji2)
                ->orWhere('penguji2', $ketua_sidang)
                ->orWhere('penguji2', $sekretaris_sidang)
                ->orWhere('ketua_sidang', $penguji1)
                ->orWhere('ketua_sidang', $penguji2)
                ->orWhere('ketua_sidang', $ketua_sidang)
                ->orWhere('ketua_sidang', $sekretaris_sidang)
                ->orWhere('sekretaris_sidang', $penguji1)
                ->orWhere('sekretaris_sidang', $penguji2)
                ->orWhere('sekretaris_sidang', $ketua_sidang)
                ->orWhere('sekretaris_sidang', $sekretaris_sidang);
        })->exists();

    if ($existingSidang) {
        return back()->with('error', 'Salah satu dosen sudah terdaftar sebagai penguji pada tanggal yang sama. Silakan pilih dosen lain.');
    }

    $sidang = new Sidang();
    $sidang->id_tugasakhir = $request->input('id_tugasakhir');
    $sidang->tanggal = $request->input('tanggal');
    $sidang->ruangan_id = $request->input('ruangan');
    $sidang->sesi = $request->input('sesi');
    $sidang->ketua_sidang = $ketua_sidang;
    $sidang->sekretaris_sidang = $sekretaris_sidang;
    $sidang->penguji1 = $penguji1;
    $sidang->penguji2 = $penguji2;
    $sidang->status_kelulusan = '-';

    $sidang->save();

    // Send notifications to all examiners (dosen)
    $dosens = [
        'ketua_sidang' => $sidang->ketua_sidang,
        'sekretaris_sidang' => $sidang->sekretaris_sidang,
        'penguji1' => $sidang->penguji1,
        'penguji2' => $sidang->penguji2,
    ];

    foreach ($dosens as $role => $dosenId) {
        $dosen = Dosen::find($dosenId);

        if (!$dosen) {
            continue; // Skip if dosen not found
        }

        $user = User::where('email', $dosen->email)->first();

        if (!$user) {
            continue; // Skip if user not found
        }

        $this->buatnotifikasi(
            'Pemberitahuan',
            "Sidang dengan ID {$sidang->id} dijadwalkan pada tanggal {$sidang->tanggal}, di ruangan {$sidang->ruangan}, dengan peran sebagai {$role}",
            $user->id
        );
    }

    // Notify the student involved in the thesis
    try {
        $tugasakhir = Tugasakhir::findOrFail($sidang->id_tugasakhir);
        $mahasiswa = Mahasiswa::where('nama', $tugasakhir->mahasiswa)->firstOrFail();
        $mahasiswa = User::where('email', $mahasiswa->email)->firstOrFail();

        // Ambil data dosen-dosen terkait
        $ketuaSidang = Dosen::find($sidang->ketua_sidang);
        $sekretarisSidang = Dosen::find($sidang->sekretaris_sidang);
        $penguji1 = Dosen::find($sidang->penguji1);
        $penguji2 = Dosen::find($sidang->penguji2);

        $this->buatnotifikasi(
            'Pemberitahuan',
            'Sidang dengan ID ' .$sidang->id. 'dijadwalkan pada tanggal'. $sidang->tanggal. 'di ruangan'. $sidang->ruangan. 'dengan Ketua sidang:' .$ketuaSidang->nama. 'Sekretaris sidang:' .$sekretarisSidang->nama. 'Penguji 1:' .$penguji1->nama. 'penguji 2:'. $penguji2->nama,
            $mahasiswa->id
        );
        $activityLogController = new ActivityLogController();
        $activityLogController->store('Menambahkan data sidang dengan id = ' . $sidang->id);
        return redirect()->route('sidang.index')->with('success', 'Sidang berhasil dibuat');
    } catch (\Exception $e) {
        return redirect()->route('sidang.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

private function buatnotifikasi($judul, $isi, $userId)
{
    Notifikasi::create([
        'judul' => $judul,
        'isi' => $isi,
        'user_id' => $userId,
    ]);
}


    public function show($id)
    {
        // Ambil sidang berdasarkan ID
        $sidang = Sidang::find($id);

        // Jika sidang tidak ditemukan, kembalikan 404
        if (!$sidang) {
            return abort(404);
        }
        $sidang = Sidang::with('ruangan')->find($id);
        // Ambil semua penilaian yang terkait dengan sidang
        $penilaians = Penilaian::where('id_tugasakhir', $sidang->id_tugasakhir)->get();

        // Inisialisasi variabel penilaian
        $penilaianpembimbing1 = null;
        $penilaianpembimbing2 = null;
        $penilaianketuasidang = null;
        $penilaiansekretarissidang = null;
        $penilaianpenguji1 = null;
        $penilaianpenguji2 = null;

        // Cari penilaian berdasarkan jabatan
        foreach ($penilaians as $penilaian) {
            if ($penilaian->jabatan === 'pembimbing1') {
                $penilaianpembimbing1 = $penilaian;
            } elseif ($penilaian->jabatan === 'pembimbing2') {
                $penilaianpembimbing2 = $penilaian;
            } elseif ($penilaian->jabatan === 'ketuasidang') {
                $penilaianketuasidang = $penilaian;
            } elseif ($penilaian->jabatan === 'sekretarissidang') {
                $penilaiansekretarissidang = $penilaian;
            } elseif ($penilaian->jabatan === 'penguji1') {
                $penilaianpenguji1 = $penilaian;
            } elseif ($penilaian->jabatan === 'penguji2') {
                $penilaianpenguji2 = $penilaian;
            }
        }


        // Hitung rata-rata jika nilai penilaian tersedia
        $ratapendidikan = null;
        if ($penilaianpembimbing1 && $penilaianpembimbing2) {
            $ratapendidikan = ($penilaianpembimbing1->nilai + $penilaianpembimbing2->nilai) / 2;
        }

        $ratapenguji = null;
        $jumlahPenguji = 0;
        $totalNilaiPenguji = 0;
        if ($penilaianketuasidang) {
            $totalNilaiPenguji += $penilaianketuasidang->nilai;
            $jumlahPenguji++;
        }
        if ($penilaiansekretarissidang) {
            $totalNilaiPenguji += $penilaiansekretarissidang->nilai;
            $jumlahPenguji++;
        }
        if ($penilaianpenguji1) {
            $totalNilaiPenguji += $penilaianpenguji1->nilai;
            $jumlahPenguji++;
        }
        if ($penilaianpenguji2) {
            $totalNilaiPenguji += $penilaianpenguji2->nilai;
            $jumlahPenguji++;
        }
        if ($jumlahPenguji > 0) {
            $ratapenguji = $totalNilaiPenguji / $jumlahPenguji;
        }

        $rataRata = null;
        if ($ratapendidikan !== null && $ratapenguji !== null) {
            $rataRata = ($ratapendidikan + $ratapenguji) / 2;
        }

        // Mengirimkan data ke view
        return view('crud.sidangshow', compact('sidang', 'penilaians', 'rataRata', 'penilaianpembimbing1', 'penilaianpembimbing2',
        'penilaianketuasidang', 'penilaiansekretarissidang', 'penilaianpenguji1', 'penilaianpenguji2', 'ratapendidikan', 'ratapenguji'));

    }




    public function edit($id)
    {
        $sidang = Sidang::findOrFail($id);
        $tugasAkhirs = TugasAkhir::all();
        $ruangans = Ruangan::all();
        $dosens = Dosen::all(); // Ambil semua data dosen untuk dropdown

        return view('crud.sidangedit', compact('sidang', 'tugasAkhirs', 'ruangans', 'dosens'));
    }

    public function update(Request $request, Sidang $sidang)
    {
        $validator = Validator::make($request->all(), [
            'id_tugasakhir' => 'required',
            'tanggal' => 'required|date',
            'ruangan' => 'required',
            'sesi' => 'required',
            'ketua_sidang' => 'required',
            'sekretaris_sidang' => 'required',
            'penguji1' => 'required',
            'penguji2' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $sidang->id_tugasakhir = $request->id_tugasakhir;
        $sidang->tanggal = $request->tanggal;
        $sidang->ruangan_id = $request->ruangan_id;
        $sidang->sesi = $request->sesi;
        $sidang->ketua_sidang = $request->ketua_sidang;
        $sidang->sekretaris_sidang = $request->sekretaris_sidang;
        $sidang->penguji1 = $request->penguji1;
        $sidang->penguji2 = $request->penguji2;

        $update = $sidang->save();

        if ($update) {
            $activityLogController = new ActivityLogController();
            $activityLogController->store('Memperbarui data sidang dengan id = ' . $sidang->id);
            return redirect()->route('sidang.index')->with('success', 'Data sidang berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui data sidang. Silakan coba lagi.');
        }
    }


    public function destroy(Sidang $sidang)
    {
        $sidang->delete();
        $activityLogController = new ActivityLogController();
        $activityLogController->store('Menghapus data sidang dengan id = ' . $sidang->id);
        return redirect()->route('sidang.index')->with('success', 'Sidang berhasil dihapus');
    }
}
