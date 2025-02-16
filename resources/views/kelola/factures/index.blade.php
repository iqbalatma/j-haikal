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
                                  action="{{route('factures.index')}}">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="period" class="form-label">Periode</label>
                                            <input
                                                    type="text"
                                                    id="period"
                                                    class="form-control"
                                                    placeholder="Kode produk"
                                                    name="period"
                                                    value="{{request()->input("period")}}"
                                                    data-parsley-required="true"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="month" class="form-label">Supplier</label>
                                            <select class="form-control" name="supplier_id">
                                                <option value>Silahkan pilih supplier</option>
                                                @foreach($suppliers as $key => $supplier)
                                                    <option value="{{$supplier->id}}" @if(request()->input('supplier_id') == $supplier->id) selected @endif>{{$supplier->nama_suplier}}</option>
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
                                        <a href="{{route("factures.index")}}"
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
                                        <th>NOMOR</th>
                                        <th>PERIODE</th>
                                        <th>SUPPLIER</th>
                                        <th>TANGGAL NOTA</th>
                                        <th>AKSI</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($factures as $key => $facture)
                                        <tr>
                                            <td>{{ $factures->firstItem() + $key }}</td>
                                            <td>{{ $facture->number }}</td>
                                            <td>{{ $facture->period }}</td>
                                            <td>{{ $facture->supplier?->nama_suplier }}</td>
                                            <td>{{ $facture->created_at }}</td>
                                            <td>
                                                <a href="{{route('factures.download', $facture->id)}}">
                                                    <button class="btn btn-primary">Download</button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $factures->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
