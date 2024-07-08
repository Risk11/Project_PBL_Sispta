<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Exports\DosenExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class DosenController extends Controller
{
    public function index()
    {
        $dosens = Dosen::orderBy('nama')->get();
        return view('pages.dosen', compact('dosens'));
    }
    public function filterData(Request $request)
    {
        $query = Dosen::query();

        // Lakukan filter berdasarkan input request yang diterima
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->input('search') . '%')->where('nip', 'like', '%' . $request->input('search') . '%')->orwhere('jabatan', 'like', '%' . $request->input('search') . '%');
        }

        // Lakukan paginate dengan jumlah item per halaman
        $dosens = $query->paginate(5); // 10 adalah jumlah item per halaman

        return view('pages.dosen', compact('dosens'));
    }
    public function sinkrondata(){
        /* if (!Gate::allows('isAdmin')) {
            return redirect('/');
        } */
        $response = Http::get('https://umkm-pnp.com/heni/index.php?folder=dosen&file=index');

        if ($response->successful()) {
            $data = $response->json();
            foreach ($data['list'] as $index => $item) {
                $validator = Validator::make([
                    'nama' => $item['nama'],
                    'nip' =>$item['nip'],
                    'email' => $item['email']
                ], [
                    'nama'=> 'required|max:255',
                    'nip'=> 'required|max:255|unique:dosens',
                    'email'=> 'required|email|max:255|unique:dosens',
                ]);

                if ($validator->fails()) {
                    continue;
                }

                $tambahdata= Dosen::create([
                    'nama' => $item['nama'],
                    'nip' => $item['nip'],
                    'email' => $item['email'],
                    'jabatan'=>'-',
                    'no_telp' => '-'
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
            return redirect('\dosen')->with('error', 'Data gagal di Sinkronisasi');
        }
    }



        public function import(Request $request)
    {
        // Validasi file yang diunggah
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
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

            // Validasi data dosen
            $validator = Validator::make([
                'nama' => $rowData[1], // Sesuaikan indeks sesuai struktur data
                'nip' => $rowData[2],  // Sesuaikan indeks sesuai struktur data
                'no_telp' => $rowData[3], // Sesuaikan indeks sesuai struktur data
                'jabatan' => $rowData[4], // Sesuaikan indeks sesuai struktur data
                'email' => $rowData[5], // Sesuaikan indeks sesuai struktur data
            ], [
                'nama' => 'required|max:255',
                'nip' => 'required|max:255|unique:dosens',
                'no_telp' => 'required|max:15',
                'jabatan' => 'required|max:255',
                'email' => 'required|email|max:255|unique:dosens',
            ]);

            if ($validator->fails()) {
                continue;
            }

            // Validasi berhasil, simpan data ke dalam basis data
            try {
                Dosen::create([
                    'nama' => $rowData[1],  // Sesuaikan indeks sesuai struktur data
                    'nip' => $rowData[2],   // Sesuaikan indeks sesuai struktur data
                    'no_telp' => $rowData[3], // Sesuaikan indeks sesuai struktur data
                    'jabatan' => $rowData[4], // Sesuaikan indeks sesuai struktur data
                    'email' => $rowData[5],  // Sesuaikan indeks sesuai struktur data
                    'foto' => '-'            // Sesuaikan indeks sesuai struktur data
                ]);
                $successCount++;
            } catch (\Exception $e) {
                continue;
            }
        }

        if ($successCount > 0) {
            return redirect('/dosen')->with('success', "$successCount data dosen berhasil diimpor.");
        } else {
            return redirect('/dosen')->with('error', 'Tidak ada data dosen yang valid untuk diimpor.');
        }
    }

    public function export()
    {
        return Excel::download(new DosenExport, 'dosen.xlsx');
    }
    public function create()
    {
        return view('crud.dosencreate');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'nip' => 'required|unique:dosens',
            'no_telp' => 'required|string',
            'jabatan' => 'required|string',
            'email' => 'required|email|unique:dosens',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $dosenData = $request->all();

        if ($request->hasFile('foto')) {
            try {
                $fileName = time() . '.' . $request->foto->getClientOriginalExtension();
                $request->foto->storeAs('public/uploads', $fileName); // Store in 'public/uploads'
                $dosenData['foto'] = $fileName;
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => 'gagal mengunggah foto profil.'])->withInput();
            }
        }

        $dosen=Dosen::create($dosenData);
        if($dosen){
            User::create([
                'name' => $dosenData['nama'],
                'level' => 'dosen',
                'email' => $dosenData['email'],
                'password' => Hash::make($dosenData['nip'])
            ]);
        }
        $activityLogController = new ActivityLogController();
        $activityLogController->store('Menambah data dosen dengan id = ' . $dosen->id);

        return redirect()->route('dosen.index')->with('success', 'Dosen berhasil ditambahkan!');
    }

    public function show(Dosen $dosen)
    {
        return view('crud.dosenshow', compact('dosen'));
    }
    public function edit(string $id)
    {
        $dosen = Dosen::findOrFail($id);
        return view('crud.dosenedit', compact('dosen'));
    }

    public function update(Request $request, string $id)
    {
        if (! Gate::allows('update', $id)) {
            abort(403);
        }
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'nip' => 'required|unique:dosens,nip,' . $id,
            'no_telp' => 'required|string',
            'jabatan' => 'required|string',
            'email' => 'required|email|unique:dosens,email,' . $id,
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Perbaikan aturan validasi untuk 'foto'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $dosen = Dosen::findOrFail($id);
        $dosenData = $request->all();

        if ($request->hasFile('foto')) {
            try {
                $fileName = time() . '.' . $request->foto->getClientOriginalExtension();
                $request->foto->storeAs('public/uploads', $fileName);
                $dosenData['foto'] = $fileName;
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => 'Gagal mengunggah foto profil.'])->withInput();
            }
        }
        $cek = User::where('email',$dosen->email)->first();
        if($cek){
            $cek->update(['email' => $request->email]);
        }

        $dosen->update($dosenData);
        $activityLogController = new ActivityLogController();
        $activityLogController->store('Memperbarui data dosen dengan id = ' . $dosen->id);

        return redirect('/dosen')->with('success', 'Data berhasil diperbarui');
    }
    public function destroy($id)

    {
        $dosen=Dosen::find($id);
        $cek = User::where('email',$dosen->email)->first();
        if($cek){
            $cek->delete();
        }
        $dosen->delete();
        $activityLogController = new ActivityLogController();
        $activityLogController->store('Menghapus data dosen dengan id = ' . $dosen->id);
        return redirect('/dosen')->with('success','Data Berhasil Dihapus');
    }
}
