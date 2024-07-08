@extends('layout.template')

@section('main')
    <div class="card">
        <div class="card-header">
            <h1 class="text-center">Detail Tugas Akhir</h1>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Judul:</th>
                    <td>{{ $tugas_akhirs->Judul }}</td>
                </tr>
                <tr>
                    <th>Mahasiswa</th>
                    <td>{{ $tugas_akhirs->mahasiswa }}</td>
                </tr>
                {{-- <tr>
                    <th>Prodi:</th>
                    <td>{{ $tugas_akhirs->prodi }}</td>
                </tr> --}}
                <tr>
                    <th>Pembimbing1</th>
                    <td>{{ $tugas_akhirs->pembimbing1 }}</td>
                </tr>
                <tr>
                    <th>Pembimbing2</th>
                    <td>{{ $tugas_akhirs->pembimbing2 }}</td>
                </tr>


                <tr>
                    <th>Laporan PKL</th>
                    {{-- <td><a href="{{ asset('storage/upload' . $tugas_akhirs->dokumen) }}" download>Download File</a></td> --}}
                    <td><a href="{{ Storage::url($tugas_akhirs->dokumen_laporan_pkl) }}" target="_blank">Lihat dan download
                            dokumen</a>
                    </td>
                </tr>
                <tr>
                    <th>Dokumen Lembar Pembimbing:</th>
                    {{-- <td><a href="{{ asset('storage/upload' . $tugas_akhirs->dokumen) }}" download>Download File</a></td> --}}
                    <td><a href="{{ Storage::url($tugas_akhirs->dokumen_lembar_pembimbing) }}" target="_blank">Lihat dan
                            download dokumen</a>
                    </td>
                </tr>
                <tr>
                    <th>Proposal Tugas Tugas Akhir:</th>
                    {{-- <td><a href="{{ asset('storage/upload' . $tugas_akhirs->dokumen) }}" download>Download File</a></td> --}}
                    <td><a href="{{ Storage::url($tugas_akhirs->dokumen_proposal_tugas_akhir) }}" target="_blank">Lihat dan
                            download dokumen</a>
                    </td>
                </tr>
                <tr>
                    <th>Laporan Tugas Akhir:</th>
                    {{-- <td><a href="{{ asset('storage/upload' . $tugas_akhirs->dokumen) }}" download>Download File</a></td> --}}
                    <td><a href="{{ Storage::url($tugas_akhirs->dokumen_laporan_tugas_akhir) }}" target="_blank">Lihat dan
                            download dokumen</a>
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $tugas_akhirs->status }}
                    </td>
                </tr>
                {{-- <tr>
                    <th>Status Validasi Pembimbing1:</th>
                    <td>{{ $tugas_akhirs->validasi_pembimbing1 ? 'Sudah Validasi' : 'Belum Validasi' }}</td>
                </tr>
                <tr>
                    <th>Status Validasi Pembimbing2:</th>
                    <td>{{ $tugas_akhirs->validasi_pembimbing2 ? 'Sudah Validasi' : 'Belum Validasi' }}</td>
                </tr>
                <tr>
                    <th>Status Validasi Ketua Sidang:</th>
                    <td>{{ $tugas_akhirs->validasi_ketua_sidang ? 'Sudah Validasi' : 'Belum Validasi' }}</td>
                </tr>
                <tr>
                    <th>Status Validasi Sekretaris Sidang:</th>
                    <td>{{ $tugas_akhirs->validasi_sekeretaris_sidang ? 'Sudah Validasi' : 'Belum Validasi' }}</td>
                </tr>
                <tr>
                    <th>Status Validasi Penguji1:</th>
                    <td>{{ $tugas_akhirs->validasi_penguji1 ? 'Sudah Validasi' : 'Belum Validasi' }}</td>
                </tr>
                <tr>
                    <th>Status Validasi Penguji2:</th>
                    <td>{{ $tugas_akhirs->validasi_penguji2 ? 'Sudah Validasi' : 'Belum Validasi' }}</td>
                </tr> --}}
            </tbody>
        </table>
        {{-- <form action="{{ route('tugas_akhirs.validasi', $tugas_akhirs) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="role">Jabatan Sidang</label>
                <select name="role" id="role" class="form-control">
                    <option value="pembimbing1">Pembimbing1</option>
                    <option value="pembimbing2">Pembimbing2</option>
                    <option value="ketua_sidang">Ketua Sidang</option>
                    <option value="sekretaris_sidang">Sekretaris Sidang</option>
                    <option value="penguji1">Penguji1</option>
                    <option value="penguji2">Penguji2</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Validasi Dokumen</button> --}}
        <a href="{{ route('tugas_akhirs.index') }}" class="btn btn-primary">Kembali</a>
        <a href="{{ route('tugas_akhirs.editStatus', ['id' => $tugas_akhirs->id]) }}" class="btn btn-warning">Edit
            Status</a>
    </div>
@endsection
