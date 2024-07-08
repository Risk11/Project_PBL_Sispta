@extends('layout.template')

@section('main')
    <div>
        <div class="card text-center mb-2">
            <div class="card-header">
                <h1>Edit Mahasiswa</h1>
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

        <form action="{{ route('mahasiswas.update', $mahasiswa->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <div class="form-group">
                <label for="nim">NIM:</label>
                <input type="number" name="nim" class="form-control" id="nim"
                    value="{{ old('nim', $mahasiswa->nim) }}" placeholder="Masukkan NIM">
            </div>

            <div class="form-group">
                <label for="nama">Nama Mahasiswa:</label>
                <input type="text" name="nama" class="form-control" id="nama"
                    value="{{ old('nama', $mahasiswa->nama) }}" placeholder="Masukkan Nama Mahasiswa">
            </div>

            <div class="form-group">
                <label for="prodi">Prodi:</label>
                <select name="prodi" id="prodi" class="form-control">
                    <option value="">Pilih Prodi</option>
                    <option value="D3 TK" {{ $mahasiswa->prodi === 'D3 TK' ? 'selected' : '' }}>D3 TK</option>
                    <option value="D4 TRPL" {{ $mahasiswa->prodi === 'D4 TRPL' ? 'selected' : '' }}>D4 TRPL</option>
                    <option value="D3 MI" {{ $mahasiswa->prodi === 'D3 MI' ? 'selected' : '' }}>D3 MI</option>
                    <option value="D4 ANIMASI" {{ $mahasiswa->prodi === 'D4 ANIMASI' ? 'selected' : '' }}>D4 ANIMASI
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control" id="email"
                    value="{{ old('email', $mahasiswa->email) }}" placeholder="Masukkan Email">
            </div>
            <div class="form-group">
                <label for="angkatan">Angkatan:</label>
                <input type="text" name="angkatan" class="form-control" id="angkatan"
                    value="{{ old('angkatan', $mahasiswa->angkatan) }}" placeholder="Masukkan Angkatan">
            </div>
            <div class="form-group py-3">
                <label for="foto">Foto (Optional):</label>
                <input type="file" name="foto" class="form-control" id="foto">
                @if ($mahasiswa->foto)
                    <img src="{{ asset('storage/uploads/' . $mahasiswa->foto) }}" alt="{{ $mahasiswa->nama }}"
                        style="width:200px;height:300px;">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
