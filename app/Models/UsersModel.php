<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id_users';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'id_users',
        'nama',
        'password',
        'email',
        'no_telepon',
        'alamat',
        'role',
        'status',
    ];
}