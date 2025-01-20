@php use App\Enums\Unit; @endphp
@extends('kerangka.master')
@section('title', 'Halaman Edit Produk')
@section('content')
               <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Edit Produk</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" action="{{ route('produk.update', $produk->id) }}"
                                method="POST">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                             <label for="first-name-horizontal">Kode Produk</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" id="kode_produk" name="kode_produk" class="form-control @error('kode_produk') is invalid @enderror"
                                                value="{{ old('kode_produk') ?? $produk->kode_produk }}" placeholder="Kode Produk">
                                             @error('kode_produk')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                             @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="first-name-horizontal">Nama Produk</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" id="nama_produk" name="nama_produk" class="form-control @error('nama_produk') is invalid @enderror"
                                                value="{{ old('nama_produk') ?? $produk->nama_produk}}"  placeholder="Nama Produk">
                                             @error('nama_produk')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                             @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="email-horizontal">Jenis Produk</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" id="jenis_produk" name="jenis_produk" class="form-control @error('jenis_produk') is invalid @enderror"
                                                value="{{ old('nama_produk') ?? $produk->jenis_produk }}" placeholder="Jenis Produk">
                                             @error('jenis_produk')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                             @enderror
                                        </div>
                                        <div class="col-md-4">
                                             <label for="first-name-horizontal">Satuan</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-control" name="satuan">
                                                <option value>Silahkan pilih satuan</option>
                                                @foreach(Unit::names() as $unit)
                                                    <option @if($unit === $produk->satuan) selected @endif value="{{$unit}}">{{$unit}}</option>
                                                @endforeach
                                            </select>
                                            @error('satuan')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                         <div class="col-md-4">
                                             <label for="first-name-horizontal">Harga Satuan</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" id="satuan" name="harga_satuan" class="form-control @error('harga_satuan') is invalid @enderror"
                                                value="{{ old('harga_satuan') ?? $produk->harga_satuan}}" placeholder="Harga Satuan">
                                             @error('satuan')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                             @enderror
                                        </div>

                                        <div class="col-sm-12 d-flex justify-content-end">
                                          <a href="{{ route('produk.index') }}" class="btn btn-light-secondary me-1 mb-1">Kembali</a>
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
