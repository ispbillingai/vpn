<?php

namespace App\Controllers;

use App\Models\VpnModel;

class Vpn extends BaseController
{
    public function create()
    {
        $session = session();
        error_log('Accessing Vpn::create');
        error_log('Session Data: ' . json_encode($session->get()));

        $data = [
            'title' => [
                'icon' => 'fas fa-network-wired',
                'module' => 'VPN',
                'page' => 'Create VPN'
            ],
            'breadcrumb' => [
                ['route' => 'dashboard', 'title' => 'Dashboard', 'active' => false],
                ['route' => 'vpn/create', 'title' => 'Create VPN', 'active' => true]
            ]
        ];

        echo view('themes/backend/focus2/main/header', $data);
        echo view('themes/backend/focus2/form/vpn/create', $data);
        echo view('themes/backend/focus2/main/footer', $data);
    }

    public function list()
    {
        $session = session();
        error_log('Accessing Vpn::list');
        error_log('Session Data: ' . json_encode($session->get()));

        $vpnModel = new VpnModel();
        $data = [
            'title' => [
                'icon' => 'fas fa-network-wired',
                'module' => 'VPN',
                'page' => 'List VPNs'
            ],
            'breadcrumb' => [
                ['route' => 'dashboard', 'title' => 'Dashboard', 'active' => false],
                ['route' => 'vpn/list', 'title' => 'List VPNs', 'active' => true]
            ],
            'vpns' => $vpnModel->findAll()
        ];

        echo view('themes/backend/focus2/main/header', $data);
        echo view('themes/backend/focus2/form/vpn/list', $data);
        echo view('themes/backend/focus2/main/footer', $data);
    }

    public function store()
    {
        $session = session();
        error_log('Accessing Vpn::store');
        error_log('Session Data: ' . json_encode($session->get()));

        $vpnModel = new VpnModel();
        $data = [
            'name' => $this->request->getPost('vpnName'),
            // Add other fields as necessary
        ];
        $vpnModel->save($data);

        return redirect()->to('/vpn/list');
    }
}
