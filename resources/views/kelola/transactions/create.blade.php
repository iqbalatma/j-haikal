@php use App\Enums\Enums\Type;use App\Enums\Unit; @endphp
@extends('kerangka.master')
@section('title', 'Halaman Tambah Produk')
@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center">Tambah Penjualan</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="{{ route('sales.store') }}" method="POST">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Produk</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <select class="form-control @error('product_id') is invalid @enderror" name="product_id">
                                        <option value>Silahkan pilih produk</option>
                                        @foreach($products as $product)
                                            <option value="{{$product->id}}">{{$product->kode_produk}} | {{$product->nama_produk}} | {{$product->jenis_produk}} | Quantity : {{$product->quantity}}</option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Supplier</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <select class="form-control @error('supplier_id') is invalid @enderror" name="supplier_id">
                                        <option value>Silahkan pilih supplier</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{$supplier->id}}">{{$supplier->nama_suplier}} | {{$supplier->alamat}}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="first-name-horizontal">Kuantitas</label>
                                </div>


                                <div class="col-md-8 form-group">
                                    <input type="text" id="quantity" name="quantity"
                                           class="form-control @error('quantity') is invalid @enderror"
                                           value="{{ old('quantity') }}" placeholder="Kuantitas">
                                    @error('quantity')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-sm-12 d-flex justify-content-end">
                                    <a href="{{ route('sales.index') }}" class="btn btn-light-secondary me-1 mb-1">Kembali</a>
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
