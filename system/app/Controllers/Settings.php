<?php

namespace App\Controllers;

use App\Models\CountriesModel;
use App\Models\CronTabModel;
use App\Models\CurrencyModel;
use App\Models\SettingsModel;
use App\Models\SettingsOauthModel;
use App\Models\TemplateModel;
use App\Models\ThemeModel;
use App\Models\TimezoneModel;
use App\Models\UserGroupModel;
use App\Models\UserModel;

class Settings extends BaseController
{
    private $settings_model;
    private $settings_oauth_model;
    private $countries_model;
    private $theme_model;
    private $currency_model;
    private $timezone_model;
    private $group_model;
    private $template_model;
    private $user_model;
    private $crontab_model;
    private $integration;

    function __construct()
    {
        $this->settings_model = new SettingsModel();
        $this->settings_oauth_model = new SettingsOauthModel();
        $this->countries_model = new CountriesModel();
        $this->theme_model = new ThemeModel();
        $this->currency_model = new CurrencyModel();
        $this->timezone_model = new TimezoneModel();
        $this->group_model = new UserGroupModel();
        $this->template_model = new TemplateModel();
        $this->user_model = new UserModel();
        $this->crontab_model = new CronTabModel();
        $this->integration = new Integration();
    }

    public function index()
    {
        helper('form');

        $data['title'] = [
            'module' => lang("App.settings_title"),
            'page'   => lang("App.settings_subtitle"),
            'icon'  => 'fas fa-sliders-h'
        ];

        $data['breadcrumb'] = [
            ['title' => lang("App.menu_dashboard"), 'route' => "/home", 'active' => false],
            ['title' => lang("App.menu_settings"), 'route'  => "", 'active' => true]
        ];

        $data['btn_return'] = [
            'title' => lang("App.global_come_back"),
            'route'   => '/home',
            'class'   => 'btn btn-dark mr-1',
            'icon'  => 'fas fa-angle-left'
        ];

        $data['btn_submit'] = [
            'title' => lang("App.global_save"),
            'route'   => '',
            'class'   => 'btn btn-primary mr-1',
            'icon'  => 'fas fa-save'
        ];

        $data['obj'] = $this->settings_model->first();
        $data['countries'] = $this->countries_model->select('id_country,code,name')->where('data_lang',session()->get('lang')??'en')->findAll();
        $data['theme'] = $this->theme_model->select('id_theme,type,name')->findAll();
        $data['currency'] = $this->currency_model->select('id_currency,code,name')->findAll();
        $data['timezone'] = $this->timezone_model->select('id_timezone,timezone,description')->findAll();
        $data['group'] = $this->group_model->select('token,title')->findAll();
        $db = db_connect('default');
        $data['tables'] = $db->listTables();
        $data['user'] = $this->user_model->select('token,first_name,email')->where('status',true)->findAll();

        echo view(getenv('theme.backend.path').'main/header');
        echo view(getenv('theme.backend.path').'form/settings/index', $data);
        echo view(getenv('theme.backend.path').'main/footer');
    }

