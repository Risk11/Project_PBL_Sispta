@extends('layout.template')

@section('main')
    <div class="card text-center mb-5">
        <div class="card-body">
            <h1>Data Notifikasi</h1>
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
    {{--  <div class="col-auto">
        <a href="{{ route('notifikasi.create') }}" class="btn btn-primary float-end mb-3"><i
                class="bi bi-plus-circle-fill"></i>
            Buat Notifikasi</a>
    </div> --}}
    <table class="table table-bordered">
        <thead class="table-secondary mt-3 text-center">
            <tr>
                <th>No</th>
                <th>Nama Pengirim</th>
                <th>Isi</th>
                {{--  <th>Aksi</th> --}}
            </tr>
        </thead>
        <tbody>
            @if ($notifikasis->count() > 0)
                @foreach ($notifikasis as $item)
                    @if ($item->user_id == Auth::id())
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">{{ $item->judul }}</td>
                            <td class="align-middle">{{ $item->isi }}</td>
                            {{-- <td class="align-middle text-center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('notifikasi.show', $item->id) }}" class="btn btn-info mr-1"><i
                                            class="bi bi-ticket-detailed-fill"></i> Detail</a>
                                    <a href="{{ route('notifikasi.edit', $item->id) }}" class="btn btn-warning mr-1"><i
                                            class="bi bi-pencil-square"></i> Edit</a>
                                    <form action="{{ route('notifikasi.destroy', $item->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Delete?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger"><i class="bi bi-trash-fill"></i> Delete</button>
                                    </form>
                                </div>
                            </td> --}}
                        </tr>
                    @endif
                @endforeach
            @else
                <tr>
                    <td class="align-middle text-center" colspan="6">Notifikasi tidak ditemukan</td>
                </tr>
            @endif
        </tbody>
    </table>
@endsection
