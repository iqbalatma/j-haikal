<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Produk;


class ProdukController extends Controller
{
    public function index()
    {
        // $produks as
        $produks = Produk::all();
        return view('kelola.produk.index', compact('produks'));
    }

    public function create()
    {
        return view('kelola.produk.create');
    }

    public function store(Request $request)
    {

        $validasiData = $request->validate([
            'kode_produk' => 'string|required',
            'nama_produk' => 'string|required',
            'jenis_produk' => 'string|required',
            'satuan' => 'string|required',
            'quantity' => 'numeric|required',
            'harga_satuan' => 'string|required'
        ]);

        $produk = Produk::create($validasiData);
        // Alert::success('success', 'Berhasil menambahkan Produk');
        if ($produk) {
            return to_route('produk.index')->with('success', 'Berhasil Menambah Data Produk');
        } else {
            return to_route('produk.index')->with('failed', 'Gagal Menambah Data Produk');
        }
        // return to_route('produk.index');

    }

    public function edit(Produk $produk)
    {
        // $produk = Produk::all();
        return view('kelola.produk.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        $validasiData = $request->validate([
            'kode_produk' => 'string|required',
            'nama_produk' => 'string|required',
            'jenis_produk' => 'string|required',
            'satuan' => 'string|required',
            'harga_satuan' => 'string|required'
        ]);

        $produk->update($validasiData);
        // Alert::success('Success', 'Berhasil menambahkan Produk');
        if ($produk) {

            return to_route('produk.index')->with('success', 'Berhasil Mengedit Data Produk');
        } else {
            return to_route('produk.index')->with('failed', 'Gagal Mengedit Data Produk');
        }
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();
        if ($produk) {
            return to_route('produk.index')->with('success', 'Berhasil Menghapus Data Produk');
        } else {
            return to_route('produk.index')->with('failed', 'Gagal Menghapus Data Produk');
        }
    }

    // public function edit(Produk $produk)
    // {
    //     return view('kelola.produk.edit', compact('produk'));
    // }

    // public function update(Request $request, Produk $produk)
    // {
    //     $validasiData = $request->validate([
    //         'nama_produk' => 'string|required',
    //         'jenis_produk' => 'string|required'
    //     ]);
    //     $produk->update($validasiData);
    //     Alert::success('Success', 'Berhasil edit data');
    //     return to_route('produk.index');
    // }
    // public function destroy(Produk $produk)
    // {
    //     $produk->delete();
    //     Alert::success('Success', 'Berhasil dihapus');
    //     return to_route('produk.index');

    // }
}
