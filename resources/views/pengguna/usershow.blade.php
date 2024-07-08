@extends('layout.template')

@section('main')
    <div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('User Profile') }}</div>
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/uploads/' . $profile->foto) }}" class="rounded-circle"
                            alt="{{ $profile->name }}" width="150">
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="nama" class="col-md-4 col-form-label text-md-right">{{ __('nama') }}</label>
                            <div class="col-md-6">
                                <input id="nama" type="text" class="form-control" name="nama"
                                    value="{{ $profile->nama }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="email"
                                    value="{{ $profile->email }}" readonly>
                            </div>
                        </div>
                        @if ($type === 'mahasiswa')
                            <!-- Show additional fields or actions for 'mahasiswa' level -->
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">prodi</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" value="{{ $profile->prodi }}" readonly>
                                </div>
                            </div>
                        @elseif ($type === 'dosen')
                            <!-- Show additional fields or actions for 'dosen' level -->
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Subjects Taught</label>
                                <div class="col-md-6">
                                    <ul>
                                        @foreach ($profile->subjects as $subject)
                                            <li>{{ $subject->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                        {{-- <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a href="{{ route('users.edit', ['type' => auth()->user()->level, 'id' => auth()->id()]) }}"
                                    class="btn btn-primary">
                                    {{ __('Edit Profile') }}
                                </a>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
