@extends('layout.template')

@section('main')
    <div class="card text-center mb-2">
        <div class="card-header">
            <h1>Edit Ruangan</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('ruangan.update', $ruangan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nama">Nama Ruangan:</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $ruangan->nama }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="kapasitas">Kapasitas:</label>
                    <input type="number" min="1" class="form-control" id="kapasitas" name="kapasitas"
                        value="{{ $ruangan->kapasitas }}" required>
                </div>

                <div class="form-group">
                    <label for="status">Status:</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="tersedia" {{ $ruangan->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="tidak tersedia" {{ $ruangan->status == 'tidak tersedia' ? 'selected' : '' }}>Tidak
                            Tersedia</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('ruangan.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