    public function store()
    {
        //Demo Mode
        if(env('demo.mode')??false){
            session()->setFlashdata('sweet', ['warning',lang("App.general_demo_mode")]);
            return redirect()->to('/settings');
        }

        helper('form');
        $session = session();
        if($listPost = $this->request->getPost()){
            $listPost['id_settings'] = 1;
            $listPost['captcha_register'] = isset($listPost['captcha_register']) && $listPost['captcha_register'] == 'on';
            $listPost['captcha_login'] = isset($listPost['captcha_login']) && $listPost['captcha_login'] == 'on';
            $listPost['captcha_recovery'] = isset($listPost['captcha_recovery']) && $listPost['captcha_recovery'] == 'on';
            $listPost['registration'] = isset($listPost['registration']) && $listPost['registration'] == 'on';
            $listPost['terms_conditions'] = isset($listPost['terms_conditions']) && $listPost['terms_conditions'] == 'on';
            $listPost['email_confirmation'] = isset($listPost['email_confirmation']) && $listPost['email_confirmation'] == 'on';
            $listPost['sms_confirmation'] = isset($listPost['sms_confirmation']) && $listPost['sms_confirmation'] == 'on';
            $listPost['send_email_register'] = isset($listPost['send_email_register']) && $listPost['send_email_register'] == 'on';
            $listPost['send_sms_register'] = isset($listPost['send_sms_register']) && $listPost['send_sms_register'] == 'on';
            $listPost['send_notification_register'] = isset($listPost['send_notification_register']) && $listPost['send_notification_register'] == 'on';
            $listPost['send_email_welcome'] = isset($listPost['send_email_welcome']) && $listPost['send_email_welcome'] == 'on';
            $listPost['send_sms_welcome'] = isset($listPost['send_sms_welcome']) && $listPost['send_sms_welcome'] == 'on';
            $listPost['remember_me'] = isset($listPost['remember_me']) && $listPost['remember_me'] == 'on';
            $listPost['forgot_password'] = isset($listPost['forgot_password']) && $listPost['forgot_password'] == 'on';
            $listPost['two_factor_auth'] = isset($listPost['two_factor_auth']) && $listPost['two_factor_auth'] == 'on';
            $listPost['throttle_auth'] = isset($listPost['throttle_auth']) && $listPost['throttle_auth'] == 'on';
            $listPost['enable_api'] = isset($listPost['enable_api']) && $listPost['enable_api'] == 'on';
            $listPost['block_external_api'] = isset($listPost['block_external_api']) && $listPost['block_external_api'] == 'on';
            $listPost['remove_log'] = isset($listPost['remove_log']) && $listPost['remove_log'] == 'on';
            $listPost['backup_notification_email'] = isset($listPost['backup_notification_email']) && $listPost['backup_notification_email'] == 'on';
            $listPost['backup_automatic'] = isset($listPost['backup_automatic']) && $listPost['backup_automatic'] == 'on';
            $listPost['backup_table'] = implode(",",$listPost['backup_table']??[]);
            $listPost['pusher_enable'] = isset($listPost['pusher_enable']) && $listPost['pusher_enable'] == 'on';
            $listPost['pusher_useTLS'] = isset($listPost['pusher_useTLS']) && $listPost['pusher_useTLS'] == 'on';
            $listPost['pusher_scheme'] = isset($listPost['pusher_scheme']) && $listPost['pusher_scheme'] == 'on';
            $listPost['module_enable'] = isset($listPost['module_enable']) && $listPost['module_enable'] == 'on';
            $listPost['layout_enable'] = isset($listPost['layout_enable']) && $listPost['layout_enable'] == 'on';
            $listPost['activate_frontend'] = isset($listPost['activate_frontend']) && $listPost['activate_frontend'] == 'on';
            if($listPost['module_enable']){
                if(file_exists(APPPATH . "Modules/ModulesOff.json")){
                    rename(APPPATH . "Modules/ModulesOff.json",APPPATH . "Modules/Modules.json");
                }
            }else{
                if(file_exists(APPPATH . "Modules/Modules.json")){
                    rename(APPPATH . "Modules/Modules.json",APPPATH . "Modules/ModulesOff.json");
                }
            }
            $this->settings_model->save($listPost);
            $settings = $this->settings_model->first()??[];
            $session->set('settings', $settings);
            $session->set('lang', $settings['default_language'] ?? 'en');
            $session->setFlashdata('sweet', ['success',lang("App.settings_alert_add")]);
            return redirect()->to('/settings');
        } else{
            $session->setFlashdata('sweet', ['error',lang("App.settings_alert_error")]);
            return redirect()->to('/settings');
        }
    }

