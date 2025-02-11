@php use App\Enums\Role; @endphp
@extends('kerangka.master')
@section('title', 'Halaman Tambah Produk')
@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center">Tambah Pengguna</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Nama</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="name" name="name"
                                           class="form-control @error('name') is invalid @enderror"
                                           value="{{ old('name') }}" placeholder="Nama">
                                    @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Email</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="email" id="email" name="email"
                                           class="form-control @error('email') is invalid @enderror"
                                           value="{{ old('email') }}" placeholder="Email">
                                    @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Password</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="password" id="password" name="password"
                                           class="form-control @error('password') is invalid @enderror"
                                           value="{{ old('password') }}" placeholder="Password">
                                    @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Password</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                           class="form-control @error('password_confirmation') is invalid @enderror"
                                           value="{{ old('password_confirmation') }}" placeholder="Konfirmasi password">
                                    @error('password_confirmation')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="email-horizontal">Role</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <select class="form-control" name="role">
                                        <option value>Silahkan pilih role</option>
                                        @foreach(Role::names() as $role)
                                            <option value="{{$role}}">{{$role}}</option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-12 d-flex justify-content-end">
                                    <a href="{{ route('users.index') }}" class="btn btn-light-secondary me-1 mb-1">Kembali</a>
                                    <button type="submit" class="btn btn-success text me-1 mb-1">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
