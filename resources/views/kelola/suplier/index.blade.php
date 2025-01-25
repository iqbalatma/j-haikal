@extends('kerangka.master')
@section('title', 'Halaman Produk')
@section('content')
    <!-- Basic Tables start -->

    <section class="section">
        <div class="row" id="basic-table">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Table Kelola Suplier</h4>
                        <div class="ms-auto">
                        <a class="btn btn-primary" href="{{ route('suplier.create') }}">Tambah Suplier</a>
                        </div>
                    </div>

                  @if(session()->has('success'))
                     <div class="alert alert-success alert-dismissble fade show" role="alert">
                     {{ session('success') }}
                     <button type="button" class="btn-close" data-bs-dismiss="alert"
                     aria-label="Close"></button>
                     </div>
                  @elseif(session()->has('failed'))
                     <div class="alert alert-danger alert-dismissble fade show" role="alert">
                     {{ session('failed') }}
                     <button type="button" class="btn-close" data-bs-dismiss="alert"
                     aria-label="Close"></button>
                     </div>
                  @endif
                    <div class="card-content">
                        <div class="card-body">
                            <!-- Table with outer spacing -->
                            <div class="table-responsive">
                                <table class="table table-striped" id="supplier">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>NAMA SUPLIER</th>
                                            <th>ALAMAT</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                       @foreach ($supliers as $suplier)
                                        <tr>
                                          <td>{{ $loop->iteration }}</td>
                                          <td>{{ $suplier->nama_suplier }}</td>
                                          <td>{{ $suplier->alamat }}</td>
                                          <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('suplier.edit', $suplier->id) }}"
                                                        class="btn btn-success show_confirm"
                                                        style="margin-right: 5px">Edit</a>

                                                    <form action="{{ route('suplier.destroy', $suplier->id) }}"
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
