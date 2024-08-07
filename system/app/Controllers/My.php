<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use App\Models\UserModel;

class My extends BaseController
{

    private $user_model;
    private $notification_model;

    function __construct()
    {
        $this->user_model = new UserModel();
        $this->notification_model = new NotificationModel();
    }

    public function index()
    {
        return redirect()->to('profile');
    }

    public function notification()
    {
        $session = session();
        $data['title'] = [
            'module' => lang("App.notification_title_my"),
            'page'   => lang("App.notification_subtitle_my"),
            'icon'  => 'fas fa-bell'
        ];

        $data['breadcrumb'] = [
            ['title' => lang("App.menu_dashboard"), 'route' => "/home", 'active' => false],
            ['title' => lang("App.notification_title_my"), 'route'  => "", 'active' => true]
        ];

        $data['btn_add'] = [
            'title' => lang("App.notification_btn_add"),
            'route'   => '/notification/add',
            'class'   => 'btn btn-lg btn-primary float-md-right',
            'icon'  => 'fas fa-plus'
        ];

        echo view(getenv('theme.backend.path').'main/header');
        echo view(getenv('theme.backend.path').'form/my/notification',$data);
        echo view(getenv('theme.backend.path').'main/footer');
    }

    public function notification_view($id)
    {
        $session = session();
        $token = session()->get('token');
        $data['obj'] = $this->notification_model->where('token', $id)->where('user_recipient', $token)->first();
        if($data['obj']==null){
            return redirect()->to('/my/notification');
        }else{
            if(!$data['obj']['is_read']){
                $this->notification_model->save(['id_notification' => $data['obj']['id_notification'],'is_read' => true]);
                $notification = $session->get('notification')??[];
                foreach ($notification as $key => $value){
                    if($notification[$key]['token'] == $id){
                        $notification[$key]['is_read'] = '1';
                    }
                }
                $pulse = $this->notification_model->where('user_recipient',$session->get('token'))->where('is_read',false)->countAllResults() ?? 0;
                $session->set('pulse', $pulse);
                $session->set('notification',$notification);
            }
        }

        $data['title'] = [
            'module' => lang("App.notification_title_my"),
            'page'   => lang("App.notification_subtitle_view"),
            'icon'  => 'far fa-envelope-open'
        ];

        $data['breadcrumb'] = [
            ['title' => lang("App.menu_dashboard"), 'route' => "/home", 'active' => false],
            ['title' => lang("App.notification_title_my"), 'route'  => "/my/notification", 'active' => false],
            ['title' => lang("App.notification_subtitle_view"), 'route'  => "", 'active' => true]
        ];

        $data['btn_return'] = [
            'title' => lang("App.global_come_back"),
            'route'   => '/my/notification',
            'class'   => 'btn btn-dark mr-1',
            'icon'  => 'fas fa-angle-left'
        ];

        echo view(getenv('theme.backend.path').'main/header');
        echo view(getenv('theme.backend.path').'form/my/view',$data);
        echo view(getenv('theme.backend.path').'main/footer');
    }
}
