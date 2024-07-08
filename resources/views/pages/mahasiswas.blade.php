@extends('layout.template')

@section('main')

    <div class="card text-center mb-5">
        <div class="card-body">
            <h1><i class="bi bi-mortarboard-fill"></i> Data Mahasiswa</h1>
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
        <div class="d-flex align-items-center">
            {{-- <div>
                <label>
                    Show
                    <select name="entries" id="entries" class="form-select form-select-sm d-inline-block"
                        style="width: auto; display: inline;">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    entries
                </label>
            </div> --}}
            {{-- <div id="datatable_info" class="mr-3"></div>
            {{-- <div>
                <label>
                    Search:
                    <input type="search" id="search" class="form-control form-control-sm d-inline-block" placeholder=""
                        style="width: auto; display: inline;">
                </label>
            </div> --}}
            <div class="col float-end">
                {{--  @can('create-mahasiswa') --}}
                <a href="{{ route('mahasiswas.create') }}" class="btn btn-primary float-end"><i
                        class="bi bi-plus-circle-fill"></i>
                    Tambah</a>
                {{-- @endcan --}}
            </div>

            <form class="ll mr-2" action="{{ route('mahasiswas.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control"name="search" placeholder="Cari Mahasiswa.."
                        aria-label="Cari Mahasiwa...">
                    <span class="input-group-btn">
                        <button class="btn btn-primary btn-search" type="submit">
                            <span class="ion-android-search">Cari</span>
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-bordered ">
        <thead class="table-secondary  text-center">
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Prodi</th>
                @auth
                    @if (Auth()->user()->level == 'Admin')
                        <th>Aksi</th>
                    @endif
                @endauth

            </tr>
        </thead>
        <tbody>
            @if ($mahasiswas->count() > 0)
                @foreach ($mahasiswas as $mahasiswa)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $mahasiswa->nim }}</td>
                        <td class="align-middle">{{ $mahasiswa->nama }}</td>
                        <td class="align-middle">{{ $mahasiswa->prodi }}</td>
                        @auth
                            @if (Auth()->user()->level == 'Admin')
                                <td class="align-middle text-center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        @auth
                                            @if (Auth::user()->level == 'Admin' || Auth::user()->level == 'kaprodi')
                                                <a href="{{ route('mahasiswa.show', $mahasiswa) }}" class="btn btn-info mr-1"><i
                                                        class="bi bi-ticket-detailed-fill"></i> Detail</a>
                                            @endif
                                        @endauth


                                        <a href="{{ route('mahasiswas.edit', $mahasiswa->id) }}" class="btn btn-warning mr-1"><i
                                                class="bi bi-pencil-square"></i> Edit</a>
                                        <form action="{{ route('mahasiswas.destroy', $mahasiswa->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Delete?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger"><i class="bi bi-trash-fill"></i> Delete</button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        @endauth
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="align-middle text-center" colspan="6">Mahasiswa tidak ditemukan</td>
                </tr>
            @endif
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            @if ($mahasiswas->onFirstPage())
                <li class="page-item disabled"><span class="page-link">Previous</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $mahasiswas->previousPageUrl() }}"
                        rel="prev">Previous</a></li>
            @endif

            @php
                $currentPage = $mahasiswas->currentPage();
                $lastPage = $mahasiswas->lastPage();
                $pageRange = 3; // Range of page links to display

                $startPage = max($currentPage - $pageRange, 1);
                $endPage = min($currentPage + $pageRange, $lastPage);
            @endphp

            @for ($i = $startPage; $i <= $endPage; $i++)
                <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                    <a class="page-link" href="{{ $mahasiswas->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            @if ($mahasiswas->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $mahasiswas->nextPageUrl() }}" rel="next">Next</a>
                </li>
            @else
                <li class="page-item disabled"><span class="page-link">Next</span></li>
            @endif
        </ul>
    </nav>
@endsection
