<?php

namespace App\Controllers;

use App\Libraries\PasswordHash;
use App\Models\ActivityModel;
use App\Models\CountriesModel;
use App\Models\UserModel;
use App\Models\UserGroupModel;
use App\Models\UserOauthModel;

class User extends BaseController
{
    private $user_model;
    private $group_model;
    private $oauth_model;
    private $countries_model;
    private $activity_model;

    function __construct()
    {
        $this->user_model = new UserModel();
        $this->group_model = new UserGroupModel();
        $this->oauth_model = new UserOauthModel();
        $this->countries_model = new CountriesModel();
        $this->activity_model = new ActivityModel();
    }

    public function index()
    {
        $data['title'] = [
            'module' => lang("App.user_title"),
            'page'   => lang("App.user_subtitle"),
            'icon'  => 'fas fa-user-friends'
        ];

        $data['breadcrumb'] = [
            ['title' => lang("App.menu_dashboard"), 'route' => "/home", 'active' => false],
            ['title' => lang("App.user_title"), 'route'  => "", 'active' => true]
        ];

        $data['btn_add'] = [
            'title' => lang("App.user_btn_add"),
            'route'   => '/user/add',
            'class'   => 'btn btn-lg btn-primary float-md-right',
            'icon'  => 'fas fa-plus'
        ];

        echo view(getenv('theme.backend.path').'main/header');
        echo view(getenv('theme.backend.path').'form/user/index',$data);
        echo view(getenv('theme.backend.path').'main/footer');
    }

    public function add()
    {
        helper('form');

        $data['title'] = [
            'module' => lang("App.user_add_title"),
            'page'   => lang("App.user_add_subtitle"),
            'icon'  => 'far fa-plus-square'
        ];

        $data['breadcrumb'] = [
            ['title' => lang("App.menu_dashboard"), 'route' => "/home", 'active' => false],
            ['title' => lang("App.user_title"), 'route' => "/user", 'active' => false],
            ['title' => lang("App.user_add_title"), 'route'  => "", 'active' => true]
        ];

        $data['btn_return'] = [
            'title' => lang("App.global_come_back"),
            'route'   => '/user',
            'class'   => 'btn btn-dark mr-1',
            'icon'  => 'fas fa-angle-left'
        ];

        $data['btn_submit'] = [
            'title' => lang("App.global_save"),
            'route'   => '',
            'class'   => 'btn btn-primary mr-1',
            'icon'  => 'fas fa-save'
        ];

        $data['group'] = $this->group_model->select('token,title')->findAll();
        $data['country'] = $this->countries_model->select('code,name')->where('data_lang',session()->get('lang')??'en')->findAll();

        echo view(getenv('theme.backend.path').'main/header');
        echo view(getenv('theme.backend.path').'form/user/form',$data);
        echo view(getenv('theme.backend.path').'main/footer');
    }

    public function edit($token=null)
    {
        if(empty($token)){
            return redirect()->to('/user');
        }

        helper('form');

        $data['title'] = [
            'module' => lang("App.user_edit_title"),
            'page'   => lang("App.user_edit_subtitle"),
            'icon'  => 'fas fa-edit'
        ];

        $data['breadcrumb'] = [
            ['title' => lang("App.menu_dashboard"), 'route' => "/home", 'active' => false],
            ['title' => lang("App.user_title"), 'route' => "/user", 'active' => false],
            ['title' => lang("App.user_edit_title"), 'route'  => "", 'active' => true]
        ];

        $data['btn_return'] = [
            'title' => lang("App.global_come_back"),
            'route'   => '/user',
            'class'   => 'btn btn-dark mr-1',
            'icon'  => 'fas fa-angle-left'
        ];

        $data['btn_submit'] = [
            'title' => lang("App.global_save"),
            'route'   => '',
            'class'   => 'btn btn-primary mr-1',
            'icon'  => 'fas fa-save'
        ];

        $data['obj'] = $this->user_model->where('token', $token)->first();
        if($data['obj']==null){
            return redirect()->to('/user');
        }
        if(!empty($data['obj']['date_birth'])){
            $data['obj']['date_birth'] = dateFormatWeb($data['obj']['date_birth']);
        }
        $data['group'] = $this->group_model->select('token,title')->findAll();
        $data['country'] = $this->countries_model->select('code,name')->where('data_lang',session()->get('lang')??'en')->findAll();

        echo view(getenv('theme.backend.path').'main/header');
        echo view(getenv('theme.backend.path').'form/user/form',$data);
        echo view(getenv('theme.backend.path').'main/footer');
    }

