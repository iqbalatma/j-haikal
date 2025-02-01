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
                            Chart
                        </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" data-parsley-validate method="GET"
                                  action="{{route('forecasting.index')}}">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="kode_produk" class="form-label">Produk</label>
                                            <select name="product_id" class="form-control">
                                                @foreach($products as $product)
                                                    <option value="{{$product->id}}">{{$product->nama_produk}}</option>
                                                @endforeach
                                            </select>
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
                                <div class="row">
                                    {{--                                    <div class="col-12 d-flex justify-content-center p-5" style="height: 600px">--}}
                                    <canvas id="forecasting"></canvas>
                                    {{--                                    </div>--}}
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

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


                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                            Lakukan Peramalam
                        </button>
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


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Peramalam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <form method="POST" action="{{route('forecasting.store')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="month" class="form-label">Bulan</label>
                                    <select class="form-control" name="month">
                                        @foreach(getMonths() as $key => $month)
                                            <option value="{{$key}}">{{$month}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="month" class="form-label">Bulan</label>
                                    <select class="form-control" name="year">
                                        @for($i=2024;  $i<2030; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup
                        </button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const forecasting_labels = @json($forecastingByProduct["labels"] ?? []);
        const forecasting_predictions = @json($forecastingByProduct["predictions"] ?? []);
        const forecasting_actual = @json($forecastingByProduct["actual"] ?? []);
        const forecasting_mape = @json($forecastingByProduct["mape"] ?? []);

        const dataForecasting = {
            labels: forecasting_labels,
            datasets: [
                {
                    label: 'Data Actual',
                    data: forecasting_predictions,
                    borderColor: "#FF6347",
                    cubicInterpolationMode: 'monotone',
                    tension: 0.4
                },
                {
                    label: 'Data Prediksi',
                    data: forecasting_actual,
                    borderColor: "#1E90FF",
                    tension: 0.4
                },
                {
                    label: 'Data MAPE',
                    data: forecasting_mape,
                    borderColor: "green",
                    tension: 0.4,
                    yAxisID: 'y1',
                },
            ]
        };
        const ctxForecasting = document.getElementById('forecasting');

        new Chart(ctxForecasting, {
            type: 'line',
            data: dataForecasting,
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                stacked: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Peramalam Berdasarkan Produk'
                    }
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            align: 'center',
                            text: 'Periode',
                            font: {
                                family: 'Arial',
                                size: 14,
                                weight: 'bold',
                            },
                        },
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            align: 'center',
                            text: 'Kuantitas',
                            font: {
                                family: 'Arial',
                                size: 14,
                                weight: 'bold',
                            },
                        },
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',

                        // grid line settings
                        grid: {
                            drawOnChartArea: false, // only want the grid lines for one axis to show up
                        },
                    },
                }
            },
        });
    </script>

@endsection
