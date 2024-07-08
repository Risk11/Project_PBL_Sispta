@extends('layout.template')

@section('main')
    <div class="card text-center mb-2">
        <div class="card-header">
            <h1>Ajukan Tugas Akhir</h1>
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
    <div>
        <form action="{{ route('tugas_akhirs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="judul">Judul:</label>
                <input type="text" name="Judul" id="judul" class="form-control" value="{{ old('Judul') }}">
            </div>
            <div class="form-group">
                <label for="mahasiswa">Mahasiswa:</label>
                @if ($mahasiswas)
                    <input type="hidden" value="{{ $mahasiswas->nama }}" name="mahasiswa">
                    <input type="text" value="{{ $mahasiswas->nama }}" class="form-control" disabled>
                @else
                    <select name="mahasiswa" id="mahasiswa" class="form-control">
                        <option value="">Pilih Mahasiswa</option>
                        @foreach ($datamahasiswa as $mahasiswa)
                            <option value="{{ $mahasiswa->nama }}">{{ $mahasiswa->nama }}</option>
                        @endforeach
                    </select>
                @endif
            </div>

            <div class="form-group">
                <label for="pembimbing1">Pembimbing 1:</label>
                <select name="pembimbing1" id="pembimbing1" class="form-control">
                    <option value="">Pilih Dosen</option>
                    @foreach ($dosens as $dosen)
                        <option value="{{ $dosen->nama }}">{{ $dosen->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="pembimbing2">Pembimbing 2 (optional):</label>
                <select name="pembimbing2" id="pembimbing2" class="form-control">
                    <option value="">Pilih Dosen</option>
                    @foreach ($dosens as $dosen)
                        <option value="{{ $dosen->nama }}">{{ $dosen->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="dokumen_laporan_pkl">Laporan PKL</label>
                <input type="file" name="dokumen_laporan_pkl" id="dokumen_laporan_pkl" class="form-control">
            </div>
            <div class="form-group">
                <label for="dokumen_lembar_pembimbing">Dokumen Lembar Pembimbing</label>
                <input type="file" name="dokumen_lembar_pembimbing" id="dokumen_lembar_pembimbing" class="form-control">
            </div>
            <div class="form-group">
                <label for="dokumen_proposal_tugas_akhir">Proposal Tugas Akhir</label>
                <input type="file" name="dokumen_proposal_tugas_akhir" id="dokumen_proposal_tugas_akhir"
                    class="form-control">
            </div>
            <div class="form-group">
                <label for="dokumen_laporan_tugas_akhir">Laporan Tugas Akhir</label>
                <input type="file" name="dokumen_laporan_tugas_akhir" id="dokumen_laporan_tugas_akhir"
                    class="form-control">
            </div>
            {{-- <div class="form-group" style="display: flex;">
                <label for="status" style="margin-right: 10px;">Status:</label>
                </div>
                <div style="display: flex;">
                <div style="margin-right: 10px;">
                    <input type="checkbox" id="status_menunggu" name="status" value="Menunggu"
                        onclick="toggleCheckboxes(this)">
                    <label for="status_menunggu">Menunggu</label>
                </div>
                <div style="margin-right: 10px;">
                    <input type="checkbox" id="status_disetujui" name="status" value="Disetujui"
                        onclick="toggleCheckboxes(this)">
                    <label for="status_disetujui">Disetujui</label>
                </div>
                <div style="margin-right: 10px;">
                    <input type="checkbox" id="status_ditolak" name="status" value="Ditolak"
                        onclick="toggleCheckboxes(this)">
                    <label for="status_ditolak">Ditolak</label>
                </div>
                <div>
                    <input type="checkbox" id="status_selesai" name="status" value="Selesai"
                        onclick="toggleCheckboxes(this)">
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
            </script> --}}


            <button type="submit" class="btn btn-primary my-3">Simpan</button>
        </form>
    </div>
@endsection
