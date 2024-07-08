@extends('layout.template')

@section('main')
    <div class="card text-center mb-5">
        <div class="card-body">
            <h1><i class="bi bi-person-circle"></i> Data Users</h1>
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
    <div>
        <div class="d-flex align-items-center mb-1">

            <div class="col float-end">
                @auth
                    @if (Auth()->user()->level == 'Admin')
                        <a href="{{ route('users.create') }}" class="btn btn-primary float-end"><i
                                class="bi bi-plus-circle-fill"></i> Tambah User</a>
                    @endif
                @endauth
            </div>
            <form action="{{ route('users.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control"name="search" placeholder="Cari User.."
                        aria-label="Cari user...">
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
                <th>Name</th>
                <th>Email</th>
                <th>Level</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($users->count() > 0)
                @foreach ($users as $user)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $user->name }}</td>
                        <td class="align-middle">{{ $user->email }}</td>
                        <td class="align-middle">{{ $user->level }}</td>
                        <td class="align-middle  text-center">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                {{-- @if (auth()->user()->level === 'admin') --}}
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-info mr-1"><i
                                        class="bi bi-ticket-detailed-fill"></i>
                                    Detail
                                </a>
                                {{--  @can('admin-only') --}}
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning mr-1"><i
                                        class="bi bi-pencil-square"></i>
                                    Edit
                                </a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Delete?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill"></i>
                                        Delete</button>
                                </form>
                                {{-- @endif --}}
                                {{--   @endcan --}}
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center">No users found</td>
                </tr>
            @endif
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            @if ($users->onFirstPage())
                <li class="page-item disabled"><span class="page-link">Previous</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $users->previousPageUrl() }}"
                        rel="prev">Previous</a></li>
            @endif

            @php
                $currentPage = $users->currentPage();
                $lastPage = $users->lastPage();
                $pageRange = 3; // Range of page links to display

                $startPage = max($currentPage - $pageRange, 1);
                $endPage = min($currentPage + $pageRange, $lastPage);
            @endphp

            @for ($i = $startPage; $i <= $endPage; $i++)
                <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                    <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            @if ($users->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $users->nextPageUrl() }}" rel="next">Next</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">Next</span></li>
            @endif
        </ul>
    </nav>
@endsection
