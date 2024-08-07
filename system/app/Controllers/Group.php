<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UserGroupModel;

class Group extends BaseController
{
    private $user_model;
    private $group_model;

    function __construct()
    {
        $this->user_model = new UserModel();
        $this->group_model = new UserGroupModel();
    }

    public function index()
    {
        $data['title'] = [
            'module' => lang("App.group_title"),
            'page'   => lang("App.group_subtitle"),
            'icon'  => 'fas fa-user-lock'
        ];

        $data['breadcrumb'] = [
            ['title' => lang("App.menu_dashboard"), 'route' => "/home", 'active' => false],
            ['title' => lang("App.group_title"), 'route'  => "", 'active' => true]
        ];

        $data['btn_add'] = [
            'title' => lang("App.group_btn_add"),
            'route'   => '/group/add',
            'class'   => 'btn btn-lg btn-primary float-md-right',
            'icon'  => 'fas fa-plus'
        ];

        echo view(getenv('theme.backend.path').'main/header');
        echo view(getenv('theme.backend.path').'form/group/index',$data);
        echo view(getenv('theme.backend.path').'main/footer');
    }

    public function add()
    {
        helper('form');

        $data['title'] = [
            'module' => lang("App.group_add_title"),
            'page'   => lang("App.group_add_subtitle"),
            'icon'  => 'far fa-plus-square'
        ];

        $data['breadcrumb'] = [
            ['title' => lang("App.menu_dashboard"), 'route' => "/home", 'active' => false],
            ['title' => lang("App.group_title"), 'route'  => "/group", 'active' => false],
            ['title' => lang("App.group_add_title"), 'route'  => "", 'active' => true]
        ];

        $data['btn_return'] = [
            'title' => lang("App.global_come_back"),
            'route'   => '/group',
            'class'   => 'btn btn-dark mr-1',
            'icon'  => 'fas fa-angle-left'
        ];

        $data['btn_submit'] = [
            'title' => lang("App.global_save"),
            'route'   => '',
            'class'   => 'btn btn-primary mr-1',
            'icon'  => 'fas fa-save'
        ];

        echo view(getenv('theme.backend.path').'main/header');
        echo view(getenv('theme.backend.path').'form/group/form',$data);
        echo view(getenv('theme.backend.path').'main/footer');
    }

    public function edit($id)
    {
        helper('form');

        $data['title'] = [
            'module' => lang("App.group_edit_title"),
            'page'   => lang("App.group_edit_subtitle"),
            'icon'  => 'fas fa-edit'
        ];

        $data['breadcrumb'] = [
            ['title' => lang("App.menu_dashboard"), 'route' => "/home", 'active' => false],
            ['title' => lang("App.group_title"), 'route'  => "/group", 'active' => false],
            ['title' => lang("App.group_edit_title"), 'route'  => "", 'active' => true]
        ];

        $data['btn_return'] = [
            'title' => lang("App.global_come_back"),
            'route'   => '/group',
            'class'   => 'btn btn-dark mr-1',
            'icon'  => 'fas fa-angle-left'
        ];

        $data['btn_submit'] = [
            'title' => lang("App.global_save"),
            'route'   => '',
            'class'   => 'btn btn-primary mr-1',
            'icon'  => 'fas fa-save'
        ];

        $data['obj'] = $this->group_model->where('token', $id)->first();
        if($data['obj']==null){
            return redirect()->to('/group');
        }

        echo view(getenv('theme.backend.path').'main/header');
        echo view(getenv('theme.backend.path').'form/group/form',$data);
        echo view(getenv('theme.backend.path').'main/footer');
    }

    public function store()
    {
        //Demo Mode
        if(env('demo.mode')??false){
            session()->setFlashdata('sweet', ['warning',lang("App.general_demo_mode")]);
            return redirect()->to('/group');
        }

        $session = session();
        helper('form');

        $rules = [
            'title'       => 'required',
            'dashboard'  => 'required'
        ];
        $rules_error = [
            'title' => [
                'required' => lang("App.group_rules_title_r")
            ],
            'dashboard' => [
                'required' => lang("App.group_rules_dashboard_r")
            ],
        ];

        if ($this->validate($rules,$rules_error)){
            if($listPost = $this->request->getPost()){

                $getChecked = $this->request->getPost();

                unset($getChecked['id_group']);
                unset($getChecked['title']);
                unset($getChecked['dashboard']);

                $controller = null;
                $rules_access = null;

                foreach ($getChecked as $key=>$value){
                    $exp = explode('_',$key);
                    $controller[] = $exp[0];
                }
                if($controller != null){
                    foreach (array_unique($controller) as $item){
                        $rules_access[$item] = [];
                        foreach ($getChecked as $key=>$value){
                            $exp = explode('_',$key);
                            if($exp[0] == $item){
                                array_push($rules_access[$item],str_replace($exp[0].'_','',$key)) ;
                            }
                        }
                    }
                }

                $listPost['rules'] = json_encode($rules_access??'{}');
                if(empty($listPost['id_group'])){
                    $listPost['token'] = md5(uniqid(rand(), true));
                }

                $this->group_model->save($listPost);

                if(empty($listPost['id_group'])){
                    $session->setFlashdata('sweet', ['success',lang("App.group_alert_add")]);
                    return redirect()->to('/group');
                }else{
                    if($session->get('group') == $this->request->getPost('token')){
                        $session->set('rules', $listPost['rules']);
                    }
                    $session->setFlashdata('sweet', ['success',lang("App.group_alert_edit")]);
                    return redirect()->to('/group');
                }
            }
        }else{
            $session->setFlashdata('error','error');
            $this->add();
        }
    }

    public function delete($id)
    {
        //Demo Mode
        if(env('demo.mode')??false){
            session()->setFlashdata('sweet', ['warning',lang("App.general_demo_mode")]);
            return redirect()->to('/group');
        }

        $session = session();
        if($this->user_model->where('group', $id)->countAllResults() == 0){
            $this->group_model->where('token', $id)->delete();
            $session->setFlashdata('sweet', ['success',lang("App.group_alert_delete")]);
        }else{
            $session->setFlashdata('sweet', ['error',lang("App.group_alert_error")]);
        }
        return redirect()->to('/group');
    }
}
