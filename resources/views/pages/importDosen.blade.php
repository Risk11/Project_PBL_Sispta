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
    <h1>Import Data Dosen</h1>
    <p>Silakan pilih format untuk import data:</p>
    <div>
        <div>
            <form action="{{ route('dosen.import') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                @csrf
                <button class="btn btn-success"><i class="fa fa-file"></i> Import</button>
                <input type="file" name="file" class="form-control mt-3">
            </form>
        </div>
    </div>
@endsection
