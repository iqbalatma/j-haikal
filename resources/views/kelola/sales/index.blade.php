@php use Carbon\Carbon; @endphp
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
                                  action="{{route('sales.index')}}">
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
                                                    <option value="{{$key}}"
                                                            @if(request()->input('month', Carbon::now()->month) == $key) selected @endif>{{$month}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="year" class="form-label">Tahun</label>
                                            <select class="form-control" name="year">
                                                <option value>Silahkan pilih tahun</option>
                                                @for($i = 2024;  $i<2030;$i++)
                                                    <option value="{{$i}}"
                                                            @if(request()->input('year', Carbon::now()->year) == $i) selected @endif>{{$i}}</option>
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
                                        <a href="{{route("sales.index")}}"
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


                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon purple mb-2">
                                            <i class="iconly-boldShow"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Total Transaksi</h6>
                                        <h6 class="font-extrabold mb-0">{{$summaries["total_transaction"]}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon blue mb-2">
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Total Asset (Harga x Kuantitas)</h6>
                                        <h6 class="font-extrabold mb-0">{{$summaries["total_asset"]}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon green mb-2">
                                            <i class="iconly-boldAdd-User"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Total Produk</h6>
                                        <h6 class="font-extrabold mb-0">{{$summaries["total_product"]}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon red mb-2">
                                            <i class="iconly-boldBookmark"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Total Supplier</h6>
                                        <h6 class="font-extrabold mb-0">{{$summaries["total_supplier"]}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-9">
                        <div class="card">
                            <div class="card-header">
                                <h4>Visitors Profile</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-visitors-profile"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-header">
                                <h4>Produk Berdasarkan Satuan</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="by_unit"></canvas>
                            </div>
                        </div>
                    </div>
                </div>


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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('by_unit');
        const by_unit_labels = @json($summaries["by_unit"]["labels"]);
        const by_unit_values = @json($summaries["by_unit"]["values"]);
        const data = {
            labels: by_unit_labels,
            datasets: [
                {
                    label: 'Total',
                    data: by_unit_values,
                }
            ]
        };
        new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Rangkuman Berdasarkan Satuan'
                    }
                }
            },
        });
    </script>
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
