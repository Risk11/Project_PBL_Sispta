@extends('layout.template')

@section('main')
    <div class="card text-center mb-5">
        <div class="card-body">
            <h1><i class="bi bi-mortarboard"></i> Data Dosen</h1>
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
        <div class="d-flex align-items-center mb-1">
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
            </div>
            <div id="datatable_info" class="mr-auto"></div> --}}

            {{-- <div>
                <label>
                    Search:
                    <input type="search" id="search" class="form-control form-control-sm d-inline-block" placeholder=""
                        style="width: auto; display: inline;">
                </label>
            </div> --}}
            <div class="col float-end">
                {{-- @can('create-dosen') --}}
                <a href="{{ route('dosen.create') }}" class="btn btn-primary float-end"><i class="bi bi-plus-circle-fill"></i>
                    Tambah</a>
                {{-- @endcan --}}
            </div>
            {{-- <form action="{{ route('dosen.index') }}" method="GET">
                <input type="text" name="search" placeholder="Cari nama dosen...">
                <button type="submit">Cari</button>
            </form> --}}
            <form action="{{ route('dosen.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control"name="search" placeholder="Cari dosen.."
                        aria-label="Cari dosen...">
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
        <thead class="table-secondary text-center">
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if ($dosens->count() > 0)
                @foreach ($dosens as $dosen)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $dosen->nip }}</td>
                        <td class="align-middle">{{ $dosen->nama }}</td>
                        <td class="align-middle">{{ $dosen->jabatan }}</td>
                        <td class="align-middle text-center">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('dosen.show', $dosen) }}" class="btn btn-info mr-1"><i
                                        class="bi bi-ticket-detailed-fill"></i> Detail</a>
                                <a href="{{ route('dosen.edit', $dosen) }}" class="btn btn-warning mr-1"><i
                                        class="bi bi-pencil-square"></i> Edit</a>
                                <form action="{{ route('dosen.destroy', $dosen->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Delete?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger"><i class="bi bi-trash-fill"></i> Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="align-middle text-center" colspan="8">Dosen tidak ditemukan</td>
                </tr>
            @endif
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            @if ($dosens->onFirstPage())
                <li class="page-item disabled"><span class="page-link">Previous</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $dosens->previousPageUrl() }}"
                        rel="prev">Previous</a></li>
            @endif

            @php
                $currentPage = $dosens->currentPage();
                $lastPage = $dosens->lastPage();
                $pageRange = 3; // Range of page links to display

                $startPage = max($currentPage - $pageRange, 1);
                $endPage = min($currentPage + $pageRange, $lastPage);
            @endphp

            @for ($i = $startPage; $i <= $endPage; $i++)
                <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                    <a class="page-link" href="{{ $dosens->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            @if ($dosens->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $dosens->nextPageUrl() }}" rel="next">Next</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">Next</span></li>
            @endif
        </ul>
    </nav>
    </nav>
@endsection
