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
                                  action="{{route('restocks.restock.by.forecasting')}}">
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
                                        <a href="{{route("restocks.restock.by.forecasting")}}"
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
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" id="btn-belanja"
                                    data-bs-target="#belanja-modal">
                                Belanja
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="belanja-modal" tabindex="-1"
                                 aria-labelledby="belanja-modalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="belanja-modalLabel">Belanja</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="form-belanja" method="POST"
                                                  action="{{route('restocks.store.by.forecasting', ["period" => request()->input('period')])}}">
                                                @csrf
                                                <div class="row g-4" id="form-row">

                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Tutup
                                            </button>
                                            <button type="submit" form="form-belanja" class="btn btn-primary">Simpan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Table with outer spacing -->
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>
                                            <label for="cb-all">NO</label>

                                            <br>
                                            <label for="cb-all">All</label>
                                            <input id="cb-all" type="checkbox">
                                        </th>
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
                                            <td>
                                                <input class="cb-row" type="checkbox"
                                                       data-product-id="{{$forecasting->product?->id}}"
                                                       data-product-name="{{$forecasting->product?->nama_produk}}"
                                                       data-period="{{$forecasting->period}}"
                                                       data-id="{{$forecasting->id}}"
                                                       data-purchasing-plan="{{$forecasting->purchasing_plan}}"
                                                >
                                                {{ $forecastings->firstItem() + $key }}
                                            </td>
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

    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"
            integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
    <script>
        $(function () {
            const suppliers = @json($suppliers);

            $("#cb-all").on("change", function () {
                const isAllChecked = $(this).prop("checked");

                $(".cb-row").prop('checked', isAllChecked);
            })


            $("#btn-belanja").on("click", function () {
                $("#form-row").empty();

                $(".cb-row").each(function (index) {
                    if ($(this).prop('checked')) {
                        const id = $(this).data('id')
                        const period = $(this).data('period')
                        const productName = $(this).data('product-name')
                        const productId = $(this).data('product-id')
                        const purchasingPlan = $(this).data('purchasing-plan')

                        let html = `
                 <div class="col-6">
                                                        <label class="form-label">Nama : ${productName}</label>
    <br>
                                                        <label class="form-label"> Periode : ${period}</label>
    <br>
                                                        <label class="form-label"> Rencana Belanja : ${purchasingPlan}</label>
<input type="hidden" name="forecastings[${index}][id]" value="${id}">
                                                        <input type="number" name="forecastings[${index}][quantity]" class="form-control" placeholder="Silahkan masukkan jumlah belanja" />
<label class="form-label"></label>
<select name="forecastings[${index}][supplier_id]"   class="form-control">`

                        suppliers.forEach(function (item){
                            html += `<option value='${item.id}'>${item.nama_suplier}</option>`
                        })

                        html += `</select>
                                                    </div>
                `
                        $("#form-row").append(html)
                    }

                })

            })
        })
    </script>

@endsection