    public function oauth()
    {
        helper('form');

        $data['title'] = [
            'module' => lang("App.oauth_title"),
            'page'   => lang("App.oauth_subtitle"),
            'icon'  => 'fas fa-user-shield'
        ];

        $data['breadcrumb'] = [
            ['title' => lang("App.menu_dashboard"), 'route' => "/home", 'active' => false],
            ['title' => lang("App.menu_settings"), 'route'  => "/settings", 'active' => false],
            ['title' => lang("App.oauth_title"), 'route'  => "", 'active' => true]
        ];

        $data['btn_return'] = [
            'title' => lang("App.global_come_back"),
            'route'   => '/home',
            'class'   => 'btn btn-dark mr-1',
            'icon'  => 'fas fa-angle-left'
        ];

        $data['btn_submit'] = [
            'title' => lang("App.global_save"),
            'route'   => '',
            'class'   => 'btn btn-primary mr-1',
            'icon'  => 'fas fa-save'
        ];

        $data['oauth'] = $this->settings_oauth_model->findAll();

        echo view(getenv('theme.backend.path').'main/header');
        echo view(getenv('theme.backend.path').'form/settings/oauth', $data);
        echo view(getenv('theme.backend.path').'main/footer');
    }

    public function oauth_store()
    {
        //Demo Mode
        if(env('demo.mode')??false){
            session()->setFlashdata('sweet', ['warning',lang("App.general_demo_mode")]);
            return redirect()->to('/settings/oauth');
        }

        $session = session();
        helper('form');

        if($field = $this->request->getPost()){
            $providers = [];
            $oauth = [];
            foreach ($field as $key=>$value){
                $provider = explode('_',$key);
                array_push($providers,$provider[0]);
            }
            foreach (array_unique($providers) as $item){
                $oauth[$item] = [];
                foreach ($field as $key=>$value){
                    $provider = explode('_',$key);
                    if($provider[0] == $item){
                        if(empty($oauth[$item])){
                            $oauth[$item] = array_merge( $oauth[$item],['id_oauth' => intval($provider[2])]);
                            $oauth[$item] = array_merge( $oauth[$item],['show_text' => false]);
                            $oauth[$item] = array_merge( $oauth[$item],['status' => false]);
                        }
                        switch($provider[1])
                        {
                            case 'show';
                                $oauth[$item] = array_merge( $oauth[$item],['show_text' => $value == 'on']);
                                break;
                            case 'status';
                                $oauth[$item] = array_merge( $oauth[$item],['status' => $value == 'on']);
                                break;
                            default;
                                $oauth[$item] = array_merge( $oauth[$item],[$provider[1] => $value]);
                                break;
                        }
                    }
                }
            }
            $this->settings_oauth_model->updateBatch($oauth,'id_oauth');
            $session->setFlashdata('sweet', ['success',lang("App.oauth_alert_add")]);
            return redirect()->to('/settings/oauth');
        } else{
            $session->setFlashdata('sweet', ['error',lang("App.oauth_alert_error")]);
            return redirect()->to('/settings/oauth');
        }
    }

    public function template()
    {
        helper('form');

        $data['title'] = [
            'module' => lang("App.template_title"),
            'page'   => lang("App.template_subtitle"),
            'icon'  => 'fas fa-mail-bulk'
        ];

        $data['breadcrumb'] = [
            ['title' => lang("App.menu_dashboard"), 'route' => "/home", 'active' => false],
            ['title' => lang("App.menu_settings"), 'route'  => "/settings", 'active' => false],
            ['title' => lang("App.template_title"), 'route'  => "", 'active' => true]
        ];

        $data['btn_return'] = [
            'title' => lang("App.global_come_back"),
            'route'   => '/home',
            'class'   => 'btn btn-dark mr-1',
            'icon'  => 'fas fa-angle-left'
        ];

        $data['btn_submit'] = [
            'title' => lang("App.global_save"),
            'route'   => '',
            'class'   => 'btn btn-primary mr-1',
            'icon'  => 'fas fa-save'
        ];

        $data['template'] = $this->template_model->findAll();

        echo view(getenv('theme.backend.path').'main/header');
        echo view(getenv('theme.backend.path').'form/settings/template', $data);
        echo view(getenv('theme.backend.path').'main/footer');
    }

