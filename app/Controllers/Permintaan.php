<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermintaanModel;
use App\Models\ActivitylogModel;
use App\Models\BarangModel;
use App\Models\PeminjamanModel;

class Permintaan extends BaseController
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
            if(session()->get('role') == 'master') {
                return redirect()->back();
            }

            $barangModel = new BarangModel();
            $dataBarang = $barangModel->findAll();
            $db = \Config\Database::connect();
            $id_users = session()->get('id_users');
            $dataPermintaan;

            if(session()->get('role') == 'admin') {
                $dataPermintaan = $db->query("SELECT a.id_permintaan, a.id_barang, a.id_users, a.tgl_permintaan, a.status, a.jumlah, a.keterangan, b.nama_barang, c.nama FROM permintaan a, barang b, users c WHERE a.id_barang = b.id_barang AND a.id_users = c.id_users AND (a.status = 'proses' || a.status = 'ditolak') ORDER BY tgl_permintaan DESC")->getResult('array');
            } else if(session()->get('role') == 'teknisi') {
                $dataPermintaan = $db->query("SELECT a.id_permintaan, a.id_barang, a.id_users, a.tgl_permintaan, a.status, a.jumlah, a.keterangan, b.nama_barang, c.nama FROM permintaan a, barang b, users c WHERE a.id_barang = b.id_barang AND a.id_users = c.id_users AND (a.status = 'proses' || a.status = 'ditolak') AND a.id_users = $id_users ORDER BY tgl_permintaan DESC")->getResult('array');
            }


            $data = [
				'title' => 'Permintaan',
                'permintaan_list' => $dataPermintaan,
                'data_barang' => $dataBarang
			];

            return view('dashboard\permintaan\index', $data);
        }
	}

    public function tambah()
    {
        if(is_null(session()->get('logged_in'))){
            return redirect()->to('/login');
        } else {
            $permintaanModel = new PermintaanModel();
            $barangModel = new BarangModel();

            $id_permintaan = 'REQ-'.date('dmYHi');
            $id_users = session()->get('id_users');

            // GET FIELD VALUE
            $id_barang = $this->request->getVar('id_barang');
            $nama_barang = $barangModel->find($id_barang)['nama_barang'];
            $tgl_permintaan = date('Y-m-d H:i:s');
            $jumlah = $this->request->getVar('jumlah');
            $jumlah_asli = $barangModel->find($id_barang)['qty_barang'];
            $keterangan = $this->request->getVar('keterangan');

            $calculate = (int) $jumlah_asli - (int) $jumlah;

            if($jumlah > $jumlah_asli) {
                session()->setFlashdata('error', 'Jumlah barang melampaui stok');
                return redirect()->to('/permintaan');
            } else {
                $permintaanModel->save([
                    'id_permintaan' => $id_permintaan,
                    'id_barang' => $id_barang,
                    'id_users' => $id_users,
                    'tgl_permintaan' => $tgl_permintaan,
                    'status' => 'proses',
                    'jumlah' => $jumlah,
                    'keterangan' => $keterangan,
                ]);

                $barangModel->update($id_barang, [
                    'qty_barang' => $calculate
                ]);
    
                $this->activityModel->save([
                    'id_users' => session()->get('id_users'),
                    'keterangan_aktivitas' => 'Mengajukan permintaan '. $nama_barang .' ('.$jumlah.')',
                    'tgl_aktivitas' => date('Y-m-d H:i:s'),
                ]);
        
                session()->setFlashdata('success', 'Mengajukan permintaan berhasil');
                return redirect()->to('/permintaan');
            }
        }
    }

    public function tambah_by_id()
    {
        if(is_null(session()->get('logged_in'))){
            return redirect()->to('/login');
        } else {
            $permintaanModel = new PermintaanModel();
            $barangModel = new BarangModel();

            $id_permintaan = 'REQ-'.date('dmYHi');
            $id_users = session()->get('id_users');

            // GET FIELD VALUE
            $id_barang = $this->request->getVar('id_barang');
            $nama_barang = $this->request->getVar('nama_barang');
            $tgl_permintaan = date('Y-m-d H:i:s');
            $jumlah = $this->request->getVar('jumlah');
            $jumlah_asli = $this->request->getVar('jumlah_asli');
            $keterangan = $this->request->getVar('keterangan');
            
            $calculate = (int) $jumlah_asli - (int) $jumlah;

            if($jumlah > $jumlah_asli) {
                session()->setFlashdata('error', 'Jumlah barang melampaui stok');
                return redirect()->to('/');
            } else {
                $permintaanModel->save([
                    'id_permintaan' => $id_permintaan,
                    'id_barang' => $id_barang,
                    'id_users' => $id_users,
                    'tgl_permintaan' => $tgl_permintaan,
                    'status' => 'proses',
                    'jumlah' => $jumlah,
                    'keterangan' => $keterangan,
                ]);
    
                $barangModel->update($id_barang, [
                    'qty_barang' => $calculate
                ]);
    
                $this->activityModel->save([
                    'id_users' => session()->get('id_users'),
                    'keterangan_aktivitas' => 'Mengajukan permintaan '. $nama_barang .' ('.$jumlah.')',
                    'tgl_aktivitas' => date('Y-m-d H:i:s'),
                ]);
        
                session()->setFlashdata('success', 'Mengajukan permintaan berhasil');
                return redirect()->to('/');
            }
        }
    }

    public function kelola($id)
    {
        if(is_null(session()->get('logged_in'))){
            return redirect()->to('/login');
        } else {
            $permintaanModel = new PermintaanModel();
            $barangModel = new BarangModel();
            $peminjamanModel = new PeminjamanModel();

            // GET FIELD VALUE
            $status_selected = $this->request->getVar('status_selected');
            $id_barang = $this->request->getVar('id_barang');
            $jumlah = $this->request->getVar('jumlah');

            $permintaanModel->update($id, [
                'status' => $status_selected == 'tolak' ? 'ditolak' : 'diterima'
            ]);

            if($status_selected == 'tolak') {
                $getJumlahBarang = $barangModel->find($id_barang);
                $parseJumlahBarang = (int) $getJumlahBarang['qty_barang'] + (int) $jumlah;

                $barangModel->update($id_barang, [
                    'qty_barang' => $parseJumlahBarang
                ]);
            } else {
                $peminjamanModel->save([
                    'id_permintaan' => $id, 
                    'tgl_diterima' => date('Y-m-d H:i:s'), 
                ]);
            }

            $activityTolak = 'Menolak permintaan '.$id; 
            $activityTerima = 'Menerima permintaan '.$id; 

            $this->activityModel->save([
                'id_users' => session()->get('id_users'),
                'keterangan_aktivitas' => $status_selected == 'tolak' ? $activityTolak : $activityTerima,
                'tgl_aktivitas' => date('Y-m-d H:i:s'),
            ]);

            session()->setFlashdata('success', $status_selected == 'tolak' ? 'Permintaan ditolak' : 'Permintaan berhasil diterima');
            return redirect()->to('/permintaan');
        }
    }

    public function ulang($id)
    {
        if(is_null(session()->get('logged_in'))){
            return redirect()->to('/login');
        } else {
            $permintaanModel = new PermintaanModel();
            $barangModel = new BarangModel();

            // GET FIELD VALUE
            $id_barang = $this->request->getVar('id_barang');
            $jumlah = $this->request->getVar('jumlah');
            $jumlah_asli = $barangModel->find($id_barang)['qty_barang'];
            
            $calculate = (int) $jumlah_asli - (int) $jumlah;

            if($jumlah > $jumlah_asli) {
                session()->setFlashdata('error', 'Jumlah barang melampaui stok');
                return redirect()->to('/');
            } else {
                $permintaanModel->update($id, [
                    'status' => 'proses',
                ]);
    
                $barangModel->update($id_barang, [
                    'qty_barang' => $calculate
                ]);
    
                $this->activityModel->save([
                    'id_users' => session()->get('id_users'),
                    'keterangan_aktivitas' => 'Mengajukan ulang permintaan '. $id,
                    'tgl_aktivitas' => date('Y-m-d H:i:s'),
                ]);
        
                session()->setFlashdata('success', 'Mengajukan ulang permintaan berhasil');
                return redirect()->to('/permintaan');
            }
        }
    }

    public function batal($id)
    {
        if(is_null(session()->get('logged_in'))){
            return redirect()->to('/login');
        } else {
            $permintaanModel = new PermintaanModel();

            $permintaanModel->delete($id);

            $this->activityModel->save([
                'id_users' => session()->get('id_users'),
                'keterangan_aktivitas' => 'Membatalkan permintaan '. $id,
                'tgl_aktivitas' => date('Y-m-d H:i:s'),
            ]);
    
            session()->setFlashdata('success', 'Membatalkan permintaan berhasil');
            return redirect()->to('/permintaan');
        }
    }

    public function hapus($id)
    {
        $permintaanModel = new PermintaanModel();

        $permintaanModel->delete($id);

        $this->activityModel->save([
            'id_users' => session()->get('id_users'),
            'keterangan_aktivitas' => 'Menghapus permintaan '. $id,
            'tgl_aktivitas' => date('Y-m-d H:i:s'),
        ]);

        session()->setFlashdata('success', 'Permintaan berhasil di hapus');
        return redirect()->to('/permintaan');
    }
}
