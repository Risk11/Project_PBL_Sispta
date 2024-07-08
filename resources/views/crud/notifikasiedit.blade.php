@extends('layout.template')

@section('main')
    <div class="row">
        <div class="col">
            <h1 class="mb-4">Edit Notifikasi</h1>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <form action="{{ route('notifikasi.update', $notifikasi->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="judul">Judul:</label>
                    <input type="text" class="form-control" id="judul" name="judul" value="{{ $notifikasi->judul }}"
                        required>
                </div>
                <div class="form-group">
                    <label for="isi">Isi:</label>
                    <textarea class="form-control" id="isi" name="isi" rows="5" required>{{ $notifikasi->isi }}</textarea>
                </div>
                <div class="form-group">
                    <label for="user_id"">Penerima:</label>
                    <input type="text" class="form-control" id="user_id"" name="user_id""
                        value="{{ $notifikasi->penerima }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
