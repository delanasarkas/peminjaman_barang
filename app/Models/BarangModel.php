<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'id_barang',
        'id_kategori',
        'nama_barang',
        'qty_barang',
        'deskripsi_barang',
    ];
}