<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\mahasiswa;
use Illuminate\Http\Request;
use App\Exports\MahasiswaExport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
        public function index()
    {
        /* $mahasiswas = mahasiswa::all(); */
        $userId = auth()->id();
        $mahasiswas = Mahasiswa::where('user_id', $userId)->get();
        return view('pages.mahasiswas', compact('mahasiswas'));
    }

    public function filterData(Request $request)
    {
        $query = Mahasiswa::query();
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->input('search') . '%')->orwhere('nim', 'like', '%' . $request->input('search') . '%')->orwhere('angkatan', 'like', '%' . $request->input('search') . '%')->orwhere('prodi', 'like', '%' . $request->input('search') . '%');
        }

        // Lakukan paginate dengan jumlah item per halaman
        $mahasiswas = $query->paginate(5); // 10 adalah jumlah item per halaman

        return view('pages.mahasiswas', compact('mahasiswas'));
    }

    public function sinkrondata(){
        /* if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } */
        $response = Http::get('https://umkm-pnp.com/heni/index.php?folder=mahasiswa&file=index');

        if ($response->successful()) {
            $data = $response->json();
            foreach ($data['list'] as $index => $item) {
                $validator = Validator::make([
                    'nim' => $item['nim'],
                    'nama' =>$item['nama'],
                    'prodi' =>$item['prodi'],


                ], [
                    'nim'=> 'required|max:255|unique:mahasiswas',
                    'nama'=> 'required|max:255',
                    'prodi'=> 'required|max:255',

                ]);

                if ($validator->fails()) {
                    continue;
                }

                $tambahdata= mahasiswa::create([
                    'nim' => $item['nim'],
                    'nama' =>$item['nama'],
                    'prodi' =>$item['prodi'],
                    'email' => '-',
                    'angkatan'=>'-',
                ]);

                if(!$tambahdata){
                    continue;
                }
                /* logaktivitas::create([
                    'user_id'=>Auth::id(),
                    'aktivitas' => 'Menambah data dosen dengan id = '.$tambahdata->id
                ]); */
            }
            return back()->with('success','Data Berhasil di Sinkronisasi');
        }else{
            return redirect('\mahasiswas')->with('error', 'Data gagal di Sinkronisasi');
        }
    }



    public function export()
    {
        return Excel::download(new MahasiswaExport, 'mahasiswa.xlsx');
    }
    public function create()
    {
        return view('crud.mahasiswacreate');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|unique:mahasiswas,nim|max:255',
            'prodi' => 'required|string|max:255',
            'email' => 'required|email|unique:mahasiswas',
            'angkatan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $mahasiswaData = $request->all();

        if ($request->hasFile('foto')) {
            try {
                $fileName = time() . '.' . $request->foto->getClientOriginalExtension();
                $request->foto->storeAs('public/uploads', $fileName); // Store in 'public/uploads'
                $mahasiswaData['foto'] = $fileName;
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => 'Gagal mengunggah foto profil.'])->withInput();
            }
        }


        $mahasiswa = Mahasiswa::create($mahasiswaData);
        if($mahasiswa){
            User::create([
                'name' => $mahasiswaData['nama'],
                'level' => 'mahasiswa',
                'email' => $mahasiswaData['email'],
               /*  'angkatan' => '-', */
                'password' => Hash::make($mahasiswaData['nim'])
            ]);
        }

        $activityLogController = new ActivityLogController();
        $activityLogController->store('Menambahkan data mahasiswa dengan id = ' . $mahasiswa->id);

        return redirect()->route('mahasiswas.index')->with('success', 'Mahasiswa berhasil ditambahkan!');
    }
    public function import(Request $request)
    {

        // Validasi file yang diunggah
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);
        $file = $request->file('file');
        $path = $file->getRealPath();
        $spreadsheet = IOFactory::load($path);
        $sheet = $spreadsheet->getActiveSheet();

        $successCount = 0;
        $errorMessages = [];

        foreach ($sheet->getRowIterator() as $row) {
            // Lewati baris header
            if ($row->getRowIndex() == 1) {
                continue;
            }

            $rowData = [];
            foreach ($row->getCellIterator() as $cell) {
                $rowData[] = $cell->getValue();
            }
            // Validasi data mahasiswa
            $validator = Validator::make([
                'nama' => $rowData[1], // Sesuaikan indeks sesuai struktur data
                'nim' => $rowData[2], // Sesuaikan indeks sesuai struktur data
                'prodi' => $rowData[3], // Sesuaikan indeks sesuai struktur data
            ], [
                'nama' => 'required|max:255',
                'nim' => 'required|max:255|unique:mahasiswas',
                'prodi' => 'required|max:255',
            ]);

            if ($validator->fails()) {

                continue;
            }
            // Validasi berhasil, simpan data ke dalam basis data
            try {
                Mahasiswa::create([
                    'nama' => $rowData[1], // Sesuaikan indeks sesuai struktur data
                    'nim' => $rowData[2],  // Sesuaikan indeks sesuai struktur data
                    'prodi' => $rowData[3], // Sesuaikan indeks sesuai struktur data
                    'foto' => '-' // Sesuaikan indeks sesuai struktur data
                ]);
                $successCount++;
            } catch (\Exception $e) {
                continue;
            }
        }

        if ($successCount > 0) {
            return redirect('/mahasiswas')->with('success', 'Data Mahasiswa berhasil diimpor.');
        } else {
            return redirect('/mahasiswas')->with('error', 'Tidak ada data Mahasiswa yang valid diimpor.');
        }
    }


    public function show($id)
    {
        $mahasiswa = mahasiswa::findOrFail($id);

        return view('crud.mahasiswashow', compact('mahasiswa'));
    }


    public function edit(mahasiswa $mahasiswa)
    {
        return view('crud.mahasiswaedit', compact('mahasiswa'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|unique:mahasiswas,nim,' . $mahasiswa->id . '|max:255',
            'prodi' => 'required|string|max:255',
            'email' => '|email|unique:dosens,email,',
            'angkatan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $mahasiswaData = $request->all();

        if ($request->hasFile('foto')) {
            try {
                if ($mahasiswa->foto && Storage::exists('public/uploads/' . $mahasiswa->foto)) {
                    Storage::delete('public/uploads/' . $mahasiswa->foto);
                }

                $fileName = time() . '.' . $request->foto->getClientOriginalExtension();
                $request->foto->storeAs('public/uploads', $fileName);
                $mahasiswaData['foto'] = $fileName;
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => 'Gagal mengunggah foto profil.'])->withInput();
            }
        }

        $cek = User::where('email',$mahasiswa->email)->first();
        if($cek){
            $cek->update(['email' => $request->email]);
        }

        $mahasiswa->update($mahasiswaData);
        $activityLogController = new ActivityLogController();
        $activityLogController->store('Memperbaharui data mahasiswa dengan id = ' . $mahasiswa->id);

        return redirect()->route('mahasiswas.index')->with('success', 'Mahasiswa berhasil diubah!');
    }
    public function destroy(Mahasiswa $mahasiswa)
    {
        if ($mahasiswa->foto) {
            Storage::delete($mahasiswa->foto);
        }
        $cek = User::where('email',$mahasiswa->email)->first();
        if($cek){
            $cek->delete();
        }
        $mahasiswa->delete();
        $activityLogController = new ActivityLogController();
        $activityLogController->store('Menghapus data mahasiswa dengan id = ' . $mahasiswa->id);

        return redirect()->route('mahasiswas.index')->with('success', 'Mahasiswa berhasil dihapus!');
    }
}
