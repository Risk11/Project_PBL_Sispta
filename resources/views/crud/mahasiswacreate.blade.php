@extends('layout.template')

@section('main')
    <div>
        <div class="card text-center mb-2">
            <div class="card-header">
                <h1>Tambah Mahasiswa</h1>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('mahasiswas.store') }}" method="POST" enctype="multipart/form-data"> @csrf

            <div class="form-group">
                <label for="nim">NIM:</label>
                <input type="number" name="nim" class="form-control" id="nim" placeholder="Masukkan NIM">
            </div>

            <div class="form-group">
                <label for="nama">Nama Mahasiswa:</label>
                <input type="text" name="nama" class="form-control" id="nama"
                    placeholder="Masukkan Nama Mahasiswa">
            </div>

            <div class="form-group">
                <label for="prodi">Prodi:</label>
                <select name="prodi" id="prodi" class="form-control">
                    <option value="">Pilih Prodi</option>
                    <option value="D3 TK">D3 TK</option>
                    <option value="D4 TRPL">D4 TRPL</option>
                    <option value="D3 MI">D3 MI</option>
                    <option value="D4 ANIMASI">D4 ANIMASI</option>
                </select>
            </div>
            <div class="form-group">
                <label for="email" class="col-form-label">Email:</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan Email">
            </div>
            <div class="form-group">
                <label for="angkatan">Angkatan:</label>
                <input type="text" name="angkatan" class="form-control" id="angkatan" placeholder="Masukkan Angkatan">
            </div>
            <div class="form-group">
                <label for="foto">Foto (Optional):</label>
                <input type="file" name="foto" class="form-control" id="foto">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
