@extends('layout.template')

@section('main')
    <div class="card">
        <div class="card-body">
            <h1 class="text-center">Status Tugas Akhir</h1>
        </div>
    </div>
    <div>
        <form action="{{ route('tugas_akhirs.updateStatus', $tugas_akhirs->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" {{ $tugas_akhirs->status == $status ? 'selected' : '' }}>
                            {{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('tugas_akhirs.show', $tugas_akhirs->id) }}" class="btn btn-secondary">Kembali</a>
        </form>

    </div>
@endsection
