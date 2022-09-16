<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\KategoriModel;
use App\Models\ActivitylogModel;

class Kategori extends BaseController
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
            $kategoriModel = new KategoriModel();
            $dataKategori = $kategoriModel->orderBy('id_kategori', 'DESC')->findAll();

            $data = [
				'title' => 'Kategori',
                'kategori_list' => $dataKategori,
			];

            return view('dashboard\kategori\index', $data);
        }
	}

    public function tambah()
    {
        if(is_null(session()->get('logged_in'))){
            return redirect()->to('/login');
        } else {
            $kategoriModel = new KategoriModel();

            // GET FIELD VALUE
            $nama_kategori = $this->request->getVar('nama_kategori');
    
            $kategoriModel->save([
                'nama_kategori' => $nama_kategori,
            ]);

            $this->activityModel->save([
                'id_users' => session()->get('id_users'),
                'keterangan_aktivitas' => 'Menambah data kategori '. $nama_kategori,
                'tgl_aktivitas' => date('Y-m-d H:i:s'),
            ]);
    
            session()->setFlashdata('success', 'Tambah kategori berhasil');
            return redirect()->to('/kategori');
        }
    }

    public function ubah($id)
    {
        $kategoriModel = new KategoriModel();

        // GET FIELD VALUE
        $nama_kategori = $this->request->getVar('nama_kategori');

        $kategoriModel->update($id,[
            'nama_kategori' => $nama_kategori,
        ]);

        $this->activityModel->save([
            'id_users' => session()->get('id_users'),
            'keterangan_aktivitas' => 'Mengubah data kategori dengan id '. $id,
            'tgl_aktivitas' => date('Y-m-d H:i:s'),
        ]);

        session()->setFlashdata('success', 'Ubah kategori berhasil');
        return redirect()->to('/kategori');
    }

    public function hapus($id)
    {
        $kategoriModel = new KategoriModel();

        $kategoriModel->delete($id);

        $this->activityModel->save([
            'id_users' => session()->get('id_users'),
            'keterangan_aktivitas' => 'Menghapus data kategori dengan id '. $id,
            'tgl_aktivitas' => date('Y-m-d H:i:s'),
        ]);

        session()->setFlashdata('success', 'Kategori berhasil di hapus');
        return redirect()->to('/kategori');
    }
}
