@extends('kerangka.master')
@section('title', 'Halaman Produk')
@section('content')
    <section class="section">
        <div class="row" id="basic-table">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Table Kelola Restok</h4>
                        <div class="ms-auto">
                            <form class="form" data-parsley-validate method="GET"
                                  action="{{route('restocks.index')}}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="period" class="form-label">Periode</label>
                                            <input
                                                type="month"
                                                id="period"
                                                class="form-control"
                                                placeholder="Periode"
                                                name="period"
                                                value="{{request()->input("period")}}"
                                                data-parsley-required="true"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-start">
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
                                        <th>STOK PRODUK SAAT INI</th>
                                        <th>PERIODE</th>
                                        <th>PENJUALAN</th>
                                        <th>PREDIKSI</th>
                                        <th>STOK AMAN</th>
                                        <th>RENCANA PEMBELIAN</th>
                                        <th>AKTUALISASI PEMBELIAN</th>
                                        <th>MAPE</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($forecastings as $key => $forecasting)
                                        <tr>
                                            <td>{{ $forecastings->firstItem() + $key }}</td>
                                            <td>{{ $forecasting->product?->kode_produk }}</td>
                                            <td>{{ $forecasting->product?->nama_produk }}</td>
                                            <td>{{ $forecasting->product?->quantity }}</td>
                                            <td>{{ $forecasting->period }}</td>
                                            <td>{{ $forecasting->actual ?? "-" }}</td>
                                            <td>{{ $forecasting->prediction }}</td>
                                            <td>{{ $forecasting->safety_stock }}</td>
                                            <td>{{ $forecasting->purchasing_plan }}</td>
                                            <td>{{ $forecasting->actual_restock ?? "-" }}</td>
                                            <td>{{ $forecasting->mape }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @if($forecastings->count() > 0)
                                    {{ $forecastings->withQueryString()->links() }}
                                @endif

                                {{--                                <table class="table table-striped" id="restock">--}}
                                {{--                                    <thead>--}}
                                {{--                                    <tr>--}}
                                {{--                                        <th>NO</th>--}}
                                {{--                                        <th>KODE PRODUK</th>--}}
                                {{--                                        <th>NAMA PRODUK</th>--}}
                                {{--                                        <th>JENIS PRODUK</th>--}}
                                {{--                                        <th>SATUAN</th>--}}
                                {{--                                        <th>STOK</th>--}}
                                {{--                                        <th>HARGA SATUAN</th>--}}
                                {{--                                        <th>AKSI</th>--}}
                                {{--                                    </tr>--}}
                                {{--                                    </thead>--}}
                                {{--                                    <tbody>--}}

                                {{--                                    @foreach ($products as $product)--}}
                                {{--                                        <tr>--}}
                                {{--                                            <td>{{ $loop->iteration }}</td>--}}
                                {{--                                            <td>{{ $product->kode_produk }}</td>--}}
                                {{--                                            <td>{{ $product->nama_produk }}</td>--}}
                                {{--                                            <td>{{ $product->jenis_produk }}</td>--}}
                                {{--                                            <td>{{ $product->satuan}}</td>--}}
                                {{--                                            <td>{{ $product->quantity}}</td>--}}
                                {{--                                            <td>{{ formatToRupiah($product->harga_satuan) }}</td>--}}
                                {{--                                            <td>--}}
                                {{--                                                <div class="d-flex">--}}
                                {{--                                                    <a href="{{ route('produk.edit', $product->id) }}"--}}
                                {{--                                                       class="btn btn-success show_confirm"--}}
                                {{--                                                       style="margin-right: 5px">Edit</a>--}}

                                {{--                                                    <form action="{{ route('produk.destroy', $product->id) }}"--}}
                                {{--                                                          method="POST">--}}
                                {{--                                                        @csrf--}}
                                {{--                                                        @method('delete')--}}
                                {{--                                                        --}}{{-- <button class="btn btn-danger" onclick="deleteConfirm(event)">--}}
                                {{--                                                            {{ __('Hapus') }}--}}
                                {{--                                                        </button> --}}
                                {{--                                                        <button class="btn btn-danger"> Hapus</button>--}}
                                {{--                                                    </form>--}}
                                {{--                                                </div>--}}
                                {{--                                            </td>--}}
                                {{--                                        </tr>--}}
                                {{--                                    @endforeach--}}
                                {{--                                    </tbody>--}}
                                {{--                                </table>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
