@extends('layout.template')

@section('main')
    <div class="card text-center mb-2">
        <div class="card-header">
            <h1>Edit Data Tugas Akhir</h1>
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

    <form action="{{ route('tugas_akhirs.update', $tugas_akhirs->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="judul">Judul:</label>
            <input type="text" name="Judul" id="judul" class="form-control" value="{{ $tugas_akhirs->Judul }}">
        </div>

        <div class="form-group">
            <label for="mahasiswa">Mahasiswa:</label>
            <select name="mahasiswa" id="mahasiswa" class="form-control">
                <option value="">Pilih Mahasiswa</option>
                @foreach ($mahasiswas as $mahasiswa)
                    <option value="{{ $mahasiswa->nama }}"
                        {{ $tugas_akhirs->mahasiswa == $mahasiswa->nama ? 'selected' : '' }}>
                        {{ $mahasiswa->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="pembimbing1">Pembimbing 1:</label>
            <select name="pembimbing1" id="pembimbing1" class="form-control">
                <option value="">Pilih Dosen</option>
                @foreach ($dosens as $dosen)
                    <option value="{{ $dosen->nama }}" {{ $tugas_akhirs->pembimbing1 == $dosen->nama ? 'selected' : '' }}>
                        {{ $dosen->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="pembimbing2">Pembimbing 2 (optional):</label>
            <select name="pembimbing2" id="pembimbing2" class="form-control">
                <option value="">Pilih Dosen</option>
                @foreach ($dosens as $dosen)
                    <option value="{{ $dosen->nama }}" {{ $tugas_akhirs->pembimbing2 == $dosen->nama ? 'selected' : '' }}>
                        {{ $dosen->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="dokumen">Dokumen Tugas Akhir:</label>
            <input type="file" name="dokumen" id="dokumen" class="form-control">
        </div>

        <div class="form-group" style="display: flex;">
            <label for="status" style="margin-right: 10px;">Status:</label>
        </div>
        <div style="display: flex;">
            <div style="margin-right: 10px;">
                <input type="checkbox" id="status_menunggu" name="status" value="Menunggu"
                    {{ $tugas_akhirs->status == 'Menunggu' ? 'checked' : '' }} onclick="toggleCheckboxes(this)">
                <label for="status_menunggu">Menunggu</label>
            </div>
            <div style="margin-right: 10px;">
                <input type="checkbox" id="status_disetujui" name="status" value="Disetujui"
                    {{ $tugas_akhirs->status == 'Disetujui' ? 'checked' : '' }} onclick="toggleCheckboxes(this)">
                <label for="status_disetujui">Disetujui</label>
            </div>
            <div style="margin-right: 10px;">
                <input type="checkbox" id="status_ditolak" name="status" value="Ditolak"
                    {{ $tugas_akhirs->status == 'Ditolak' ? 'checked' : '' }} onclick="toggleCheckboxes(this)">
                <label for="status_ditolak">Ditolak</label>
            </div>
            <div>
                <input type="checkbox" id="status_selesai" name="status" value="Selesai"
                    {{ $tugas_akhirs->status == 'Selesai' ? 'checked' : '' }} onclick="toggleCheckboxes(this)">
                <label for="status_selesai">Selesai</label>
            </div>
        </div>
        <script>
            function toggleCheckboxes(checkbox) {
                var checkboxes = document.getElementsByName('status');
                checkboxes.forEach(function(item) {
                    if (item !== checkbox) {
                        item.checked = false;
                    }
                });
            }
        </script>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection
