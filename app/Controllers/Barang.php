<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\KategoriModel;
use App\Models\BarangModel;

class Barang extends BaseController
{
	public function index()
	{
        if(is_null(session()->get('logged_in'))){
            return redirect()->back();
        } else {
            $kategoriModel = new KategoriModel();
            $dataKategori = $kategoriModel->findAll();

            $db = \Config\Database::connect();
            $dataBarang = $db->query("SELECT a.id_barang, a.nama_barang, a.qty_barang, a.deskripsi_barang, b.id_kategori, b.nama_kategori FROM barang a, kategori b WHERE a.id_kategori = b.id_kategori")->getResult('array');

            $data = [
				'title' => 'Barang',
                'kategori_list' => $dataKategori,
                'barang_list' => $dataBarang
			];

            return view('dashboard\barang\index', $data);
        }
	}

    public function tambah()
    {
        if(is_null(session()->get('logged_in'))){
            return redirect()->to('/login');
        } else {
            $barangModel = new BarangModel();

            // GET FIELD VALUE
            $kategori = $this->request->getVar('kategori');
            $nama_barang = $this->request->getVar('nama_barang');
            $qty = $this->request->getVar('qty');
            $deskripsi = $this->request->getVar('deskripsi');
    
            $barangModel->save([
                'id_kategori' => $kategori,
                'nama_barang' => $nama_barang,
                'qty_barang' => $qty,
                'deskripsi_barang' => $deskripsi,
            ]);
    
            session()->setFlashdata('success', 'Tambah barang berhasil');
            return redirect()->to('/barang');
        }
    }

    public function ubah($id)
    {
        $barangModel = new BarangModel();

        // GET FIELD VALUE
        $kategori = $this->request->getVar('kategori');
        $nama_barang = $this->request->getVar('nama_barang');
        $qty = $this->request->getVar('qty');
        $deskripsi = $this->request->getVar('deskripsi');

        $barangModel->update($id,[
            'id_kategori' => $kategori,
            'nama_barang' => $nama_barang,
            'qty_barang' => $qty,
            'deskripsi_barang' => $deskripsi,
        ]);

        session()->setFlashdata('success', 'Ubah barang berhasil');
        return redirect()->to('/barang');
    }

    public function hapus($id)
    {
        $barangModel = new BarangModel();

        $barangModel->delete($id);

        session()->setFlashdata('success', 'Barang berhasil di hapus');
        return redirect()->to('/barang');
    }
}
