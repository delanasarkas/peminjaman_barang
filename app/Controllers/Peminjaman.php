<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PeminjamanModel;
use App\Models\UsersModel;
use App\Models\PermintaanModel;
use App\Models\ActivitylogModel;
use App\Models\BarangModel;

class Peminjaman extends BaseController
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
				'title' => 'Peminjaman',
                'peminjaman_list' => $dataPeminjaman,
                'data_users' => $dataUsers,
                'data_all_users' => $dataAllUsers,
			];

            return view('dashboard\peminjaman\index', $data);
        }
	}

    public function alihkan($id)
    {
        if(is_null(session()->get('logged_in'))){
            return redirect()->to('/login');
        } else {
            $peminjamanModel = new PeminjamanModel();
            $permintaanModel = new PermintaanModel();
            $usersModel = new UsersModel();
            
            // GET FIELD VALUE
            $id_users = $this->request->getVar('id_users');
            $id_permintaan = $this->request->getVar('id_permintaan');
            $namaUsersDialihkan = $usersModel->find($id_users)['nama'];

            $permintaanModel->update($id_permintaan, [
                'status' => 'proses dialihkan',
            ]);
    
            $peminjamanModel->update($id, [
                'id_dialihkan' => $id_users,
            ]);

            $this->activityModel->save([
                'id_users' => session()->get('id_users'),
                'keterangan_aktivitas' => 'Mengajukan pengalihan peminjaman '. $id_permintaan .' ke '.$namaUsersDialihkan,
                'tgl_aktivitas' => date('Y-m-d H:i:s'),
            ]);
    
            session()->setFlashdata('success', 'Pengalihan akan di proses');
            return redirect()->to('/peminjaman');
        }
    }

    public function kelola($id)
    {
        if(is_null(session()->get('logged_in'))){
            return redirect()->to('/login');
        } else {
            $peminjamanModel = new PeminjamanModel();
            $permintaanModel = new PermintaanModel();
            $usersModel = new UsersModel();
            
            // GET FIELD VALUE
            $id_users = $this->request->getVar('id_users');
            $id_permintaan = $this->request->getVar('id_permintaan');
            $status_selected = $this->request->getVar('status_selected');
            $namaUsersDialihkan = $usersModel->find($id_users)['nama'];
            $getDetailPermintaan = $permintaanModel->find($id_permintaan);

            if($status_selected == 'tolak') {
                $permintaanModel->update($id_permintaan, [
                    'status' => 'tolak dialihkan',
                ]);
        
                $peminjamanModel->update($id, [
                    'id_dialihkan' => null,
                ]);
    
                $this->activityModel->save([
                    'id_users' => session()->get('id_users'),
                    'keterangan_aktivitas' => 'Menolak pengalihan pinjaman '. $id_permintaan .' ke '.$namaUsersDialihkan,
                    'tgl_aktivitas' => date('Y-m-d H:i:s'),
                ]);
        
                session()->setFlashdata('success', 'Pengalihan pinjaman ditolak');
            } else {
                $permintaanModel->update($id_permintaan, [
                    'status' => 'dialihkan',
                ]);
        
                $peminjamanModel->update($id, [
                    'tgl_dialihkan' => date('Y-m-d H:i:s'),
                ]);

                $id_permintaan_new = 'REQ-'.date('dmYHi');

                $permintaanModel->save([
                    'id_permintaan' => $id_permintaan_new,
                    'id_barang' => $getDetailPermintaan['id_barang'],
                    'id_users' => $id_users,
                    'tgl_permintaan' => date('Y-m-d H:i:s'),
                    'status' => 'diterima',
                    'jumlah' => $getDetailPermintaan['jumlah'],
                    'keterangan' => $getDetailPermintaan['keterangan'],
                ]);

                $peminjamanModel->save([
                    'id_permintaan' => $id_permintaan_new,
                    'tgl_diterima' => date('Y-m-d H:i:s'),
                ]);
    
                $this->activityModel->save([
                    'id_users' => session()->get('id_users'),
                    'keterangan_aktivitas' => 'Menerima pengalihan pinjaman '. $id_permintaan .' ke '.$namaUsersDialihkan,
                    'tgl_aktivitas' => date('Y-m-d H:i:s'),
                ]);
        
                session()->setFlashdata('success', 'Pengalihan pinjaman diterima');
            }

            return redirect()->to('/peminjaman');
        }
    }

    public function batal($id)
    {
        if(is_null(session()->get('logged_in'))){
            return redirect()->to('/login');
        } else {
            $peminjamanModel = new PeminjamanModel();
            $permintaanModel = new PermintaanModel();
            $usersModel = new UsersModel();
            
            // GET FIELD VALUE
            $id_users = $this->request->getVar('id_users');
            $id_permintaan = $this->request->getVar('id_permintaan');
            $namaUsersDialihkan = $usersModel->find($id_users)['nama'];

            $permintaanModel->update($id_permintaan, [
                'status' => 'diterima',
            ]);
    
            $peminjamanModel->update($id, [
                'id_dialihkan' => null,
            ]);

            $this->activityModel->save([
                'id_users' => session()->get('id_users'),
                'keterangan_aktivitas' => 'Membatalkan pengalihan pinjaman '. $id_permintaan .' ke '.$namaUsersDialihkan,
                'tgl_aktivitas' => date('Y-m-d H:i:s'),
            ]);
    
            session()->setFlashdata('success', 'Pengalihan dibatalkan');
            return redirect()->to('/peminjaman');
        }
    }

    public function selesai($id)
    {
        if(is_null(session()->get('logged_in'))){
            return redirect()->to('/login');
        } else {
            $peminjamanModel = new PeminjamanModel();
            $permintaanModel = new PermintaanModel();
            $barangModel = new BarangModel();
            $usersModel = new UsersModel();
            
            // GET FIELD VALUE
            $id_users = $this->request->getVar('id_users');
            $id_permintaan = $this->request->getVar('id_permintaan');
            $namaUsersDialihkan = $usersModel->find($id_users)['nama'];
            $jumlahBarangPeminjaman = $permintaanModel->find($id_permintaan)['jumlah'];
            $idBarangPeminjaman = $permintaanModel->find($id_permintaan)['id_barang'];
            $jumlahBarangAsli = $barangModel->find($idBarangPeminjaman)['qty_barang'];

            $permintaanModel->update($id_permintaan, [
                'status' => 'selesai',
            ]);

            $barangModel->update($idBarangPeminjaman, [
                'qty_barang' => (int) $jumlahBarangAsli + (int) $jumlahBarangPeminjaman,
            ]);
    
            $peminjamanModel->update($id, [
                'tgl_dikembalikan' => date('Y-m-d H:i:s'),
            ]);

            $this->activityModel->save([
                'id_users' => session()->get('id_users'),
                'keterangan_aktivitas' => 'Peminjaman di selesaikan '. $id_permintaan,
                'tgl_aktivitas' => date('Y-m-d H:i:s'),
            ]);
    
            session()->setFlashdata('success', 'Peminjaman berhasil di selesaikan');
            return redirect()->to('/peminjaman');
        }
    }
}
