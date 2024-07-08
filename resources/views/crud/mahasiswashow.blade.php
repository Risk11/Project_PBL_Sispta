@extends('layout.template')

@section('main')
    <div class="card">
        <div class="card-header">
            <h1 class="text-center">Detail Mahasiswa</h1>
        </div>
    </div>
    <table class="table table-bordered">
        <tbody>
            @if ($mahasiswa->foto)
                <th style="width:200px;" rowspan="6">
                    <img src="{{ asset('storage/uploads/' . $mahasiswa->foto) }}" alt="{{ $mahasiswa->nama }}"
                        style="width:200px;height:300px;">
                </th>
            @else
                <tr>
                    <td rowspan="6" class="center-image">Tidak ada foto</td>
                </tr>
            @endif
            <tr>
                <th>Nama</th>
                <td>{{ $mahasiswa->nama }}</td>
            </tr>
            <tr>
                <th>NIM</th>
                <td>{{ $mahasiswa->nim }}</td>
            </tr>
            <tr>
                <th>Prodi</th>
                <td>{{ $mahasiswa->prodi }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $mahasiswa->email }}</td>
            </tr>
            <tr>
                <th>Angkatan</th>
                <td>{{ $mahasiswa->angkatan }}</td>
            </tr>
        </tbody>
    </table>
    <button class="btn btn-danger mt-3 mb-3" onclick="window.print()"><i class="bi bi-download"></i>
        PDF</button>
    <a href="{{ route('mahasiswas.index') }}" class="btn btn-primary">Kembali</a>
@endsection
