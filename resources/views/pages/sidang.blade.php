@extends('layout.template')

@section('main')
    <div class="card text-center mb-5">
        <div class="card-body">
            <h1>Data Sidang</h1>
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

            {{-- <div>
                <label>
                    Search:
                    <input type="search" id="search" class="form-control form-control-sm d-inline-block" placeholder=""
                        style="width: auto; display: inline;">
                </label>
            </div> --}}
            <div class="col float-end">
                {{-- @can('create-sidang') --}}
                @auth
                    @if (Auth::user()->level == 'Admin' ||
                            Auth::user()->level == 'kaprodi' ||
                            Auth::user()->level == 'pembimbing1' ||
                            Auth::user()->level == 'Tim_Penguji' ||
                            Auth::user()->level == 'dosen')
                        <a href="{{ route('sidang.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle-fill"></i>
                            Tambah</a>
                    @endif
                @endauth
                {{-- @endcan --}}
            </div>
            <form class="ll mr-2" action="{{ route('sidang.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control"name="search" placeholder="Cari sidang.."
                        aria-label="Cari sidang...">
                    <span class="input-group-btn">
                        <button class="btn btn-primary btn-search" type="submit">
                            <span class="ion-android-search">Cari</span>
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-bordered">
        <thead class="table-secondary  text-center">
            <tr>
                <th>No</th>
                <th>Judul Tugas Akhir</th>
                <th>Tanggal Sidang</th>
                <th>Sesi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if (Auth()->user()->level == 'dosen')
                @if ($sidangs->count() != 0 || $sidangs1->count() != 0)
                    @foreach ($sidangs as $sidang)
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">
                                {{ $sidang->tugasAkhir ? $sidang->tugasAkhir->Judul : 'Judul tidak tersedia' }}
                            </td>
                            <td class="align-middle">{{ $sidang->tanggal }}</td>
                            <td class="align-middle">{{ $sidang->sesi }}</td>
                            <td class="align-middle text-center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    @auth
                                        @if (Auth::user()->level == 'Admin' || Auth::user()->level == 'kaprodi')
                                            <a href="{{ route('sidang.show', $sidang->id) }}" class="btn btn-info mr-1"><i
                                                    class="bi bi-ticket-detailed-fill"></i> Detail</a>
                                        @endif
                                    @endauth
                                    @auth
                                        @if (Auth::user()->level == 'Admin' || Auth::user()->level == 'kaprodi')
                                            <a href="{{ route('sidang.edit', $sidang->id) }}" class="btn btn-warning mr-1"> <i
                                                    class="bi bi-pencil-square"></i> Edit</a>
                                        @endif
                                    @endauth
                                    <a href="/tambahpenilaian/{{ $sidang->id }}" class="btn btn-primary mr-1"><i
                                            class="bi bi-bookmark-plus-fill"></i> Buat Penilaian</a>
                                    @auth
                                        @if (Auth()->user()->level == 'Admin')
                                            <form action="{{ route('sidang.destroy', $sidang->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Delete?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill"></i>
                                                    Delete</button>
                                            </form>
                                        @endif
                                    @endauth

                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @if ($sidangs1->isNotEmpty())
                        @foreach ($sidangs1 as $sidang)
                            <tr>
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">
                                    {{ $sidang->tugasAkhir ? $sidang->tugasAkhir->Judul : 'Judul tidak tersedia' }}
                                </td>
                                <td class="align-middle">{{ $sidang->tanggal }}</td>
                                <td class="align-middle">{{ $sidang->sesi }}</td>
                                <td class="align-middle text-center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        @auth
                                            @if (Auth::user()->level == 'Admin' ||
                                                    Auth::user()->level == 'kaprodi' ||
                                                    Auth::user()->level == 'dosen' ||
                                                    Auth::user()->level == 'pembimbing1')
                                                <a href="{{ route('sidang.show', $sidang->id) }}" class="btn btn-info mr-1"><i
                                                        class="bi bi-ticket-detailed-fill"></i> Detail</a>
                                            @endif
                                        @endauth
                                        @auth
                                            @if (Auth::user()->level == 'Admin' || Auth::user()->level == 'kaprodi')
                                                <a href="{{ route('sidang.edit', $sidang->id) }}" class="btn btn-warning mr-1">
                                                    <i class="bi bi-pencil-square"></i> Edit</a>
                                            @endif
                                        @endauth
                                        <a href="/tambahpenilaian/{{ $sidang->id }}" class="btn btn-primary mr-1"><i
                                                class="bi bi-bookmark-plus-fill"></i> Buat Penilaian</a>
                                        @auth
                                            @if (Auth()->user()->level == 'Admin')
                                                <form action="{{ route('sidang.destroy', $sidang->id) }}" method="POST"
                                                    class="d-inline" onsubmit="return confirm('Delete?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"><i
                                                            class="bi bi-trash-fill"></i>
                                                        Delete</button>
                                                </form>
                                            @endif
                                        @endauth

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @else
                    <tr>
                        <td colspan="10" class="text-center">No data available</td>
                    </tr>
                @endif
            @elseif(Auth()->user()->level == 'kaprodi' || Auth()->user()->level == 'Admin')
                @if ($sidangs->count() > 0)
                    @foreach ($sidangs as $sidang)
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">
                                {{ $sidang->tugasAkhir ? $sidang->tugasAkhir->Judul : 'Judul tidak tersedia' }}
                            </td>
                            <td class="align-middle">{{ $sidang->tanggal }}</td>
                            <td class="align-middle">{{ $sidang->sesi }}</td>
                            <td class="align-middle text-center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    @auth
                                        @if (Auth::user()->level == 'Admin' ||
                                                Auth::user()->level == 'kaprodi' ||
                                                Auth::user()->level == 'dosen' ||
                                                Auth::user()->level == 'pembimbing1')
                                            <a href="{{ route('sidang.show', $sidang->id) }}" class="btn btn-info mr-1"><i
                                                    class="bi bi-ticket-detailed-fill"></i> Detail</a>
                                        @endif
                                    @endauth
                                    @auth
                                        @if (Auth::user()->level == 'Admin' || Auth::user()->level == 'kaprodi')
                                            <a href="{{ route('sidang.edit', $sidang->id) }}" class="btn btn-warning mr-1"> <i
                                                    class="bi bi-pencil-square"></i> Edit</a>
                                        @endif
                                    @endauth
                                    <a href="/tambahpenilaian/{{ $sidang->id }}" class="btn btn-primary mr-1"><i
                                            class="bi bi-bookmark-plus-fill"></i> Buat Penilaian</a>
                                    @auth
                                        @if (Auth()->user()->level == 'Admin')
                                            <form action="{{ route('sidang.destroy', $sidang->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Delete?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill"></i>
                                                    Delete</button>
                                            </form>
                                        @endif
                                    @endauth

                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            @endif
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            @if ($sidangs->onFirstPage())
                <li class="page-item disabled"><span class="page-link">Previous</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $sidangs->previousPageUrl() }}"
                        rel="prev">Previous</a></li>
            @endif

            @php
                $currentPage = $sidangs->currentPage();
                $lastPage = $sidangs->lastPage();
                $pageRange = 3; // Range of page links to display

                $startPage = max($currentPage - $pageRange, 1);
                $endPage = min($currentPage + $pageRange, $lastPage);
            @endphp

            @for ($i = $startPage; $i <= $endPage; $i++)
                <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                    <a class="page-link" href="{{ $sidangs->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            @if ($sidangs->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $sidangs->nextPageUrl() }}" rel="next">Next</a>
                </li>
            @else
                <li class="page-item disabled"><span class="page-link">Next</span></li>
            @endif
        </ul>
    </nav>

@endsection
