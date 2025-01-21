@extends('kerangka.master')
@section('title', 'Halaman Produk')
@section('content')
    <!-- Basic Tables start -->

    <section class="section">
        <div class="row" id="basic-table">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Table Kelola Penjualan</h4>
                        <div class="ms-auto">
                        <a class="btn btn-primary" href="{{ route('sales.create') }}">Tambah Penjualan</a>
                        </div>
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
                                            <th>TANGGAL TRANSAKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                       @foreach ($sales as $key => $sale)
                                        <tr>
                                            <td>{{ $sales->firstItem() + $key }}</td>
                                            <td>{{ $sale->product?->kode_produk }}</td>
                                            <td>{{ $sale->product?->nama_produk }}</td>
                                            <td>{{ $sale->product?->jenis_produk }}</td>
                                            <td>{{ $sale->product?->satuan }}</td>
                                            <td>{{ formatToRupiah($sale->product?->harga_satuan) }}</td>
                                            <td>{{ $sale->supplier?->nama_suplier }}</td>
                                            <td>{{ $sale->quantity }} {{$sale->product?->satuan}}</td>
                                            <td>{{ $sale->stock_before}} {{$sale->product?->satuan}}</td>
                                            <td>{{ $sale->stock_after}} {{$sale->product?->satuan}}</td>
                                            <td>{{$sale->transaction_date}}</td>
                                        </tr>
                                       @endforeach
                                    </tbody>
                                </table>
                                {{ $sales->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Basic Tables end -->
    {{-- <script>
        window.deleteConfirm = function(e) {
            e.preventDefault();
            var form = e.target.form;
            swal({
                    title: " Apakah Anda Yakin ingin menghapus data?",
                    text: "Data Yang Dihapus Tidak Akan Kembali Lagi.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        }
    </script> --}}
@endsection
