<?php
namespace App\Controllers;

use App\Models\VpnModel;

class Vpn extends BaseController
{
    public function create()
    {
        try {
            echo view('themes/backend/focus2/main/header');
            echo view('themes/backend/focus2/form/vpn/create');
            echo view('themes/backend/focus2/main/footer');
        } catch (\Exception $e) {
            echo 'Error loading the page: ' . $e->getMessage();
        }
    }

    public function list()
    {
        $vpnModel = new VpnModel();
        $data['vpns'] = $vpnModel->findAll();

        try {
            echo view('themes/backend/focus2/main/header');
            echo view('themes/backend/focus2/form/vpn/list', $data);
            echo view('themes/backend/focus2/main/footer');
        } catch (\Exception $e) {
            echo 'Error loading the page: ' . $e->getMessage();
        }
    }

    public function store()
    {
        $vpnModel = new VpnModel();
        $data = ['name' => $this->request->getPost('vpnName')];

        try {
            $vpnModel->save($data);
            return redirect()->to('/vpn/list');
        } catch (\Exception $e) {
            echo 'Error saving the VPN: ' . $e->getMessage();
        }
    }
}
