<?php

namespace App\Controllers;

use App\Libraries\PasswordHash;
use App\Models\CountriesModel;
use App\Models\UserModel;
use App\Models\NotificationModel;
use App\Models\UserOauthModel;

class Notification extends BaseController
{
    private $user_model;
    private $oauth_model;
    private $countries_model;
    private $id_user;
    private $token_user;
    private $notification_model;
    private $integration;

    function __construct()
    {
        $this->user_model = new UserModel();
        $this->oauth_model = new UserOauthModel();
        $this->countries_model = new CountriesModel();
        $this->id_user = session()->get('id_user');
        $this->token_user = session()->get('token');
        $this->notification_model = new NotificationModel();
        $this->integration = new Integration();
    }

    public function index()
    {
        $data['title'] = [
            'module' => lang("App.notification_title"),
            'page'   => lang("App.notification_subtitle"),
            'icon'  => 'fas fa-bell'
        ];

        $data['breadcrumb'] = [
            ['title' => lang("App.menu_dashboard"), 'route' => "/home", 'active' => false],
            ['title' => lang("App.notification_title"), 'route'  => "", 'active' => true]
        ];

        $data['btn_add'] = [
            'title' => lang("App.notification_btn_add"),
            'route'   => '/notification/add',
            'class'   => 'btn btn-lg btn-primary float-md-right',
            'icon'  => 'fas fa-plus'
        ];

        echo view(getenv('theme.backend.path').'main/header');
        echo view(getenv('theme.backend.path').'form/notification/index',$data);
        echo view(getenv('theme.backend.path').'main/footer');
    }

    public function add()
    {
        helper('form');

        $data['title'] = [
            'module' => lang("App.notification_add_title"),
            'page'   => lang("App.notification_add_subtitle"),
            'icon'  => 'far fa-plus-square'
        ];

        $data['breadcrumb'] = [
            ['title' => lang("App.menu_dashboard"), 'route' => "/home", 'active' => false],
            ['title' => lang("App.notification_title"), 'route' => "/user", 'active' => false],
            ['title' => lang("App.notification_add_title"), 'route'  => "", 'active' => true]
        ];

        $data['btn_return'] = [
            'title' => lang("App.global_come_back"),
            'route'   => '/notification',
            'class'   => 'btn btn-dark mr-1',
            'icon'  => 'fas fa-angle-left'
        ];

        $data['btn_submit'] = [
            'title' => lang("App.global_save"),
            'route'   => '',
            'class'   => 'btn btn-primary mr-1',
            'icon'  => 'fas fa-save'
        ];

        $data['user'] = $this->user_model->where('status',true)->findAll();

        echo view(getenv('theme.backend.path').'main/header');
        echo view(getenv('theme.backend.path').'form/notification/form',$data);
        echo view(getenv('theme.backend.path').'main/footer');
    }

    public function store()
    {
        //Demo Mode
        if(env('demo.mode')??false){
            session()->setFlashdata('sweet', ['warning',lang("App.general_demo_mode")]);
            return redirect()->to('/notification');
        }

        $session = session();
        helper('form');

        $rules = [
            'title' => 'required',
            'body'  => 'required'
        ];

        $rules_error = [
            'title' => [
                'required' => lang("App.notification_rules_title_r"),
            ],
            'body' => [
                'required' => lang("App.notification_rules_body_r"),
            ]
        ];

        if ($this->validate($rules,$rules_error)){
            if($listPost = $this->request->getPost()){

                $listPost['send_email_notification'] = isset($listPost['send_email_notification']) && $listPost['send_email_notification'] == 'on';
                $listPost['send_sms_notification'] = isset($listPost['send_sms_notification']) && $listPost['send_sms_notification'] == 'on';

                if(!empty($listPost['user_recipient'])){
                    $user = $this->user_model->where('token',$session->get('token'))->first();
                    foreach (keywordEmail()??[] as $item){
                        $field = str_replace(['[','user_',']'],'',$item);
                        $listPost['title'] = str_replace('['.$item.']',$user[$field],$listPost['title']);
                        $listPost['body'] = str_replace('['.$item.']',$user[$field],$listPost['body']);
                    }
                    $listPost['token'] = md5(uniqid(rand(), true));
                    $listPost['user_sender'] = $session->get('token');

                    $data['title'] = lang("App.notification_title_pusher");
                    $data['message'] = $listPost['title'];
                    $data['token'] = $listPost['token'];
                    $phpass = new PasswordHash(8, true);
                    $this->integration->send_pusher($listPost['user_recipient'],$data,$phpass->HashPassword(MD5($listPost['user_recipient'])));

                    $this->notification_model->save($listPost);
                }else{
                    $users = $this->user_model->where('status',true)->findAll();
                    $data = [];
                    foreach ($users as $user){
                        $title = $listPost['title'];
                        $template = $listPost['body'];
                        foreach (keywordEmail()??[] as $item){
                            $field = str_replace(['[','user_',']'],'',$item);
                            $title = str_replace('['.$item.']',$user[$field],$title);
                            $template = str_replace('['.$item.']',$user[$field],$template);
                        }
                        $token = md5(uniqid(rand(), true));
                        array_push($data,[
                            'id_notification'           => null,
                            'user_sender'               => $session->get('token'),
                            'user_recipient'            => $user['token'],
                            'title'                     => $title,
                            'body'                      => $template,
                            'is_read'                   => false,
                            'is_send_email'             => false,
                            'is_send_sms'               => false,
                            'send_email_notification'   => $listPost['send_email_notification'],
                            'send_sms_notification'     => $listPost['send_sms_notification'],
                            'token'                     => $token,
                            'created_at'                => date('Y-m-d H:i:s'),
                            'updated_at'                => date('Y-m-d H:i:s')
                        ]);
                    }
                    if(count($data)>0){
                        $this->notification_model->insertBatch($data);
                    }
                    if(count($data)>0){
                        foreach ($data as $item){
                            $data['title'] = lang("App.notification_title_pusher");
                            $data['message'] = $item['title'];
                            $data['token'] = $item['token'];
                            $phpass = new PasswordHash(8, true);
                            $this->integration->send_pusher($item['user_recipient'],$data,$phpass->HashPassword(MD5($item['user_recipient'])));
                        }
                    }
                }
                if(empty($this->request->getPost('id_notification'))){
                    $session->setFlashdata('sweet', ['success',lang("App.notification_alert_add")]);
                    return redirect()->to('/notification');
                }else{
                    $session->setFlashdata('sweet', ['success',lang("App.notification_alert_edit")]);
                    return redirect()->to('/notification');
                }
            }
        }else{
            $session->setFlashdata('error','error');
            $this->add();
        }
    }

    public function delete($token)
    {
        //Demo Mode
        if(env('demo.mode')??false){
            session()->setFlashdata('sweet', ['warning',lang("App.general_demo_mode")]);
            return redirect()->to('/notification');
        }

        $session = session();
        if(!empty($session->get('token'))){
            $this->notification_model->where('token', $token)->delete();
            $session->setFlashdata('sweet', ['success',lang("App.notification_alert_delete")]);
            return redirect()->to('/notification');
        }else{
            return redirect()->to('/login');
        }
    }


}
