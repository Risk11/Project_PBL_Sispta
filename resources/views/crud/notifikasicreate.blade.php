@extends('layout.template')

@section('main')
    <div class="row">
        <div class="col">
            <h1 class="mb-4">Tambah Notifikasi</h1>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <form action="{{ route('notifikasi.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="judul">Nama Pengirim:</label>
                    <input type="text" class="form-control" id="judul" name="judul" required>
                </div>
                <div class="form-group">
                    <label for="isi">Isi:</label>
                    <textarea class="form-control" id="isi" name="isi" rows="5" required></textarea>
                </div>
                <div class="form-group">
                    <label for="email">Penerima:</label>
                    <input type="text" class="form-control" id="email" name="email" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
