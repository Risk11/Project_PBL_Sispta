@extends('layout.template')

@section('main')

    <div class="card text-center mb-5">
        <div class="card-body">
            <h1>Data Ruangan</h1>
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
            <div id="datatable_info" class="mr-3"></div>
            {{-- <div>
                <label>
                    Search:
                    <input type="search" id="search" class="form-control form-control-sm d-inline-block" placeholder=""
                        style="width: auto; display: inline;">
                </label>
            </div> --}}
            <div class="col-auto">
                <a href="{{ route('ruangan.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle-fill"></i>
                    Tambah</a>
            </div>
        </div>
    </div>
    <table class="table table-bordered">
        <thead class="table-secondary text-center">
            <tr>
                <th>No</th>
                <th>Nama Ruangan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if ($ruangan->count() > 0)
                @foreach ($ruangan as $item)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $item->nama }}</td>
                        <td class="align-middle">{{ $item->status }}</td>
                        <td class="align-middle text-center">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('ruangan.show', $item->id) }}" class="btn btn-info mr-1"><i
                                        class="bi bi-ticket-detailed-fill"></i> Detail</a>
                                <a href="{{ route('ruangan.edit', $item->id) }}" class="btn btn-warning mr-1"><i
                                        class="bi bi-pencil-square"></i> Edit</a>
                                <form action="{{ route('ruangan.destroy', $item->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Delete?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger"><i class="bi bi-trash-fill"></i>
                                        Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="align-middle text-center" colspan="5">Ruangan tidak ditemukan</td>
                </tr>
            @endif
        </tbody>
    </table>

    <nav>
        <ul class="pagination">
            @if ($ruangan->onFirstPage())
                <li class="page-item disabled"><span class="page-link">Previous</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $ruangan->previousPageUrl() }}"
                        rel="prev">Previous</a></li>
            @endif

            @php
                $currentPage = $ruangan->currentPage();
                $lastPage = $ruangan->lastPage();
                $pageRange = 3; // Range of page links to display

                $startPage = max($currentPage - $pageRange, 1);
                $endPage = min($currentPage + $pageRange, $lastPage);
            @endphp

            @for ($i = $startPage; $i <= $endPage; $i++)
                <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                    <a class="page-link" href="{{ $ruangan->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            @if ($ruangan->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $ruangan->nextPageUrl() }}" rel="next">Next</a>
                </li>
            @else
                <li class="page-item disabled"><span class="page-link">Next</span></li>
            @endif
        </ul>
    </nav>

@endsection
