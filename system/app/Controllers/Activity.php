<?php

namespace App\Controllers;

use App\Models\ActivityModel;
use App\Models\UserModel;

class Activity extends BaseController
{
    private $user_model;
    private $activity_model;

    function __construct()
    {
        $this->user_model = new UserModel();
        $this->activity_model = new ActivityModel();
    }

    public function index()
    {
        $session = session();

        $data['title'] = [
            'module' => lang("App.activity_title"),
            'page'   => lang("App.activity_subtitle"),
            'icon'  => 'fas fa-list'
        ];

        $data['breadcrumb'] = [
            ['title' => lang("App.menu_dashboard"), 'route' => "/home", 'active' => false],
            ['title' => lang("App.activity_title"), 'route'  => "", 'active' => true]
        ];

        $data['logs'] = $this->activity_model->select('SUM( IF( os LIKE "%Windows%", 1, 0 ) ) AS windows, 
                                                                 SUM( IF( os = "Mac OS X", 1, 0 ) ) AS mac, 
                                                                 SUM( IF( os = "Linux", 1, 0 ) ) AS linux, 
                                                                 SUM( IF( os = "Android", 1, 0 ) ) AS android, 
                                                                 SUM( IF( os = "iOS", 1, 0 ) ) AS iphone, 
                                                                 SUM( IF( browser LIKE "%Chrome%", 1, 0 ) ) AS chrome, 
                                                                 SUM( IF( browser LIKE "%Firefox%", 1, 0 ) ) AS firefox, 
                                                                 SUM( IF( browser LIKE "%Safari%", 1, 0 ) ) AS safari, 
                                                                 SUM( IF( browser LIKE "%Internet Explorer%", 1, 0 ) ) AS ie, 
                                                                 SUM( IF( browser LIKE "%Edge%", 1, 0 ) ) AS edge, 
                                                                 SUM( IF( browser LIKE "%Opera%", 1, 0 ) ) AS opera')->where('activity.user',$session->get('token'))->first();
        $data['all'] = "";
        echo view(getenv('theme.backend.path').'main/header');
        echo view(getenv('theme.backend.path').'form/activity/index',$data);
        echo view(getenv('theme.backend.path').'main/footer');
    }

    public function all()
    {
        $session = session();
        $dashboard = $session->get('dashboard')??'user';
        if($dashboard != 'admin'){
            return redirect()->to('/activity');
        }

        $data['title'] = [
            'module' => lang("App.activity_title"),
            'page'   => lang("App.activity_subtitle"),
            'icon'  => 'fas fa-list'
        ];

        $data['breadcrumb'] = [
            ['title' => lang("App.menu_dashboard"), 'route' => "/home", 'active' => false],
            ['title' => lang("App.activity_title"), 'route'  => "", 'active' => true]
        ];

        $data['logs'] = $this->activity_model->select('SUM( IF( os LIKE "%Windows%", 1, 0 ) ) AS windows, 
                                                                 SUM( IF( os = "Mac OS X", 1, 0 ) ) AS mac, 
                                                                 SUM( IF( os = "Linux", 1, 0 ) ) AS linux, 
                                                                 SUM( IF( os = "Android", 1, 0 ) ) AS android, 
                                                                 SUM( IF( os = "iOS", 1, 0 ) ) AS iphone, 
                                                                 SUM( IF( browser LIKE "%Chrome%", 1, 0 ) ) AS chrome, 
                                                                 SUM( IF( browser LIKE "%Firefox%", 1, 0 ) ) AS firefox, 
                                                                 SUM( IF( browser LIKE "%Safari%", 1, 0 ) ) AS safari, 
                                                                 SUM( IF( browser LIKE "%Internet Explorer%", 1, 0 ) ) AS ie, 
                                                                 SUM( IF( browser LIKE "%Edge%", 1, 0 ) ) AS edge, 
                                                                 SUM( IF( browser LIKE "%Opera%", 1, 0 ) ) AS opera')->first();
        $data['all'] = "/all";
        echo view(getenv('theme.backend.path').'main/header');
        echo view(getenv('theme.backend.path').'form/activity/index',$data);
        echo view(getenv('theme.backend.path').'main/footer');
    }
}
