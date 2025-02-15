@extends('kerangka.master')
@section('title', 'Halaman Produk')
@section('content')
    <!-- Basic Tables start -->

    <section class="section">
        <div class="row" id="basic-table">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Table Kelola Restok</h4>
                    </div>

                        <div class="card-content">
                        <div class="card-body">
                            <!-- Table with outer spacing -->
                            <div class="table-responsive">
                                <table class="table table-striped" id="restock">
                                    <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>KODE PRODUK</th>
                                        <th>NAMA PRODUK</th>
                                        <th>JENIS PRODUK</th>
                                        <th>SATUAN</th>
                                        <th>STOK</th>
                                        <th>HARGA SATUAN</th>
                                        <th>AKSI</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $product->kode_produk }}</td>
                                            <td>{{ $product->nama_produk }}</td>
                                            <td>{{ $product->jenis_produk }}</td>
                                            <td>{{ $product->satuan}}</td>
                                            <td>{{ $product->quantity}}</td>
                                            <td>{{ formatToRupiah($product->harga_satuan) }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('produk.edit', $product->id) }}"
                                                       class="btn btn-success show_confirm"
                                                       style="margin-right: 5px">Edit</a>

                                                    <form action="{{ route('produk.destroy', $product->id) }}"
                                                          method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        {{-- <button class="btn btn-danger" onclick="deleteConfirm(event)">
                                                            {{ __('Hapus') }}
                                                        </button> --}}
                                                        <button class="btn btn-danger"> Hapus </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
