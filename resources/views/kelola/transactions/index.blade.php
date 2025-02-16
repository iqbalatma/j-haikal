@extends('kerangka.master')
@section('title', 'Halaman Produk')
@section('content')
    <!-- Basic Tables start -->

    <section class="section">
        <div class="row" id="basic-table">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            Filter
                        </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" data-parsley-validate method="GET"
                                  action="{{route('transactions.index')}}">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="kode_produk" class="form-label">Kode Produk</label>
                                            <input
                                                    type="text"
                                                    id="kode_produk"
                                                    class="form-control"
                                                    placeholder="Kode produk"
                                                    name="kode_produk"
                                                    value="{{request()->input("kode_produk")}}"
                                                    data-parsley-required="true"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="nama_produk" class="form-label">Nama Produk</label>
                                            <input
                                                    type="text"
                                                    id="nama_produk"
                                                    class="form-control"
                                                    placeholder="Nama produk"
                                                    name="nama_produk"
                                                    value="{{request()->input("nama_produk")}}"
                                                    data-parsley-required="true"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="month" class="form-label">Bulan</label>
                                            <select class="form-control" name="month">
                                                <option value>Silahkan pilih bulan</option>
                                                @foreach(getMonths() as $key => $month)
                                                    <option value="{{$key}}" @if(request()->input('month') == $key) selected @endif>{{$month}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="year" class="form-label">Tahun</label>
                                            <select class="form-control" name="year">
                                                <option>Silahkan pilih tahun</option>
                                                @for($i = 2023;  $i<2030;$i++)
                                                    <option value="{{$i}}" @if(request()->input('year') == $i) selected @endif>{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">
                                            Filter
                                        </button>
                                        <a href="{{route("transactions.index")}}"
                                           type="reset"
                                           class="btn btn-light-secondary me-1 mb-1"
                                        >
                                            Reset
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Table Transaksi</h4>
                    </div>

                    <div class="card-content">
                        <div class="card-body">
                            <!-- Table with outer spacing -->
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>KODE PRODUK</th>
                                        <th>NAMA PRODUK</th>
                                        <th>JENIS PRODUK</th>
                                        <th>SATUAN</th>
                                        <th>HARGA SATUAN</th>
                                        <th>NAMA SUPPLIER</th>
                                        <th>KUANTITAS</th>
{{--                                        <th>STOK SEBELUMNYA</th>--}}
{{--                                        <th>STOK SESUDAHNYA</th>--}}
                                        <th>TIPE TRANSAKSI</th>
                                        <th>TANGGAL TRANSAKSI</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($transactions as $key => $transaction)
                                        <tr>
                                            <td>{{ $transactions->firstItem() + $key }}</td>
                                            <td>{{ $transaction->product?->kode_produk }}</td>
                                            <td>{{ $transaction->product?->nama_produk }}</td>
                                            <td>{{ $transaction->product?->jenis_produk }}</td>
                                            <td>{{ $transaction->product?->satuan }}</td>
                                            <td>{{ formatToRupiah($transaction->product?->harga_satuan) }}</td>
                                            <td>{{ $transaction->supplier?->nama_suplier }}</td>
                                            <td>{{ $transaction->quantity }} {{$transaction->product?->satuan}}</td>
{{--                                            <td>{{ $transaction->stock_before}} {{$transaction->product?->satuan}}</td>--}}
{{--                                            <td>{{ $transaction->stock_after}} {{$transaction->product?->satuan}}</td>--}}
                                            <td>{{$transaction->type}}</td>
                                            <td>{{$transaction->transaction_date}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $transactions->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
