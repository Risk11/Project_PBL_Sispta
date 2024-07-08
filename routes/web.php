<?php

use App\Http\Middleware\isAdmin;
use App\Http\Middleware\ceklevel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
// use App\Http\Controllers\JadwalController;
use App\Http\Controllers\DosenController;
// use App\Http\Controllers\DokumenController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SidangController;
use App\Http\Controllers\RuanganController;
// use App\Http\Controllers\ProposalController;

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\mahasiswacontroller;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\TugasAkhirController;
use App\Http\Controllers\ActivityLogController;


/* Route::get('/', function () {
    return view('landingpage');
}); */
Route::get('/', function () {
    return view('landingpage3');
})->name('landingpage3');
Route::get('/login', function () {
    return view('pengguna.login');
});
Route::get('/layout', function () {
    return view('layout.template');
});
Route::get('/dasboard', function () {
    return view('pages.dasboard');
});
Route::get('/register', function () {
    return view('pengguna.login');
});
Route::post('/register', [RegisterController::class, 'register']);
Route::post('register', [RegisterController::class, 'register'])->name('register');
Route::post('/login', [LoginController::class, 'post_login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/import', [UserController::class, 'import'])->name('users.import');
    Route::get('/users', [UserController::class, 'filterData'])->name('users.index');


    Route::get('/exportuser', [UserController::class, 'export']);
    Route::get('change-password', [UserController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('change-password', [UserController::class, 'updatePassword'])->name('password.update');





    Route::get('/importMahasiswa', function () {
        return view('pages.importMahasiswa');
    });
    Route::get('/importDosen', function () {
        return view('pages.importDosen');
    });

    Route::get('/exportMahasiswa', function () {
        return view('pages.exportMahasiswa');
    });
    Route::get('/exportDosen', function () {
        return view('pages.exportDosen');
    });
    Route::get('/exportUser', function () {
        return view('pages.exportUser');
    });
    Route::get('/importUser', function () {
        return view('pages.importUser');
    });
    Route::get('/apiMahasiswa', function () {
        return view('pages.apiMahasiswa');
    });
    Route::get('/apiDosen', function () {
        return view('pages.apiDosen');
    });
    Route::get('/exportpenilaian', function () {
        return view('pages.exportpenilaian');
    });
    // Route::get('/jadwal', function () {
    //     return view('jadwal');
    // });
    // Route::get('/dokumen', function () {
    //     return view('dokumen');
    // });
    Route::get('/notifikasi', function () {
    return view('notifikasi');
    });
    // Route::get('/proposal', function () {
    //     return view('proposals');
    // });
    /* Route::get('/', function () {
    return view('dosen.layout.template');
*/
    //activity log
        Route::get('/activitylogs', [ActivityLogController::class, 'index'])->name('activitylogs.index');
        Route::post('/activitylogs', [ActivityLogController::class, 'store'])->name('activitylogs.store');

    //route dosen
    Route::get('/dosen', function () {
        return view('dosen');
    });
    Route::resource('dosen', DosenController::class);
    Route::get('/dosen/create', [DosenController::class, 'create'])->name('dosen.create');
    Route::get('/dosen/{id}/edit', 'DosenController@edit')->name('dosen.edit');
    Route::get('/dosenexport', [DosenController::class, 'export']);
    Route::post('/dosen/import', [DosenController::class, 'import'])->name('dosen.import');
    Route::post('/sinkronisasi-dosen', [DosenController::class, 'sinkrondata'])->name('sinkronisasi.dosen');
    Route::get('/dosen', [DosenController::class, 'filterData'])->name('dosen.index');


    //route mahasiswa
    Route::get('/mahasiswas', function () {
        return view('mahasiswa');
    });
    Route::resource('mahasiswas', MahasiswaController::class);
    Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'show'])->name('mahasiswa.show');
    Route::get('/mahasiswa/{id}/edit', 'MahasiswaController@edit')->name('mahasiswa.edit');
    Route::get('/mahasiswaexport', [MahasiswaController::class, 'export']);
    Route::post('/mahasiswas/import', [mahasiswaController::class, 'import'])->name('mahasiswas.import');
    Route::post('/sinkronisasi-mahasiswas', [MahasiswaController::class, 'sinkrondata'])->name('sinkronisasi.mahasiswas');
    Route::get('/mahasiswas', [MahasiswaController::class, 'filterData'])->name('mahasiswas.index');

    //Route ruangan
    Route::get('/ruangan', function () {
        return view('ruangan');
    });
    Route::resource('ruangan', RuanganController::class);
    Route::get('/ruangan/{ruangan}', [RuanganController::class, 'show'])->name('ruangan.show');
   /*  Route::get('/ruangan', [RuanganController::class, 'filterData'])->name('ruangan.index');
 */
    // Route tabel tugas akhir
    Route::get('/TugasAkhir', function () {
        return view('tugas_akhirs');
    });
    Route::resource('tugas_akhirs', TugasAkhirController::class);
    Route::post('/tugas_akhirs', [TugasAkhirController::class, 'store'])->name('tugas_akhirs.store');
    Route::get('/tugas_akhirs/create', [TugasAkhirController::class, 'create'])->name('tugas_akhirs.create');
    Route::put('/tugas_akhirs/{tugasAkhir}/edit', [TugasAkhirController::class, 'update'])->name('tugas_akhirs.update');
    Route::put('/tugas_akhirs/{tugasAkhir}', [TugasAkhirController::class, 'update'])->name('tugas_akhirs.update');
    Route::delete('/tugas_akhirs/{tugasAkhir}', [TugasAkhirController::class, 'destroy'])->name('tugas_akhirs.destroy');
    Route::get('/tugas_akhirs/{id}', [TugasAkhirController::class, 'show'])->name('tugas_akhirs.show');
    Route::get('tugas_akhirs/{id}/edit-status', [TugasAkhirController::class, 'editStatus'])->name('tugas_akhirs.editStatus');
    Route::post('tugas_akhirs/{id}/update-status', [TugasAkhirController::class, 'updateStatus'])->name('tugas_akhirs.updateStatus');
    Route::put('/tugas_akhirs/{tugasAkhir}/validasi', [TugasAkhirController::class, 'validasi'])->name('tugas_akhirs.validasi');
   /*  Route::get('/tugas_akhirs', [TugasAkhirController::class, 'filterData'])->name('tugas_akhirs.index');
 */
    //route jadwal
    //Route::resource('jadwal', JadwalController::class);
    //Route::resource('jadwal', JadwalController::class, [
    //  'except' => ['destroy']
    //]);
    //Route::get('/jadwal/{id}/download', [JadwalController::class, 'download']);


    //route penilaian
    Route::get('/penilaian', function () {
        return view('penilaian');
    });
    Route::resource('penilaian', PenilaianController::class);
    Route::get('/penilaian', [PenilaianController::class, 'index']);
    Route::get('/tambahpenilaian/{id}', [PenilaianController::class, 'tambah_penilaian']);
    Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::get('/penilaian/{id}', [PenilaianController::class, 'show'])->name('penilaian.show');
    Route::post('/penilaian', [PenilaianController::class, 'store'])->name('penilaian.store');
    Route::put('/penilaian/{id}', [PenilaianController::class, 'update'])->name('penilaian.update');
    Route::delete('/penilaian/{id}', [PenilaianController::class, 'destroy'])->name('penilaian.destroy');
    Route::get('/penilaianexport', [PenilaianController::class, 'export']);
    Route::get('/penilaianpdf', [PenilaianController::class, 'export']);
   /*  Route::get('/penilaian', [PenilaianController::class, 'filterData'])->name('penilaian.index'); */



    //route dokumen
    //Route::resource('dokumen', DokumenController::class);
    //Route::get('dokumen/create', [DokumenController::class, 'create'])->name('dokumen.create');
    //Route::post('dokumen', [DokumenController::class, 'store'])->name('dokumen.store');
    //Route::get('dokumen', [DokumenController::class, 'index'])->name('dokumen.index');
    //Route::get('dokumen/{id}/edit', [DokumenController::class, 'edit'])->name('dokumen.edit');
    //Route::put('dokumen/{id}', [DokumenController::class, 'update'])->name('dokumen.update');
    //Route::get('dokumen/{id}', [DokumenController::class, 'show'])->name('dokumen.show');

    //notifikasi
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::get('/notifikasi/create', [NotifikasiController::class, 'create'])->name('notifikasi.create');
    Route::post('/notifikasi', [NotifikasiController::class, 'store'])->name('notifikasi.store');
    Route::get('/notifikasi/{notifikasi}', [NotifikasiController::class, 'show'])->name('notifikasi.show');
    Route::get('/notifikasi/{notifikasi}/edit', [NotifikasiController::class, 'edit'])->name('notifikasi.edit');
    Route::put('/notifikasi/{notifikasi}', [NotifikasiController::class, 'update'])->name('notifikasi.update');
    Route::delete('/notifikasi/{notifikasi}', [NotifikasiController::class, 'destroy'])->name('notifikasi.destroy');

    //* /proposal
    //Route::resource('proposals', ProposalController::class);
    //Route::get('/proposals/getMahasiswaName', [ProposalController::class, 'getMahasiswaName'])->name('proposals.getMahasiswaName');

    //sidang
    Route::resource('sidang', SidangController::class);
    Route::get('/sidang', [SidangController::class, 'index'])->name('sidang.index');
    Route::get('/sidangs', [SidangController::class, 'index'])->name('sidang.index');
    Route::get('/sidang/{id}', [SidangController::class, 'show'])->name('sidang.show');
    Route::post('/sidang/create', [SidangController::class, 'create'])->name('sidang.create');
    Route::post('/sidang', [SidangController::class, 'store'])->name('sidang.store');
    Route::get('/sidang/{id}/edit', [SidangController::class, 'edit'])->name('sidang.edit');
    Route::put('/sidang/{id}', [SidangController::class, 'update'])->name('sidang.update');
    Route::delete('/sidang/{id}', [SidangController::class, 'destroy'])->name('sidang.destroy');
    Route::get('/sidang/{id}/pdf', [SidangController::class, 'generatePDF'])->name('sidang.pdf');
    Route::get('/detailsidang', [SidangController::class, 'DetailSidang'])->name('detail.sidang');

   /*  Route::get('/sidang', [SidangController::class, 'filterData'])->name('sidang.index'); */
});



/* Route::get('/layout', function () {
    return view('layout.template');
}); */




