@extends('layout.template')

@section('main')
    <div>
        <div class="card text-center mb-2">
            <div class="card-header">
                <h1>Tambah Dosen</h1>
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

        <form action="{{ route('dosen.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="nama" class="col-sm-2 col-form-label">Nama Dosen:</label>
                <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan Nama Dosen">

            </div>

            <div>
                <label for="nip" class="col-sm-2 col-form-label">NIP:</label>
                <input type="number" name="nip" class="form-control" id="nip" placeholder="Masukkan NIP">

            </div>

            <div>
                <label for="no_telp" class="col-sm-2 col-form-label">Nomor Telepon:</label>
                <input type="number" name="no_telp" class="form-control" id="no_telp"
                    placeholder="Masukkan Nomor Telepon">
            </div>
            <div>
                <label for="nip" class="col-form-label">Jabatan Akademik:</label>
                <input type="text" name="jabatan" class="form-control" id="jabatan" placeholder="Masukkan Jabatan">
            </div>
            <div>
                <label for="email" class="col-sm-2 col-form-label">Email:</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan Email">
            </div>

            <div>
                <label for="foto" class="col-sm-2 col-form-label">Foto (Optional):</label>
                <input type="file" name="foto" class="form-control" id="foto">
            </div>

            <button type="submit" class="btn btn-primary mt-2">Simpan</button>
        </form>
    </div>
@endsection