    public function template_store()
    {
        //Demo Mode
        if(env('demo.mode')??false){
            session()->setFlashdata('sweet', ['warning',lang("App.general_demo_mode")]);
            return redirect()->to('/settings/template');
        }

        $session = session();
        helper('form');

        if($field = $this->request->getPost()){
            $ids = [];
            $template = [];
            unset($field['files']);
            foreach ($field as $key=>$value){
                $id = explode('_',$key);
                array_push($ids,$id[2]);
            }
            foreach (array_unique($ids) as $item){
                $template[$item] = [];
                foreach ($field as $key=>$value){
                    $id = explode('_',$key);
                    if($id[2] == $item){
                        if(empty($template[$item])){
                            $template[$item] = array_merge( $template[$item],['id_template' => intval($id[2])]);
                            $template[$item] = array_merge( $template[$item],['subject' => ""]);
                            $template[$item] = array_merge( $template[$item],['body' => ""]);
                        }
                        switch($id[1])
                        {
                            case 'email';
                                switch($id[0])
                                {
                                    case 'title';
                                        $template[$item] = array_merge( $template[$item],['subject' => $value]);
                                        break;
                                    default;
                                        $template[$item] = array_merge( $template[$item],[$id[0] => $value]);
                                        break;
                                }
                                break;
                            case 'sms';
                                if($id[0] == 'body'){
                                    $template[$item] = array_merge( $template[$item],[$id[0] => $value]);
                                }
                                break;
                        }
                    }
                }
            }
            $this->template_model->updateBatch($template,'id_template');
            $session->setFlashdata('sweet', ['success',lang("App.template_alert_add")]);
            return redirect()->to('/settings/template');
        } else{
            $session->setFlashdata('sweet', ['error',lang("App.template_alert_error")]);
            return redirect()->to('/settings/template');
        }
    }

