<?php

namespace App\Controllers;

use App\Libraries\PasswordHash;
use App\Models\CountriesModel;
use App\Models\UserGroupModel;
use App\Models\UserModel;
use App\Models\UserOauthModel;
use App\Models\ActivityModel;

class Profile extends BaseController
{
    private $user_model;
    private $oauth_model;
    private $countries_model;
    private $activity_model;
    private $id_user;
    private $token_user;

    function __construct()
    {
        $this->user_model = new UserModel();
        $this->oauth_model = new UserOauthModel();
        $this->countries_model = new CountriesModel();
        $this->activity_model = new ActivityModel();
        $this->id_user = session()->get('id_user');
        $this->token_user = session()->get('token');
    }

    public function index()
    {
        helper('file');
        helper('form');
        helper('text');

        $data['title'] = [
            'module' => lang("App.profile_title"),
            'page'   => lang("App.profile_subtitle"),
            'icon'  => 'fas fa-user'
        ];

        $data['breadcrumb'] = [
            ['title' => lang("App.menu_dashboard"), 'route' => "/home", 'active' => false],
            ['title' => lang("App.profile_title"), 'route'  => "", 'active' => true]
        ];

        $data['btn_return'] = [
            'title' => lang("App.global_come_back"),
            'route'   => '/',
            'class'   => 'btn btn-dark mr-1',
            'icon'  => 'fas fa-angle-left'
        ];

        $data['btn_submit'] = [
            'title' => lang("App.global_save"),
            'route'   => '',
            'class'   => 'btn btn-primary mr-1',
            'icon'  => 'fas fa-save'
        ];

        $session = session();

        $data['obj'] = $this->user_model->where('id_user',$this->id_user)->first();
        if(!empty($data['obj']['date_birth'])){
            $data['obj']['date_birth'] = dateFormatWeb($data['obj']['date_birth']);
        }
        $data['oauth'] = $this->oauth_model->where('user',$this->token_user)->orderBy('created_at','desc')->findAll();
        $data['country'] = $this->countries_model->select('code,name')->where('data_lang',session()->get('lang')??'en')->findAll();

        $file = $this->request->getFile('file');
        if(!empty($file)){
            $integration = new Integration();
            $allow = ['jpeg','jpg','gif','bmp','png'];
            $path = 'assets/img/';
            $pathRet = '/'.$integration->saveStorage($file,$path,$allow);
            if(!empty($pathRet)){
                $this->user_model->save([
                    'id_user' => $this->id_user,
                    'picture' => $pathRet
                ]);
                $data['obj']['picture'] = $pathRet;
                $session->set('picture',$pathRet);
            }
        }else{
            if(!empty($this->request->getPost())){
                $post = $this->request->getPost();
                $image = '';
                foreach ($post as $key=>$value){
                    if(strpos($key, 'image') !== false){
                        $image = $value;
                    }
                }
                if(!empty($image)){
                    $this->user_model->save([
                        'id_user' => $this->id_user,
                        'picture' => $image
                    ]);
                    $data['obj']['picture'] = $image;
                    $session->set('picture',$image);
                }
            }
        }

        echo view(getenv('theme.backend.path').'main/header');
        echo view(getenv('theme.backend.path').'form/profile/index', $data);
        echo view(getenv('theme.backend.path').'main/footer');
    }

    public function store()
    {

        //Demo Mode
        if(env('demo.mode')??false){
            session()->setFlashdata('sweet', ['warning',lang("App.general_demo_mode")]);
            return redirect()->to('/profile');
        }

        $session = session();
        helper('form');

        $password = 'max_length[35]';
        $confirm_password = 'max_length[35]';

        if(!empty($this->request->getPost('password'))){
            $password = 'required|min_length[8]';
            $confirm_password = 'matches[password]';
        }

        $rules = [
            'first_name'       => 'required',
            'last_name'        => 'required',
            'password'         => $password,
            'confirm_password' => $confirm_password
        ];

        $rules_error = [
            'first_name' => ['required' => lang("App.profile_rules_first_name_r")],
            'last_name' => ['required' => lang("App.profile_rules_last_name_r")],
            'password' => [
                'required' => lang("App.profile_rules_password_r"),
                'min_length' => lang("App.profile_rules_password_m")
            ],
            'confirm_password' => ['matches' => lang("App.profile_rules_password_confirm_m")]
        ];

        if(empty($this->request->getPost('tfa_secret'))){
            if ($this->validate($rules??[],$rules_error??[])){
                if(!empty($this->id_user)){
                    $date_birth = !empty($this->request->getPost('date_birth')??'') ? dateFormatMysql($this->request->getPost('date_birth')):null;
                    $this->user_model->save([
                        'id_user' => $this->id_user,
                        'first_name' => $this->request->getPost('first_name'),
                        'last_name' => $this->request->getPost('last_name'),
                        'date_birth' => $date_birth,
                        'address' => $this->request->getPost('address'),
                        'city' => $this->request->getPost('city'),
                        'state' => $this->request->getPost('state'),
                        'country' => $this->request->getPost('country'),
                        'zip_code' => $this->request->getPost('zip_code'),
                        'mobile' => trim($this->request->getPost('ddi') ." ".$this->request->getPost('mobile')),
                        'language' => $this->request->getPost('language')
                    ]);
                    $session->set('lang', $this->request->getPost('language') ?? 'en');
                    if(!empty($this->request->getPost('password'))){
                        $phpass = new PasswordHash(8, true);
                        $this->user_model->save([
                            'id_user' => $this->id_user,
                            'password' => $phpass->HashPassword($this->request->getPost('password')),
                        ]);
                    }
                    $session->setFlashdata('sweet', ['success',lang("App.global_alert_save_success")]);
                }else{
                    $session->setFlashdata('sweet', ['error',lang("App.global_alert_save_error")]);
                }
            }else{

                $session->setFlashdata('error','error');
                return $this->index();
            }
        }else{
            if($this->request->getPost('tfa') == 'on'){
                $this->user_model->save([
                    'id_user' => $this->id_user,
                    'tfa' => true,
                    'tfa_secret' => $this->request->getPost('tfa_secret'),
                    'tfa_code' => $this->request->getPost('tfa_code')
                ]);
            }else{
                $this->user_model->save([
                    'id_user' => $this->id_user,
                    'tfa' => false,
                    'tfa_secret' => '',
                    'tfa_code' => ''
                ]);
            }
            $session->setFlashdata('sweet', ['success',lang("App.global_alert_save_success")]);
        }
        return redirect()->to('/profile');
    }

    public function delete()
    {
        $token = session()->get('token');
        //Demo Mode
        if(env('demo.mode')??false){
            session()->setFlashdata('sweet', ['warning',lang("App.general_demo_mode")]);
            return redirect()->to('/profile');
        }
        if(!empty(session()->get('token'))){
            $this->user_model->where('token', $token)->delete();
            $this->oauth_model->where('user', $token)->delete();
            $this->activity_model->where('user', $token)->delete();
            return redirect()->to('/login/logout');
        }else{
            return redirect()->to('/login');
        }
    }
}
