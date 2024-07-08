@extends('layout.template')

@section('main')
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
    <h1>Data Mahasiswa dari sistem lain</h1>
    <p>Silakan pilih format untuk Memasukkan data data:</p>
    <form action="{{ route('sinkronisasi.mahasiswas') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary mr-2"><i class="bi bi-arrows-collapse-vertical"></i>
            API</button>
    </form>
@endsection
