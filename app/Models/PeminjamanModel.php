<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'id_peminjaman',
        'id_permintaan',
        'id_dialihkan',
        'tgl_diterima',
        'tgl_dialihkan',
        'tgl_dikembalikan',
    ];
}