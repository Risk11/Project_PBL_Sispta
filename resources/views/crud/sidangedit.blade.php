@extends('layout.template')

@section('main')
    <div class="card text-center mb-2">
        <div class="card-header">
            <h1>Edit Jadwal</h1>
        </div>
    </div>

    <form action="{{ route('sidang.update', $sidang->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="id_tugasakhir" class="form-label">ID Tugas Akhir</label>
            <select name="id_tugasakhir" id="id_tugasakhir" class="form-select" required>
                <option value="">Pilih Judul Tugas Akhir</option>
                @foreach ($tugasAkhirs as $tugasAkhir)
                    <option value="{{ $tugasAkhir->id }}" @if ($tugasAkhir->id == $sidang->id_tugasakhir) selected @endif>
                        {{ $tugasAkhir->Judul }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $sidang->tanggal }}"
                required>
        </div>
        <div class="mb-3">
            <label for="ruangan" class="form-label">Ruangan</label>
            <select name="ruangan" id="ruangan" class="form-select" required>
                <option value="">Pilih Ruangan</option>
                @foreach ($ruangans as $ruangan)
                    <option value="{{ $ruangan->id }}" @if ($ruangan->id == $sidang->ruangan) selected @endif>
                        {{ $ruangan->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="sesi" class="form-label">Sesi</label>
            <div>
                @foreach ([1, 2, 3, 4, 5] as $sesi)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sesi" id="sesi{{ $sesi }}"
                            value="{{ $sesi }}" @if ($sesi == $sidang->sesi) checked @endif required>
                        <label class="form-check-label" for="sesi{{ $sesi }}">{{ $sesi }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="mb-3">
            <label for="ketua_sidang" class="form-label">Ketua sidang (Pilih nama dosen)</label>
            <select name="ketua_sidang" id="ketua_sidang" class="form-select" required>
                <option value="">Pilih ketua Sidang</option>
                @foreach ($dosens as $dosen)
                    <option value="{{ $dosen->id }}" @if ($dosen->id == $sidang->ketua_sidang) selected @endif>
                        {{ $dosen->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="sekretaris_sidang" class="form-label">sekretaris_sidang (Pilih nama dosen)</label>
            <select name="sekretaris_sidang" id="sekretaris_sidang" class="form-select" required>
                <option value="">Pilih Sekretaris Sidang</option>
                @foreach ($dosens as $dosen)
                    <option value="{{ $dosen->id }}" @if ($dosen->id == $sidang->sekretaris_sidang) selected @endif>
                        {{ $dosen->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="penguji1" class="form-label">penguji1 (Pilih nama dosen)</label>
            <select name="penguji1" id="penguji1" class="form-select" required>
                <option value="">Pilih penguji1</option>
                @foreach ($dosens as $dosen)
                    <option value="{{ $dosen->id }}" @if ($dosen->id == $sidang->penguji1) selected @endif>
                        {{ $dosen->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="penguji2" class="form-label">penguji2 (Pilih nama dosen)</label>
            <select name="penguji2" id="penguji2" class="form-select" required>
                <option value="">Pilih penguji2</option>
                @foreach ($dosens as $dosen)
                    <option value="{{ $dosen->id }}" @if ($dosen->id == $sidang->penguji2) selected @endif>
                        {{ $dosen->nama }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary mb-3">Submit</button>
    </form>
@endsection
