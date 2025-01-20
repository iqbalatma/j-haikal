<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Suplier;

class SuplierController extends Controller
{
     public function index()
    {
        // $produks as 
        $supliers = Suplier::all();
        return view('kelola.suplier.index', compact('supliers'));
    }

    public function create()
    {
        return view('kelola.suplier.create');
    }

    public function store(Request $request)
    {

        $validasiData = $request->validate([
            'nama_suplier' => 'string|required',
            'alamat' => 'string|required'
        ]);

        $suplier = Suplier::create($validasiData);
        // Alert::success('success', 'Berhasil menambahkan Produk');
        if ($suplier){
            return to_route('suplier.index')->with('success', 'Berhasil Menambah Data Suplier');
        } else {
            return to_route('suplier.index')->with('failed', 'Gagal Menambah Data Suplier');
        }
        // return to_route('produk.index');

    }
    public function edit(Suplier $suplier)
    {
        // $produk = Produk::all();
        return view('kelola.suplier.edit', compact('suplier'));
    }
    public function update(Request $request, Suplier $suplier)
    {
         $validasiData = $request->validate([
            'nama_suplier' => 'string|required',
            'alamat' => 'string|required'
        ]);

        $suplier->update($validasiData);
        // Alert::success('Success', 'Berhasil menambahkan Produk');
        if ($suplier){
          
            return to_route('suplier.index')->with('success', 'Berhasil Mengedit Data Suplier');
        } else {
            return to_route('suplier.index')->with('failed', 'Gagal Mengedit Data Suplier');
        }
    }
    public function destroy(Suplier $suplier)
    {
        $suplier->delete();
                if ($suplier){
            return to_route('suplier.index')->with('success', 'Berhasil Menghapus Data Suplier');
        } else {
            return to_route('suplier.index')->with('failed', 'Gagal Menghapus Data Suplier');
        }
    }
}