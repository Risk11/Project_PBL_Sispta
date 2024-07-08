<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\mahasiswa;
use Illuminate\Support\Str;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ActivityLogController;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::user()->level != "Admin") {
            return abort(403);
        }
        /* $this->authorize('viewAny', User::class); */
        $users = User::all();
        return view('pengguna.users', compact('users'));
    }

    public function filterData(Request $request)
    {
        $query = User::query();

        // Lakukan filter berdasarkan input request yang diterima
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%')->orwhere('email', 'like', '%' . $request->input('search') . '%')->orwhere('level', 'like', '%' . $request->input('search') . '%');
        }
        $users = $query->paginate(5); // 10 adalah jumlah item per halaman

        return view('pengguna.users', compact('users'));
    }

    public function showChangePasswordForm()
    {
        return view('pengguna.change-password');
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function import(Request $request)
{
    /* if (!Gate::allows('isAdmin')) {
        return redirect('/');
    }  */

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
        // Skip header row
        if ($row->getRowIndex() == 1) {
            continue;
        }

        $rowData = [];

        foreach ($row->getCellIterator() as $cell) {
            $rowData[] = $cell->getValue();
        }

        // Validasi data
        $validator = Validator::make([
            'name' => $rowData[1], // Adjust index according to your data structure
            'level' => $rowData[2], // Adjust index according to your data structure
            'email' => $rowData[3], // Adjust index according to your data structure
            'password' => $rowData[4]  // Adjust index according to your data structure
        ], [
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'email' => 'required|max:255|email|unique:users',
            'password' => '-'
        ]);

        if ($validator->fails()) {
            continue;
        }

        // Validasi berhasil, simpan data ke dalam basis data
        try {
            $user = User::create([
                'name' => $rowData[1], // Adjust index according to your data structure
                'level' => $rowData[2],  // Adjust index according to your data structure
                'email' => $rowData[3], // Adjust index according to your data structure
                'password' => Hash::make($rowData[4]), // Adjust index according to your data structure
            ]);
            $successCount++;
            /* if ($user) {
                logaktivitas::create([
                    'user_id' => Auth::id(),
                    'aktivitas' => 'Menambah data user dengan id = ' . $user->id
                ]);
                $successCount++;
            } else {
                $errorMessages[] = "Row {$row->getRowIndex()}: Gagal menyimpan data user.";
            } */
        } catch (\Exception $e) {
            continue;
        }
    }
        $activityLogController = new ActivityLogController();
        $activityLogController->store('Mengimport data pengguna dengan id = ' . $user->id);

    if ($successCount > 0) {
        return redirect('/users')->with('success', 'Data User berhasil diimpor.');
    } else {
        return redirect('/users')->with('error', 'Tidak ada data User yang valid diimpor.');
    }
}


    public function create()
    {
       /*  $this->authorize('create', User::class); */
        return view('pengguna.usercreate');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'level' => ['nullable', 'string', 'max:255'],
        ]);

        $cek = Dosen::where('email',$request->email)->first();
        if(!$cek){
            $cek = Mahasiswa::where('email',$request->email)->first();
            if(!$cek){
                return back()->with('error','Data Ini tidak terdaftar di sistem');
            }
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => $request->level,
        ]);



        $activityLogController = new ActivityLogController();
        $activityLogController->store('Menambah pengguna baru dengan id = ' . $user->id);
        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }
    public function show($id)
{
    $user = User::findOrFail($id);

    if ($user->level === 'mahasiswa') {
        $profile = Mahasiswa::where('email', $user->email)->firstOrFail();
        $type = 'mahasiswa';
    }elseif ($user->level === 'dosen') {
        $profile = Dosen::where('email', $user->email)->firstOrFail();
        $type = 'dosen';

    }elseif ($user->level === 'kaprodi') {
        $profile = Dosen::where('email', $user->email)->firstOrFail();
        $type = 'dosen';

    }
     else {
        abort(404, 'User level not supported');
    }

    return view('pengguna.usershow', compact('profile', 'type'));
}
    public function showProfile(Request $request)
    {
        $userId = $request->query('user');
        $user = User::find($userId);
        return view('pengguna.profilshow', ['user' => $user]);
    }

    public function editprofile($id)
    {
        $user = User::findOrFail($id);

        // Logika untuk menampilkan form edit berdasarkan level pengguna
        if ($user->level === 'mahasiswa') {
            // Jika pengguna adalah mahasiswa
            $profile = Mahasiswa::where('user_id', $user->id)->firstOrFail();
            return view('mahasiswa.edit', compact('profile'));
        } elseif ($user->level === 'dosen') {
            // Jika pengguna adalah dosen
            $profile = Dosen::where('user_id', $user->id)->firstOrFail();
            return view('dosen.edit', compact('profile'));
        } else {
            // Handle other user levels if needed
            abort(404); // Atau sesuaikan dengan logika aplikasi yang kamu punya
        }
    }

    // Fungsi untuk menyimpan perubahan dari form edit
    public function updateprofile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validasi data jika diperlukan
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            // Tambahkan validasi lainnya sesuai kebutuhan
        ]);

        // Update data pengguna berdasarkan levelnya
        if ($user->level === 'mahasiswa') {
            // Jika pengguna adalah mahasiswa
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->firstOrFail();
            $mahasiswa->nama = $validatedData['nama'];
            $mahasiswa->email = $validatedData['email'];
            // Tambahkan field lainnya jika ada
            $mahasiswa->save();

            return redirect()->route('users.show', $user->id)->with('success', 'Profil berhasil diperbarui.');
        } elseif ($user->level === 'dosen') {
            // Jika pengguna adalah dosen
            $dosen = Dosen::where('user_id', $user->id)->firstOrFail();
            $dosen->nama = $validatedData['nama'];
            $dosen->email = $validatedData['email'];
            // Tambahkan field lainnya jika ada
            $dosen->save();

            return redirect()->route('users.show', $user->id)->with('success', 'Profil berhasil diperbarui.');
        } else {
            // Handle other user levels if needed
            abort(404); // Atau sesuaikan dengan logika aplikasi yang kamu punya
        }
    }

    // Fungsi baru untuk operasi tambahan tanpa mengganggu edit yang sudah ada
    public function tambahanOperasi(Request $request)
    {
        // Logika untuk operasi tambahan di sini
        // Misalnya, operasi untuk menyimpan data tambahan atau logika lainnya

        return response()->json(['message' => 'Operasi tambahan berhasil dilakukan'], 200);
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pengguna.useredit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'level' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail($id);

        // Check if the user to be updated is an admin
        if (Auth()->user()->level == 'Admin' && $user->level == 'Admin') {
            return back()->with('error', 'You cannot update another admin!');
        }

        // Prevent changing the password if the user is an admin
        if (Auth()->user()->level == 'Admin' && $request->filled('password')) {
            return back()->with('error', 'kamu tidak bisa mengedit password!');
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if (Auth()->user()->level != 'Admin' && $request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $cek = Dosen::where('email', $user->email)->first();
        if (!$cek) {
            $cek = Mahasiswa::where('email', $user->email)->first();
            if (!$cek) {
                return back()->with('error', 'Data Ini tidak terdaftar di sistem');
            }
        }
        $cek->update(['email' => $request->email]);

        $user->level = $request->level;
        $edit = $user->save();

        if (!$edit) {
            return back()->with('error', 'Data tidak berhasil disimpan');
        }

        $activityLogController = new ActivityLogController();
        $activityLogController->store('Memperbarui data pengguna dengan id = ' . $user->id);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Check if the user to be deleted is an admin
        if ($user->level == 'Admin') {
            return redirect()->route('users.index')->with('error', 'You cannot delete an admin user!');
        }

        $user->delete();
        $activityLogController = new ActivityLogController();
        $activityLogController->store('Menghapus data pengguna dengan id = ' . $user->id);

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}
