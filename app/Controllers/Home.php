<?php

namespace App\Controllers;
use App\Models\BarangModel;
use App\Models\UsersModel;
use App\Models\PermintaanModel;

class Home extends BaseController
{
    public function index()
    {
        if(is_null(session()->get('logged_in'))){
            return redirect()->to('/login');
        } else {
            $user = session()->get('role');

            if($user != 'teknisi') {
                $db = \Config\Database::connect();
                $barangModel = new BarangModel();
                $usersModel = new UsersModel();
                $permintaanModel = new PermintaanModel();

                $countBarang = $db->query("SELECT SUM(qty_barang) as total FROM barang")->getResult('array');
                $countKaryawan = $usersModel->select('count(id_users) as total')->where('role !=' ,'master')->first();
                $countTeknisi = $usersModel->select('count(id_users) as total')->where('role' ,'teknisi')->first();
                $countDipinjam = $db->query("SELECT COUNT(a.id_permintaan) as total FROM permintaan a, peminjaman b WHERE b.id_permintaan = a.id_permintaan AND a.status = 'diterima' AND DATE(b.tgl_diterima) = DATE(CURRENT_DATE())")->getResult('array');
                $countDikembalikan = $db->query("SELECT COUNT(a.id_permintaan) as total FROM permintaan a, peminjaman b WHERE b.id_permintaan = a.id_permintaan AND a.status = 'selesai' AND DATE(b.tgl_diterima) = DATE(CURRENT_DATE())")->getResult('array');
                $grafikKaryawan = $db->query("SELECT users.nama, IF(permintaan.status = 'diterima' OR permintaan.status = 'tolak dialihkan', IFNULL(SUM(permintaan.jumlah), 0), 0) as jumlah FROM `users` LEFT JOIN permintaan ON users.id_users = permintaan.id_users WHERE users.role != 'master' AND users.role != 'admin' GROUP BY users.nama")->getResult('array');
                $grafikBarang = $db->query("SELECT nama_barang, qty_barang FROM barang")->getResult('array');

                $data = [
                    'title' => 'Dashboard',
                    'count_karyawan' => $countKaryawan['total'],
                    'count_teknisi' => $countTeknisi['total'],
                    'count_barang' => $countBarang[0]['total'],
                    'count_dipinjam' => $countDipinjam[0]['total'],
                    'count_dikembalikan' => $countDikembalikan[0]['total'],
                    'grafik_karyawans' => $grafikKaryawan,
                    'grafik_barangs' => $grafikBarang,
                ];
            } else {
                $barangModel = new BarangModel();
                $dataBarang = $barangModel->findAll();

                $data = [
                    'title' => 'Dashboard',
                    'barang_list' => $dataBarang
                ];
            }

			return view('dashboard\index', $data);
        }
    }
}
