@extends('kerangka.master')
@section('title', 'Halaman Tambah Produk')
@section('content')
               <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Tambah Suplier</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" action="{{ route('suplier.store') }}" method="POST">
                              @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="first-name-horizontal">Nama Suplier</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" id="nama_suplier" name="nama_suplier" class="form-control @error('nama_suplier') is invalid @enderror"
                                                value="{{ old('nama_suplier') }}" placeholder="Nama Suplier">
                                             @error('nama_suplier')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                             @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="email-horizontal">Alamat</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" id="alamat" name="alamat" class="form-control @error('alamat') is invalid @enderror"
                                                value="{{ old('alamat') }}" placeholder="Alamat">
                                             @error('alamat')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                             @enderror
                                        </div>

                                        <div class="col-sm-12 d-flex justify-content-end">
                                          <a href="{{ route('suplier.index') }}" class="btn btn-light-secondary me-1 mb-1">Kembali</a>
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