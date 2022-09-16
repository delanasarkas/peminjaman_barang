<?php

namespace App\Controllers;
use App\Models\BarangModel;

class Home extends BaseController
{
    public function index()
    {
        if(is_null(session()->get('logged_in'))){
            return redirect()->to('/login');
        } else {
            $user = session()->get('role');

            if($user != 'teknisi') {
                $data = [
                    'title' => 'Dashboard',
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