    public function store()
    {
        //Demo Mode
        if(env('demo.mode')??false){
            session()->setFlashdata('sweet', ['warning',lang("App.general_demo_mode")]);
            return redirect()->to('/user');
        }

        $session = session();
        helper('form');

        $password = 'max_length[35]';
        $confirm_password = 'max_length[35]';
        $email = 'required|valid_email';

        if(empty($this->request->getPost('id_user'))){
            $email = 'required|valid_email|is_unique[user.email]';
            $password = 'required|min_length[8]';
            $confirm_password = 'matches[password]';
        }else{
            if(!empty($this->request->getPost('password'))){
                $password = 'required|min_length[8]';
                $confirm_password = 'matches[password]';
            }
        }

        $rules = [
            'first_name'        => 'required',
            'last_name'         => 'required',
            'email'             => $email,
            'password'          => $password,
            'confirm_password'  => $confirm_password
        ];

        $rules_error = [
            'first_name' => [
                'required' => lang("App.user_rules_first_name_r"),
            ],
            'last_name' => [
                'required' => lang("App.user_rules_last_name_r"),
            ],
            'email' => [
                'required' => lang("App.user_rules_email_r"),
                'is_unique' => lang("App.user_rules_email_i"),
            ],
            'password' => [
                'required' => lang("App.user_rules_password_r"),
                'min_length' => lang("App.user_rules_password_m"),
            ],
            'confirm_password' => [
                'matches' => lang("App.user_rules_password_confirm_m"),
            ]
        ];

        if ($this->validate($rules,$rules_error)){
            $date_birth = !empty($this->request->getPost('date_birth')??'') ? dateFormatMysql($this->request->getPost('date_birth')):null;
            if(empty($this->request->getPost('id_user'))){
                $phpass = new PasswordHash(8, true);
                $this->user_model->save([
                    'id_user' => null,
                    'group' => $this->request->getPost('group'),
                    'first_name' => $this->request->getPost('first_name'),
                    'last_name' => $this->request->getPost('last_name'),
                    'date_birth' => $date_birth,
                    'address' => $this->request->getPost('address'),
                    'city' => $this->request->getPost('city'),
                    'state' => $this->request->getPost('state'),
                    'country' => $this->request->getPost('country'),
                    'zip_code' => $this->request->getPost('zip_code'),
                    'mobile' => trim($this->request->getPost('ddi') ." ".$this->request->getPost('mobile')),
                    'email' => $this->request->getPost('email'),
                    'password' => $phpass->HashPassword($this->request->getPost('password')),
                    'last_access' => date('Y-m-d h:i:s'),
                    'last_ip' => '::1',
                    'picture' => '/assets/img/default-user.png',
                    'language' => $this->request->getPost('language'),
                    'token' => md5(uniqid(rand(), true)),
                    'status' => $this->request->getPost('status'),
                    'email_confirmed' => $this->request->getPost('email_confirmed'),
                    'sms_confirmed' => $this->request->getPost('sms_confirmed')
                ]);
            }else{
                $this->user_model->save([
                    'id_user' => $this->request->getPost('id_user'),
                    'group' => $this->request->getPost('group'),
                    'first_name' => $this->request->getPost('first_name'),
                    'last_name' => $this->request->getPost('last_name'),
                    'date_birth' => $date_birth,
                    'address' => $this->request->getPost('address'),
                    'city' => $this->request->getPost('city'),
                    'state' => $this->request->getPost('state'),
                    'country' => $this->request->getPost('country'),
                    'zip_code' => $this->request->getPost('zip_code'),
                    'mobile' => trim($this->request->getPost('ddi') ." ".$this->request->getPost('mobile')),
                    'email' => $this->request->getPost('email'),
                    'language' => $this->request->getPost('language'),
                    'status' => $this->request->getPost('status'),
                    'email_confirmed' => $this->request->getPost('email_confirmed'),
                    'sms_confirmed' => $this->request->getPost('sms_confirmed')
                ]);
                if(!empty($this->request->getPost('password'))){
                    $phpass = new PasswordHash(8, true);
                    $this->user_model->save([
                        'id_user' => $this->request->getPost('id_user'),
                        'password' => $phpass->HashPassword($this->request->getPost('password')),
                    ]);
                }
            }

            if(empty($this->request->getPost('id_user'))){
                $session->setFlashdata('sweet', ['success',lang("App.user_alert_add")]);
                return redirect()->to('/user');
            }else{
                if($session->get('id_user') == $this->request->getPost('id_user')){
                    $access_rules = $this->group_model->select('rules')->where('token',$this->request->getPost('group'))->first();
                    $session->set('rules', html_entity_decode($access_rules['rules']));
                }
                $session->setFlashdata('sweet', ['success',lang("App.user_alert_edit")]);
                return redirect()->to('/user');
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
            return redirect()->to('/user');
        }
        $session = session();
        if(!empty($session->get('token'))){
            $this->user_model->where('token', $token)->delete();
            $this->oauth_model->where('user', $token)->delete();
            $this->activity_model->where('user', $token)->delete();
            $session->setFlashdata('sweet', ['success',lang("App.user_alert_delete")]);
            return redirect()->to('/user');
        }else{
            return redirect()->to('/login');
        }
    }
}
