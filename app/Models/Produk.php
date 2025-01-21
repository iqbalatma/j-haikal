<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $lable = "produks";
    protected $fillable = ['kode_produk', 'nama_produk', 'jenis_produk', 'satuan', 'harga_satuan', "quantity"];
}
