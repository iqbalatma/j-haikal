@extends('kerangka.master')
@section('title', 'Halaman Produk')
@section('content')
    <!-- Basic Tables start -->

    <section class="section">
        <div class="row" id="basic-table">
            <div class="col-12 col-md-12">
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
                                        <th>STOK SEBELUMNYA</th>
                                        <th>STOK SESUDAHNYA</th>
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
                                            <td>{{ $transaction->stock_before}} {{$transaction->product?->satuan}}</td>
                                            <td>{{ $transaction->stock_after}} {{$transaction->product?->satuan}}</td>
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
