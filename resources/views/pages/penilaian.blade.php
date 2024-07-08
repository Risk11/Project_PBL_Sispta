@extends('layout.template')

@section('main')
    <div class="card text-center mb-5">
        <div class="card-body">
            <h1><i class="bi bi-award-fill"></i> Data Penilaian</h1>
        </div>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="row py-1">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <div>
                {{-- <form class="ll py-2" action="{{ route('penilaian.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control"name="search" placeholder="Cari Mahasiswa.."
                            aria-label="Cari Mahasiwa...">
                        <span class="input-group-btn">
                            <button class="btn btn-primary btn-search" type="submit">
                                <span class="ion-android-search">Cari</span>
                            </button>
                        </span>
                    </div>
                </form> --}}
            </div>


            @auth
                @if (Auth::user()->level == 'Admin' ||
                        Auth::user()->level == 'dosen' ||
                        Auth::user()->level == 'pembimbing1' ||
                        Auth::user()->level == 'pembimbing2')
                    <div class="float-end">
                        <a href="{{ route('penilaian.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle-fill"></i>
                            Buat</a>
                    </div>
                @endif
            @endauth
        </div>
    </div>
    <table class="table table-bordered">
        <thead class="table-secondary  text-center">
            <tr>
                <th>No</th>
                <th>Judul Tugas Akhir</th>
                <th>Rata-Rata Nilai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penilaians as $penilaian)
                <tr>
                    <td class="align-middle">{{ $loop->iteration }}</td>
                    <td class="align-middle">
                        {{ $penilaian->tugasAkhir ? $penilaian->tugasAkhir->Judul : 'Judul tidak tersedia' }}
                    </td>
                    <td class="align-middle">{{ $penilaian->nilai }}</td>
                    <td class="align-middle text-center">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('penilaian.show', $penilaian->id) }}" class="btn btn-info mr-1"><i
                                    class="bi bi-ticket-detailed-fill"></i> Detail</a>
                            <a href="{{ route('penilaian.edit', $penilaian->id) }}" class="btn btn-warning mr-1"><i
                                    class="bi bi-pencil-square"></i> Edit</a>
                            <form action="{{ route('penilaian.destroy', $penilaian->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Hapus penilaian?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill"></i>
                                    Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data penilaian</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <nav aria-label="...">
        <ul class="pagination">
            <li class="page-item disabled">
                <a class="page-link">Previous</a>
            </li>
            <li class="page-item active" aria-current="page">
                <a class="page-link" href="#">1</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Next</a>
            </li>
        </ul>
    </nav>
@endsection
