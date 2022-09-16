<?php

namespace App\Models;

use CodeIgniter\Model;

class PermintaanModel extends Model
{
    protected $table = 'permintaan';
    protected $primaryKey = 'id_permintaan';
    protected $useAutoIncrement = false;
    protected $allowedFields = [
        'id_permintaan',
        'id_barang',
        'id_users',
        'tgl_permintaan',
        'status',
        'jumlah',
        'keterangan',
    ];
}