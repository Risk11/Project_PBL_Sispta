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
            <div>
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
        <thead class="table-secondary  text-center">
            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Nama Ruangan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if ($ruangan->count() > 0)
                @foreach ($ruangan as $ruangan)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $ruangan->id }}</td>
                        <td class="align-middle">{{ $ruangan->nama }}</td>
                        <td class="align-middle">{{ $ruangan->status }}</td>
                        <td class="align-middle text-center">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('ruangan.show', $ruangan) }}" class="btn btn-info mr-1"><i
                                        class="bi bi-ticket-detailed-fill"></i> Detail</a>
                                <a href="{{ route('ruangan.edit', $ruangan->id) }}" class="btn btn-warning mr-1"><i
                                        class="bi bi-pencil-square"></i> Edit</a>
                                <form action="{{ route('ruangan.destroy', $ruangan->id) }}" method="POST" class="d-inline"
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
                    <td class="align-middle text-center" colspan="6">Ruangan tidak ditemukan</td>
                </tr>
            @endif
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
