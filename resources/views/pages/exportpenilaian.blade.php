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
    <h1> Export Data Penilaian</h1>
    <p>Silakan pilih format untuk ekspor data:</p>
    <a class="btn btn-warning" href="/penilaianexport">
        <i class="fa fa-download"> Excel</i>
    </a>
@endsection
