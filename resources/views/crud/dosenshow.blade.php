@extends('layout.template')

@section('main')
    <div class="card">
        <div class="card-header">
            <h1 class="text-center">Detail Dosen</h1>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                @if ($dosen->foto)
                    <tr>
                        <td style="width:200px;" rowspan="6">
                            <img src="{{ asset('storage/uploads/' . $dosen->foto) }}" alt="{{ $dosen->nama }}"
                                style="width:200px;height:300px;">
                        </td>
                    </tr>
                @endif
                <tr>
                    <th>NIP</th>
                    <td>{{ $dosen->nip }}</td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <td>{{ $dosen->nama }}</td>
                </tr>
                <tr>
                    <th>jabatan Akademik</th>
                    <td>{{ $dosen->jabatan }}</td>
                </tr>
                <tr>
                    <th>Nomor Telepon</th>
                    <td>{{ $dosen->no_telp }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $dosen->email }}</td>
                </tr>
            </tbody>
        </table>
        <a href="{{ route('dosen.index') }}" class="btn btn-primary mb-3">Kembali</a>
        <button class="btn btn-danger mb-3" onclick="window.print()"><i class="bi bi-download"></i>
            PDF</button>
    </div>
@endsection
