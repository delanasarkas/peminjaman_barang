<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivitylogModel extends Model
{
    protected $table = 'activity_log';
    protected $primaryKey = 'id_log';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'id_log',
        'id_users',
        'keterangan_aktivitas',
        'tgl_aktivitas',
    ];
}