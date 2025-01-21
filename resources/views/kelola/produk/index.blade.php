@extends('kerangka.master')
@section('title', 'Halaman Produk')
@section('content')
    <!-- Basic Tables start -->

    <section class="section">
        <div class="row" id="basic-table">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Table Kelola Produk</h4>
                        <div class="ms-auto">
                        <a class="btn btn-primary" href="{{ route('produk.create') }}">Tambah Produk</a>
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
                                            <th>STOK</th>
                                            <th>HARGA SATUAN</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                       @foreach ($produks as $produk)
                                        <tr>
                                          <td>{{ $loop->iteration }}</td>
                                          <td>{{ $produk->kode_produk }}</td>
                                          <td>{{ $produk->nama_produk }}</td>
                                          <td>{{ $produk->jenis_produk }}</td>
                                          <td>{{ $produk->satuan}}</td>
                                          <td>{{ $produk->quantity}}</td>
                                          <td>{{ formatToRupiah($produk->harga_satuan) }}</td>
                                          <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('produk.edit', $produk->id) }}"
                                                        class="btn btn-success show_confirm"
                                                        style="margin-right: 5px">Edit</a>

                                                    <form action="{{ route('produk.destroy', $produk->id) }}"
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
