@extends('layout.template')

@section('main')
    <div class="row">
        <div class="col">
            <h1 class="mb-4">Edit User</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                {{-- <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div> --}}
                {{-- <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div> --}}
                <div class="mb-3">
                    <label for="level">Level (Optional):</label>
                    <select class="form-control" id="level" name="level">
                        <option value="">Pilih Level</option>
                        <option value="Admin" {{ old('level') == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="dosen" {{ old('level') == 'Dosen' ? 'selected' : '' }}>dosen</option>
                        <option value="kaprodi" {{ old('level') == 'Kaprodi' ? 'selected' : '' }}>kaprodi</option>
                        <option value="mahasiswa" {{ old('level') == 'Mahasiswa' ? 'selected' : '' }}>mahasiswa</option>
                    </select>
                    @error('level')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