    public function module($id=null,$func='')
    {
        //Demo Mode
        if(env('demo.mode')??false){
            session()->setFlashdata('sweet', ['warning',lang("App.general_demo_mode")]);
            return redirect()->to('/settings');
        }
        
        $obj = $this->settings_model->select('module_enable')->first();
        if(!$obj['module_enable']){
            return redirect()->to('/settings');
        }

        helper('file');
        helper('form');
        helper('text');

        $data['title'] = [
            'module' => lang("App.module_title"),
            'page'   => lang("App.module_subtitle"),
            'icon'  => 'fas fa-upload'
        ];

        $data['breadcrumb'] = [
            ['title' => lang("App.menu_dashboard"), 'route' => "/home", 'active' => false],
            ['title' => lang("App.menu_settings"), 'route'  => "/settings", 'active' => false],
            ['title' => lang("App.module_title"), 'route'  => "", 'active' => true]
        ];

        $data['btn_return'] = [
            'title' => lang("App.global_come_back"),
            'route'   => '/home',
            'class'   => 'btn btn-dark mr-1',
            'icon'  => 'fas fa-angle-left'
        ];

        $data['btn_submit'] = [
            'title' => lang("App.global_save"),
            'route'   => '',
            'class'   => 'btn btn-primary mr-1',
            'icon'  => 'fas fa-save'
        ];

        //Install Addon
        $file = $this->request->getFile('file');
        if(!empty($file)){
            $integration = new Integration();
            $allow = ['zip'];
            $token = md5(uniqid(rand(), true));
            $path = APPPATH . "Modules/".$token."/";
            $pathRet = $integration->saveStorage($file,$path,$allow);
            if(!empty($pathRet)){
                if(file_exists($pathRet)){
                    $zip = new \ZipArchive;
                    if ($zip->open($pathRet) === TRUE) {
                        //$appInfo = $path.$zip->statIndex(0)["name"];
                        //$exist = file_exists($path);
                        //$dir = str_replace("/","",$zip->statIndex(0)["name"]);
                        $zip->extractTo($path);
                        $zip->close();
                        unlink($pathRet);

                        try {
                            if(file_exists($path."app.json")){
                                $app = file_get_contents($path."app.json");
                                $app = @json_decode($app,true);
                                $mods = file_get_contents(APPPATH . "Modules/Modules.json");
                                $mods = @json_decode($mods,true);
                                $directory = $app["directory"];
                                $dir = APPPATH . "Modules/".$directory;
                                $exist = file_exists($dir);
                                if($exist){
                                    delTree($dir);
                                }
                                rename(APPPATH . "Modules/".$token, $dir);
                            }else{
                                session()->setFlashdata('toast', ['error',lang("App.module_alert_error"),lang("App.module_alert_incompatible_install")]);
                                return redirect()->to('/settings/module');
                            }
                        }catch (\Exception $ex){
                            session()->setFlashdata('toast', ['error',lang("App.module_alert_error"),lang("App.module_alert_incompatible_install")]);
                            return redirect()->to('/settings/module');
                        }

                        if(!$exist){
                            $array = array(
                                "name" => $app["name"],
                                "version" => $app["version"],
                                "rules" => [],
                                "directory" => $directory,
                                "created_at" => now_db(),
                                "updated_at" => now_db(),
                                "status" => true
                            );
                            array_push($mods,$array);

                            try {
                                //Install SQL
                                $sql = file_get_contents($dir."/install_db.sql");
                                $sql = str_replace('[DB_PREFIX]',getenv('database.default.DBPrefix'),$sql);
                                $list = explode(';',$sql);
                                $db = db_connect();
                                foreach ($list as $query){
                                    if(!empty(trim($query))){
                                        $db->query($query);
                                    }
                                }
                            }
                            catch(\Exception $ex) {
                                session()->setFlashdata('toast', ['error',lang("App.module_alert_error"),lang("App.module_alert_sql_install")]);
                                return redirect()->to('/settings/module');
                            }
                        }else{
                            $created_at = now_db();
                            $status = false;
                            $rules = [];
                            foreach ($mods as $key => $item){
                                $created_at = $item["created_at"];
                                $status = $item["status"];
                                $rules = $item["rules"];
                                if($item["directory"] == $directory){
                                    array_splice($mods, $key);
                                    break;
                                }
                            }
                            $array = array(
                                "name" => $app["name"],
                                "version" => $app["version"],
                                "rules" => $rules,
                                "directory" => $directory,
                                "created_at" => $created_at,
                                "updated_at" => now_db(),
                                "status" => $status
                            );
                            array_push($mods,$array);

                            try {
                                //Update SQL
                                $sql = file_get_contents($dir."/update_db.sql");
                                $sql = str_replace('[DB_PREFIX]',getenv('database.default.DBPrefix'),$sql);
                                $list = explode(';',$sql);
                                $db = db_connect();
                                foreach ($list as $query){
                                    if(!empty(trim($query))){
                                        $db->query($query);
                                    }
                                }
                            }
                            catch(\Exception $ex) {
                                session()->setFlashdata('toast', ['error',lang("App.module_alert_error"),lang("App.module_alert_sql_update")]);
                                return redirect()->to('/settings/module');
                            }
                        }

                        $file = fopen(APPPATH . "Modules/Modules.json",'w');
                        fwrite($file, json_encode($mods));
                        fclose($file);

                        session()->setFlashdata('toast', ['success',lang("App.module_alert_success"),lang("App.module_alert_update")]);
                        return redirect()->to('/settings/module');
                    } else {
                        session()->setFlashdata('toast', ['error',lang("App.module_alert_error"),lang("App.module_alert_unzip")]);
                        return redirect()->to('/settings/module');
                    }
                }else{
                    session()->setFlashdata('toast', ['error',lang("App.module_alert_error"),lang("App.module_alert_404")]);
                    return redirect()->to('/settings/module');
                }
            }else{
                session()->setFlashdata('toast', ['error',lang("App.module_alert_error"),lang("App.module_alert_file")]);
                return redirect()->to('/settings/module');
            }
            session()->setFlashdata('toast', ['success',lang("App.module_alert_success"),lang("App.module_alert_install")]);
            return redirect()->to('/settings/module');
        }

        //Uninstall Addon
        if(!empty($id) && $func=='uninstall'){
            $directory = base64_decode($id);
            $mods = file_get_contents(APPPATH . "Modules/Modules.json");
            $mods = @json_decode($mods,true);

            $position = 0;
            foreach ($mods as $key => $item){
                if($item["directory"] == $directory){
                    $position = $key;
                    break;
                }
            }

            array_splice($mods, $position, 1);

            try {
                //Uninstall SQL
                $sql = file_get_contents(APPPATH . "Modules/".$directory."/uninstall_db.sql");
                $sql = str_replace('[DB_PREFIX]',getenv('database.default.DBPrefix'),$sql);
                $list = explode(';',$sql);
                $db = db_connect();
                foreach ($list as $query){
                    if(!empty(trim($query))){
                        $db->query($query);
                    }
                }
            }
            catch(\Exception $ex) {
                session()->setFlashdata('toast', ['error',lang("App.module_alert_error"),lang("App.module_alert_sql_uninstall")]);
                return redirect()->to('/settings/module');
            }

            //Delete Addon
            delTree(APPPATH . "Modules/".$directory);
            $file = fopen(APPPATH . "Modules/Modules.json",'w');
            fwrite($file, json_encode($mods));
            fclose($file);

            session()->setFlashdata('toast', ['success',lang("App.module_alert_success"),lang("App.module_alert_uninstall")]);
            return redirect()->to('/settings/module');
        }

        //Update Status Addon
        if(!empty($id) && $func=='update'){
            $directory = base64_decode($id);
            $mods = file_get_contents(APPPATH . "Modules/Modules.json");
            $mods = @json_decode($mods,true);

            $position = 0;
            foreach ($mods as $key => $item){
                if($item["directory"] == $directory){
                    $position = $key;
                    break;
                }
            }

            $obj = $mods[$position];

            $obj["updated_at"] = now_db();
            $obj["status"] = !$obj["status"];

            $mods[$position] = $obj;

            $file = fopen(APPPATH . "Modules/Modules.json",'w');
            fwrite($file, json_encode($mods));
            fclose($file);

            session()->setFlashdata('toast', ['success',lang("App.module_alert_success"),lang("App.module_alert_update")]);
            return redirect()->to('/settings/module');
        }

        $data['groups'] = $this->group_model->findAll();
        $data['template'] = $this->template_model->findAll();

        echo view(getenv('theme.backend.path').'main/header');
        echo view(getenv('theme.backend.path').'form/settings/module', $data);
        echo view(getenv('theme.backend.path').'main/footer');
    }

