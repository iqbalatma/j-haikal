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
                                  action="{{route('forecasting.index')}}">
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
                                            <label for="kode_produk" class="form-label">Periode</label>
                                            <input
                                                type="text"
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
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">
                                            Filter
                                        </button>
                                        <a href="{{route("forecasting.index")}}"
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
                        <h4 class="card-title text-center">Table Peramalam</h4>
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
                                        <th>PERIODE</th>
                                        <th>PEMBELIAN</th>
                                        <th>PREDIKSI</th>
                                        <th>MAD</th>
                                        <th>MSE</th>
                                        <th>MAPE</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($forecastings as $key => $forecasting)
                                        <tr>
                                            <td>{{ $forecastings->firstItem() + $key }}</td>
                                            <td>{{ $forecasting->product?->kode_produk }}</td>
                                            <td>{{ $forecasting->product?->nama_produk }}</td>
                                            <td>{{ $forecasting->period }}</td>
                                            <td>{{ $forecasting->actual }}</td>
                                            <td>{{ $forecasting->prediction }}</td>
                                            <td>{{ $forecasting->mad }}</td>
                                            <td>{{ $forecasting->mse }}</td>
                                            <td>{{ $forecasting->mape }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $forecastings->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
