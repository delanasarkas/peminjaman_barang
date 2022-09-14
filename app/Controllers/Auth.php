<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\UsersModel;

class Auth extends BaseController
{
	public function index()
	{
        if(session()->get('logged_in')){
            return redirect()->back();
        } else {
            return view('auth\login');
        }
	}

    public function submit()
	{
        $users = new UsersModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $dataUser = $users->where([
            'email' => $email,
            'password' => md5($password)
        ])->first();
        if ($dataUser) {
            session()->set([
                'id_users' => $dataUser['id_users'],
                'nama' => $dataUser['nama'],
                'email' => $dataUser['email'],
                'no_telepon' => $dataUser['no_telepon'],
                'alamat' => $dataUser['alamat'],
                'role' => $dataUser['role'],
                'status' => $dataUser['status'],
                'logged_in' => TRUE
            ]);
            session()->setFlashdata('success', 'Anda berhasil login');
            return redirect()->to('/');
        } else {
            session()->setFlashdata('error', 'Email & Password Salah');
            return redirect()->back();
        }
	}

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
