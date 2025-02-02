@extends('kerangka.master')
@section('title', 'Halaman Produk')
@section('content')
    <!-- Basic Tables start -->

    <section class="section">
        <div class="row" id="basic-table">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Table Kelola Pengguna</h4>
                        <div class="ms-auto">
                        <a class="btn btn-primary" href="{{ route('users.create') }}">Tambah Pengguna</a>
                        </div>
                    </div>


                    <div class="card-content">
                        <div class="card-body">
                            <!-- Table with outer spacing -->
                            <div class="table-responsive">
                                <table class="table table-striped" id="product">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>NAMA</th>
                                            <th>EMAIL</th>
                                            <th>ROLE</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                       @foreach ($users as $user)
                                        <tr>
                                          <td>{{ $loop->iteration }}</td>
                                          <td>{{ $user->name }}</td>
                                          <td>{{ $user->email }}</td>
                                          <td>{{ $user->role }}</td>
                                          <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('users.edit', $user->id) }}"
                                                        class="btn btn-success show_confirm"
                                                        style="margin-right: 5px">Edit</a>

                                                    <form action="{{ route('users.destroy', $user->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
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