    public function module_permission($id=null, $json=null)
    {
        //Demo Mode
        if(env('demo.mode')??false){
            session()->setFlashdata('sweet', ['warning',lang("App.general_demo_mode")]);
            return redirect()->to('/settings');
        }

        if(!empty($id) && empty($json)){
            $directory = base64_decode($id);
            $mods = file_get_contents(APPPATH . "Modules/Modules.json");
            $mods = @json_decode($mods,true);
            $rules = [];
            foreach ($mods as $item){
                if($item["directory"] == $directory){
                    $rules = $item["rules"];
                    break;
                }
            }
            return $this->response->setJSON($rules);
        }else{
            try {
                $data = json_decode(base64_decode($json),true);
                $directory = $data['id'];

                $mods = file_get_contents(APPPATH . "Modules/Modules.json");
                $mods = @json_decode($mods,true);

                $position = 0;
                foreach ($mods as $key => $item){
                    if($item["directory"] == $directory){
                        $position = $key;
                        break;
                    }
                }

                $obj = $mods[$position];

                $obj["updated_at"] = now_db();
                $obj["rules"] = $data['select'];

                $mods[$position] = $obj;

                $file = fopen(APPPATH . "Modules/Modules.json",'w');
                fwrite($file, json_encode($mods));
                fclose($file);

                $data = [
                    'success' => true
                ];
                return $this->response->setJSON($data);
            }
            catch(\Exception $ex) {
                $data = [
                    'error' => $ex
                ];
                return $this->response->setJSON($data);
            }
        }

    }
}
