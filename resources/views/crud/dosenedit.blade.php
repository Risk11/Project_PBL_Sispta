@extends('layout.template')

@section('main')
    <div class="card text-center">
        <div class="card-header">
            <h1>Edit Dosen</h1>
        </div>
    </div>

    <div class="row py-3">
        <div class="col-md-6">
            <form action="{{ route('dosen.update', $dosen->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3 row">
                    <label for="nama" class="col-sm-4 col-form-label">Nama:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ $dosen->nama }}"
                            required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="nip" class="col-sm-4 col-form-label">NIP:</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="nip" name="nip" value="{{ $dosen->nip }}"
                            required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="no_telp" class="col-sm-4 col-form-label">No Telp:</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="no_telp" name="no_telp"
                            value="{{ $dosen->no_telp }}" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="email" class="col-sm-4 col-form-label">Email:</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control" id="email" name="email" value="{{ $dosen->email }}"
                            required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="foto" class="col-sm-4 col-form-label">Foto:</label>
                    <div class="col-sm-8">
                        <input type="file" class="form-control" id="foto" name="foto">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 offset-sm-4">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ url('/dosen') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
