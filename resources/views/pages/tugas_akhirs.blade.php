@extends('layout.template')

@section('main')
    <div class="card text-center mb-5">
        <div class="card-body">
            <h1><i class="bi bi-calendar2-check-fill"></i> Data Tugas Akhir</h1>
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
    <div class="row py-3">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
        </div>
        @auth
            @if (Auth()->user()->level == 'Admin' || Auth::user()->level == 'mahasiswa')
                <div class="col float-end">
                    {{--  @can('create-tugas_akhir') --}}
                    <a href="{{ route('tugas_akhirs.create') }}" class="btn btn-primary float-end"><i
                            class="bi bi-plus-circle-fill"></i> Daftar</a>
                    {{-- @endcan --}}
                </div>
            @endif
        @endauth
    </div>
    <table class="table table-bordered">
        <thead class="table-secondary  text-center">
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Mahasiswa</th>
                <th>Pembimbing 1</th>
                <th>Pembimbing 2</th>

                @auth
                    @if (Auth()->user()->level == 'Admin' || Auth::user()->level == 'kaprodi' || Auth::user()->level == 'dosen')
                        <th>Aksi</th>
                    @endif
                @endauth
            </tr>
        </thead>
        <tbody>
            @if ($tugas_akhirs->count() > 0)
                @foreach ($tugas_akhirs as $tugas_akhir)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $tugas_akhir->Judul }}</td>
                        <td class="align-middle">{{ $tugas_akhir->mahasiswa }}</td>
                        <td class="align-middle">{{ $tugas_akhir->pembimbing1 }}</td>
                        <td class="align-middle">{{ $tugas_akhir->pembimbing2 }}</td>
                        @auth
                            @if (Auth::user()->level == 'kaprodi' || Auth::user()->level == 'dosen')
                                <td class="align-middle text-center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('tugas_akhirs.show', $tugas_akhir) }}" class="btn btn-info mr-1"><i
                                                class="bi bi-ticket-detailed-fill"></i> Detail</a>
                            @endif
                        @endauth
                        @auth
                            @if (Auth::user()->level == 'Admin')
                                <td class="align-middle text-center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('tugas_akhirs.show', $tugas_akhir) }}" class="btn btn-info mr-1"><i
                                                class="bi bi-ticket-detailed-fill"></i> Detail</a>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="{{ route('tugas_akhirs.edit', $tugas_akhir) }}"
                                                class="btn btn-warning mr-1"><i class="bi bi-pencil-square"></i> Edit</a>
                                            <form action="{{ route('tugas_akhirs.destroy', $tugas_akhir->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Delete?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger"> <i class="bi bi-trash-fill"></i> Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            @endif
                        @endauth

                        </div>
                        </td>

                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="align-middle text-center" colspan="6">Tugas akhir tidak ditemukan</td>
                </tr>
            @endif
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            @if ($tugas_akhirs->onFirstPage())
                <li class="page-item disabled"><span class="page-link">Previous</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $tugas_akhirs->previousPageUrl() }}"
                        rel="prev">Previous</a></li>
            @endif

            @php
                $currentPage = $tugas_akhirs->currentPage();
                $lastPage = $tugas_akhirs->lastPage();
                $pageRange = 3; // Range of page links to display

                $startPage = max($currentPage - $pageRange, 1);
                $endPage = min($currentPage + $pageRange, $lastPage);
            @endphp

            @for ($i = $startPage; $i <= $endPage; $i++)
                <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                    <a class="page-link" href="{{ $tugas_akhirs->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            @if ($tugas_akhirs->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $tugas_akhirs->nextPageUrl() }}"
                        rel="next">Next</a>
                </li>
            @else
                <li class="page-item disabled"><span class="page-link">Next</span></li>
            @endif
        </ul>
    </nav>


@endsection
