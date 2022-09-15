<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\UsersModel;

class Karyawan extends BaseController
{
	public function index()
	{
        if(is_null(session()->get('logged_in'))){
            return redirect()->back();
        } else {
            $usersModel = new UsersModel();
            $dataUsers = $usersModel->where('role !=', 'master')->findAll();

            $data = [
				'title' => 'Karyawan',
                'users_list' => $dataUsers,
			];

            return view('dashboard\karyawan\index', $data);
        }
	}

    public function tambah()
    {
        if(is_null(session()->get('logged_in'))){
            return redirect()->to('/login');
        } else {
            $usersModel = new UsersModel();

            // GET FIELD VALUE
            $nama = $this->request->getVar('nama');
            $email = $this->request->getVar('email');
            $no_telepon = $this->request->getVar('no_telepon');
            $alamat = $this->request->getVar('alamat');
            $role = $this->request->getVar('role');
            $status = $this->request->getVar('status');
            $password = md5($this->request->getVar('password'));
    
            $usersModel->save([
                'nama' => $nama,
                'email' => $email,
                'no_telepon' => $no_telepon,
                'alamat' => $alamat,
                'role' => $role,
                'status' => $status,
                'password' => $password,
            ]);
    
            session()->setFlashdata('success', 'Tambah karyawan berhasil');
            return redirect()->to('/karyawan');
        }
    }

    public function ubah($id)
    {
        $usersModel = new UsersModel();

        // GET FIELD VALUE
        $nama = $this->request->getVar('nama');
        $email = $this->request->getVar('email');
        $no_telepon = $this->request->getVar('no_telepon');
        $alamat = $this->request->getVar('alamat');
        $role = $this->request->getVar('role');
        $status = $this->request->getVar('status');
        $password = md5($this->request->getVar('password'));

        $usersModel->update($id, [
            'nama' => $nama,
            'email' => $email,
            'no_telepon' => $no_telepon,
            'alamat' => $alamat,
            'role' => $role,
            'status' => $status,
            'password' => $password,
        ]);

        session()->setFlashdata('success', 'Ubah karyawan berhasil');
        return redirect()->to('/karyawan');
    }

    public function hapus($id)
    {
        $usersModel = new UsersModel();

        $usersModel->delete($id);

        session()->setFlashdata('success', 'Karyawan berhasil di hapus');
        return redirect()->to('/karyawan');
    }
}
