<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if(is_null(session()->get('logged_in'))){
            return redirect()->to('/login');
        } else {
            $data = [
				'title' => 'Dashboard',
			];

			return view('dashboard\index', $data);
        }
    }
}
