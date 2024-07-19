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

            </div>
        </div>
    </div>
    <table class="table table-bordered">
        <thead class="table-secondary text-center">
            <tr>
                <th>No</th>
                <th>Judul Tugas Akhir</th>
                <th>Jabatan Sidang</th>
                <th>Nama Dosen</th>
                <th>Nilai</th>
                <th>Komentar</th>
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
                    <td class="align-middle">{{ $penilaian->jabatan }}</td>
                    <td class="align-middle">{{ $penilaian->dosen->nama }}</td>
                    <td class="align-middle">{{ $penilaian->nilai ?? 'Belum dinilai' }}</td>
                    <td class="align-middle">{{ $penilaian->komentar ?? 'Tidak ada komentar' }}</td>
                    <td class="align-middle text-center">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            {{-- <a href="{{ route('penilaian.show', $penilaian->id) }}" class="btn btn-info mr-1"><i
                                    class="bi bi-ticket-detailed-fill"></i> Detail</a> --}}
                            {{-- <a href="{{ route('penilaian.edit', $penilaian->id) }}" class="btn btn-warning mr-1"><i
                                    class="bi bi-pencil-square"></i> Edit</a> --}}
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
                    <td colspan="7" class="text-center">Tidak ada data penilaian</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            @if ($penilaians->onFirstPage())
                <li class="page-item disabled"><span class="page-link">Previous</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $penilaians->previousPageUrl() }}"
                        rel="prev">Previous</a></li>
            @endif

            @php
                $currentPage = $penilaians->currentPage();
                $lastPage = $penilaians->lastPage();
                $pageRange = 3; // Range of page links to display

                $startPage = max($currentPage - $pageRange, 1);
                $endPage = min($currentPage + $pageRange, $lastPage);
            @endphp

            @for ($i = $startPage; $i <= $endPage; $i++)
                <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                    <a class="page-link" href="{{ $penilaians->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            @if ($penilaians->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $penilaians->nextPageUrl() }}" rel="next">Next</a>
                </li>
            @else
                <li class="page-item disabled"><span class="page-link">Next</span></li>
            @endif
        </ul>
    </nav>
@endsection
