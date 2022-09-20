<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PeminjamanModel;
use App\Models\UsersModel;
use App\Models\PermintaanModel;
use App\Models\ActivitylogModel;
use App\Models\BarangModel;

class Laporan extends BaseController
{
    public function __construct()
    {
        $this->activityModel = new ActivitylogModel();
    }

	public function index()
	{
        if(is_null(session()->get('logged_in'))){
            return redirect()->back();
        } else {
            $usersModel = new UsersModel();
            $db = \Config\Database::connect();
            $dataPeminjaman;
            $id_users = session()->get('id_users');

            $dataUsers = $usersModel->where('role', 'teknisi')->where('id_users !=', $id_users)->findAll();
            $dataAllUsers = $usersModel->findAll();

            // var_dump($dataAllUsers);die;

            if(session()->get('role') == 'admin') {
                $dataPeminjaman = $db->query("SELECT a.id_peminjaman, a.id_permintaan, a.id_dialihkan, a.tgl_diterima, a.tgl_dialihkan, a.tgl_dikembalikan, b.jumlah, b.status, b.id_users as user, c.id_barang, c.nama_barang, d.id_users, d.nama FROM peminjaman a, permintaan b, barang c, users d WHERE a.id_permintaan = b.id_permintaan AND b.id_barang = c.id_barang AND b.id_users = d.id_users ORDER BY a.id_peminjaman DESC")->getResult('array');
            } else {
                $dataPeminjaman = $db->query("SELECT a.id_peminjaman, a.id_permintaan, a.id_dialihkan, a.tgl_diterima, a.tgl_dialihkan, a.tgl_dikembalikan, b.jumlah, b.status, b.id_users as user, c.id_barang, c.nama_barang, d.id_users, d.nama FROM peminjaman a, permintaan b, barang c, users d WHERE a.id_permintaan = b.id_permintaan AND b.id_barang = c.id_barang AND b.id_users = d.id_users ORDER BY a.id_peminjaman DESC")->getResult('array');
            }

            $data = [
				'title' => 'Laporan',
                'peminjaman_list' => $dataPeminjaman,
                'data_users' => $dataUsers,
                'data_all_users' => $dataAllUsers,
			];

            return view('dashboard\laporan\index', $data);
        }
	}
}
