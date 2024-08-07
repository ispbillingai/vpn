<?php
namespace App\Controllers;

use App\Libraries\Authenticator;
use App\Libraries\PasswordHash;
use App\Models\ActivityModel;
use App\Models\ConfirmationTokenModel;
use App\Models\NotificationModel;
use App\Models\PasswordRecoveryModel;
use App\Models\SettingsModel;
use App\Models\TemplateModel;
use App\Models\UserModel;
use App\Models\UserGroupModel;
use App\Models\SettingsOauthModel;

class login extends BaseController
{
    private $user_model;
    private $group_model;
    private $oauth_model;
    private $settings_model;
    private $pass_recovery_model;
    private $activity_model;
    private $notification_model;
    private $template_model;
    private $confirmation_model;
    private $integration;

    function __construct()
    {
        $this->user_model = new UserModel();
        $this->group_model = new UserGroupModel();
        $this->oauth_model = new SettingsOauthModel();
        $this->settings_model = new SettingsModel();
        $this->pass_recovery_model = new PasswordRecoveryModel();
        $this->activity_model = new ActivityModel();
        $this->notification_model = new NotificationModel();
        $this->template_model = new TemplateModel();
        $this->confirmation_model = new ConfirmationTokenModel();
        $this->integration = new Integration();
        // Get Settings
        $loginAuthFilter = new \App\Filters\LoginAuthFilter();
        $loginAuthFilter->getSettings();
    }

    public function index()
    {
        $session = session();
        $data['settings'] = $session->get('settings');
        $data['oauth'] = $this->oauth_model->where('status',true)->findAll();
        $header['title'] = lang("App.login_title");

        echo view(getenv('theme.backend.path').'login/header',$header);
        echo view(getenv('theme.backend.path').'form/login/index',$data);
        echo view(getenv('theme.backend.path').'login/footer');
    }

    public function forgot_password()
    {
        $session = session();
        if($session->get('settings')['forgot_password']??false){
            $data['settings'] = $session->get('settings');
            $header['title'] = lang("App.login_title_forgot_password");

            echo view(getenv('theme.backend.path').'login/header',$header);
            echo view(getenv('theme.backend.path').'form/login/forgot_password',$data);
            echo view(getenv('theme.backend.path').'login/footer');
        }else{
            return redirect()->to('/login');
        }
    }

    public function authenticate()
    {
        $session = session();
        $settings = $session->get('settings');

        if(!empty($session->get('oauth'))){
            // Data obtained by oAuth
            $login = $this->user_model->where('email', $session->get('oauth')->email)->first();
        } else {
            // Data obtained by Form
            $getVar = $this->request->getvar();
            $login = $this->user_model->where('email', $getVar['email']??'')->first();
            // Captcha Validation
            if($settings['captcha_login']??false){
                if($settings['captcha_gateway'] == 'recaptcha'){
                    if(isset($getVar['g-recaptcha-response'])){
                        $captcha = $getVar['g-recaptcha-response'];
                        $url = 'https://www.google.com/recaptcha/api/siteverify?secret='.urlencode($settings['captcha_secret_key']??'').'&response='.urlencode($captcha);
                        $response = file_get_contents($url);
                        $responseKeys = json_decode($response,true);
                        if(!$responseKeys["success"]) {
                            $session->setFlashdata('toast', ['error',lang("App.login_alert"),lang("App.login_alert_captcha_invalid")]);
                            return redirect()->to('login');
                        }
                    }else{
                        $session->setFlashdata('toast', ['error',lang("App.login_alert"),lang("App.login_alert_captcha_not_found")]);
                        return redirect()->to('login');
                    }
                }
                if($settings['captcha_gateway'] == 'hcaptcha'){
                    if(isset($getVar['h-captcha-response'])){
                        $captcha = $getVar['h-captcha-response'];
                        $url = 'https://hcaptcha.com/siteverify?secret='.urlencode($settings['captcha_secret_key']??'').'&response='.urlencode($captcha).'&remoteip='.$_SERVER['REMOTE_ADDR'];
                        $response = file_get_contents($url);
                        $responseKeys = json_decode($response,true);
                        if(!$responseKeys["success"]) {
                            $session->setFlashdata('toast', ['error',lang("App.login_alert"),lang("App.login_alert_captcha_invalid")]);
                            return redirect()->to('login');
                        }
                    }else{
                        $session->setFlashdata('toast', ['error',lang("App.login_alert"),lang("App.login_alert_captcha_not_found")]);
                        return redirect()->to('login');
                    }
                }
            }
            // Remember Me Validation
            if($settings['remember_me']??false){
                if($getVar['remember']??'' == 'on') {
                    $params = session_get_cookie_params();
                    setcookie(session_name(), $_COOKIE[session_name()], time() + 60*60*24*30, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
                }
            }
        }

        if(!empty($login))
        {
            // Blocked Validation
            if($login['blocked']!=null){
                $dateBlocked = date($login['blocked']);
                $dateNow = date('Y-m-d H:i:s');
                if($dateBlocked > $dateNow){
                    $session->setFlashdata('toast', ['error',lang("App.login_alert"),lang("App.login_alert_user_blocked").$settings['throttle_auth_lockour_time'].' '.lang("App.global_hours")]);
                    return redirect()->to('login');
                }else{
                    $this->user_model->save([
                        'id_user' => $login['id_user'],
                        'blocked' => null
                    ]);
                }
            }

            // Get Ip Address
            $request = \Config\Services::request();
            $last_ip = $request->getIPAddress();

            if(empty($session->get('oauth'))){
                // Check user password
                $phpass = new PasswordHash(8, true);
                if(!$phpass->CheckPassword($getVar['password']??'', $login['password'])){
                    // Throttling Validation
                    if($settings['throttle_auth']??false){
                        $initialDate = date('Y-m-d H:i:s', strtotime('-12 hour', time()));
                        $finalDate = date('Y-m-d H:i:s');
                        $amount = $this->activity_model->where('user',$login['token'])->where('level','throttling')->where('created_at between \''.$initialDate.'\' and \''.$finalDate.'\'')->countAllResults();
                        if($amount >= intval($settings['throttle_auth_max_attempts']??'')){
                            $session->setFlashdata('toast', ['error',lang("App.login_alert"),lang("App.login_alert_user_blocked").$settings['throttle_auth_lockour_time'].' '.lang("App.global_hours")]);
                            $blocked = date('Y-m-d H:i:s', strtotime('+'.$settings['throttle_auth_lockour_time'].' hour', time()));
                            $this->user_model->save([
                                    'id_user' => $login['id_user'],
                                    'blocked' => $blocked
                                ]);
                            return redirect()->to('login');
                        }else{
                            // Register Throttling Log
                            $this->integration->setLog('throttling','login-authenticate',$login['token']);
                            $session->setFlashdata('toast', ['error',lang("App.login_alert"),lang("App.login_alert_pass_invalid_2"). ($amount+1) .lang("App.login_alert_pass_attempt"). $settings['throttle_auth_max_attempts']??0]);
                            return redirect()->to('login');
                        }
                    }
                    $session->setFlashdata('toast', ['error',lang("App.login_alert"),lang("App.login_alert_pass_invalid")]);
                    return redirect()->to('login');
                }
                // Check email confirmed
                if($settings['email_confirmation']??false){
                    if(!$login['email_confirmed']){
                        $session->setFlashdata('toast', ['error',lang("App.login_alert"),lang("App.user_alert_email_confirmed")]);
                        return redirect()->to('login');
                    }
                }
                // Check sms confirmed
                if($settings['sms_confirmation']??false){
                    if(!$login['sms_confirmed']){
                        $session->setFlashdata('toast', ['error',lang("App.login_alert"),lang("App.user_alert_sms_confirmed")]);
                        return redirect()->to('login');
                    }
                }
            }

            // Check user status
            if(!$login['status']){
                $session->setFlashdata('toast', ['error',lang("App.login_alert"),lang("App.login_alert_disabled_access")]);
                return redirect()->to('/login');
            }

            // Get access rules
            $rules = $this->group_model->where('token', $login['group'])->first();

            // Save data in session
            $session->set('id_user', $login['id_user']);
            $session->set('group', $login['group']);
            $session->set('first_name', $login['first_name']);
            $session->set('last_name', $login['last_name']);
            $session->set('email', $login['email']);
            $session->set('token', $login['token']);
            $session->set('dashboard', $rules['dashboard']);
            $session->set('rules', html_entity_decode($rules['rules']));
            $session->set('picture', $login['picture']);
            $session->set('tfa', $login['tfa']);
            $session->set('tfa_secret', $login['tfa_secret']);
            $session->set('tfa_code', $login['tfa_code']);
            $session->set('lang', $login['language'] ?? 'en');
            // Update last access
            $last_access = date('Y-m-d H:i:s');
            $this->user_model->set('last_access', $last_access)->set('last_ip', $last_ip)->where('id_user', $session->get('id_user'))->update();

            // Register Access Log
            $integration = new \App\Controllers\Integration;
            $integration->setLog('information','login-authenticate');

            // Check if it has two factors
            if($login['tfa']??false){
                return redirect()->to('/login/authentication');
            }else{
                return redirect()->to('dashboard');
            }
        }
        else
        {
            $session->setFlashdata('toast', ['error',lang("App.login_alert"),lang("App.login_alert_user_not_found")]);
            return redirect()->to('login');
        }
    }

    public function logout()
    {
        // Destroy the session
        $session = session();
        $lang = $session->get('lang');
        $session->destroy();
        return redirect()->to('/lang/'.$lang);
    }

    public function signup()
    {
        $session = session();
        helper('form');
        $data['settings'] = $session->get('settings');
        $header['title'] = lang("App.login_title_signup");

        echo view(getenv('theme.backend.path').'login/header',$header);
        echo view(getenv('theme.backend.path').'form/login/signup',$data);
        echo view(getenv('theme.backend.path').'login/footer');
    }

    public function authentication()
    {
        $session = session();
        if($session->get('tfa')??false){
            $header['title'] = lang("App.login_title_otp");
            echo view(getenv('theme.backend.path').'login/header',$header);
            echo view(getenv('theme.backend.path').'form/login/authentication');
            echo view(getenv('theme.backend.path').'login/footer');
        }else{
            return redirect()->to('/login');
        }
    }

    public function otp()
    {
        $session = session();
        $tfa_secret = $session->get('tfa_secret');
        $tfa_code = $session->get('tfa_code');
        $pin = $this->request->getVar();
        $otp = "";

        foreach ($pin as $key=>$value){
            if(strpos($key, 'pin') !== false){
                $otp .= $value;
            }
        }

        $tfa = new Authenticator();
        $backup_pass = false;
        $checkResult = $tfa->verify($tfa_secret??'', $otp);

        if($tfa_code??'') {
            $backup_codes = explode(',' , $tfa_code??'');
            if (in_array($otp, $backup_codes)) {
                $backup_pass = true;
                $key = array_search($otp, $backup_codes);
                unset($backup_codes[$key]);
            }
        }

        if($checkResult || $backup_pass == true) {
            $session->set('tfa',false);
            $session->set('tfa_secret','');
            $session->set('tfa_code','');
            return redirect()->to('/dashboard');
        } else {
            $session->setFlashdata('toast', ['error',lang("App.login_alert"),lang("App.login_alert_code_invalid")]);
            return redirect()->to('/login/authentication');
        }
    }

    public function store()
    {
        $session = session();
        $settings = $session->get('settings');

        helper('form');
        helper('text');

        $rules = [
            'first_name'    => 'required',
            'last_name'    => 'required',
            'mobile'    => 'required',
            'email'    => 'required|valid_email|is_unique[user.email]',
            'password' => 'required|min_length[8]'
        ];
        $rules_error = [
            'first_name' => [
                'required' => lang("App.login_rules_first_name_r")
            ],
            'last_name' => [
                'required' => lang("App.login_rules_last_name_r")
            ],
            'mobile' => [
                'required' => lang("App.login_rules_mobile_r")
            ],
            'email' => [
                'required' => lang("App.login_rules_email_r"),
                'is_unique' => lang("App.login_rules_email_i"),
                'valid_email' => lang("App.login_rules_email_v"),
            ],
            'password' => [
                'required' => lang("App.login_rules_password_r"),
                'min_length' => lang("App.login_rules_password_m")
            ]
        ];

        if ($this->validate($rules,$rules_error)){
            if($listPost = $this->request->getPost()) {
                if($settings['captcha_register']??false){
                    if($settings['captcha_gateway'] == 'recaptcha'){
                        if(isset($listPost['g-recaptcha-response'])){
                            $captcha = $listPost['g-recaptcha-response'];
                            $url = 'https://www.google.com/recaptcha/api/siteverify?secret='.urlencode($settings['captcha_secret_key']??'').'&response='.urlencode($captcha);
                            $response = file_get_contents($url);
                            $responseKeys = json_decode($response,true);
                            if(!$responseKeys["success"]) {
                                $session->setFlashdata('toast', ['error',lang("App.login_alert"),lang("App.login_alert_captcha_invalid")]);
                                $this->signup();
                                die();
                            }
                        }else{
                            $session->setFlashdata('toast', ['error',lang("App.login_alert"),lang("App.login_alert_captcha_not_found")]);
                            $this->signup();
                            die();
                        }
                    }
                    if($settings['captcha_gateway'] == 'hcaptcha'){
                        if(isset($listPost['h-captcha-response'])){
                            $captcha = $listPost['h-captcha-response'];
                            $url = 'https://hcaptcha.com/siteverify?secret='.urlencode($settings['captcha_secret_key']??'').'&response='.urlencode($captcha).'&remoteip='.$_SERVER['REMOTE_ADDR'];
                            $response = file_get_contents($url);
                            $responseKeys = json_decode($response,true);
                            if(!$responseKeys["success"]) {
                                $session->setFlashdata('toast', ['error',lang("App.login_alert"),lang("App.login_alert_captcha_invalid")]);
                                $this->signup();
                                die();
                            }
                        }else{
                            $session->setFlashdata('toast', ['error',lang("App.login_alert"),lang("App.login_alert_captcha_not_found")]);
                            $this->signup();
                            die();
                        }
                    }
                }
                $phpass = new PasswordHash(8, true);
                $userToken = md5(uniqid(rand(), true));
                $this->user_model->save([
                    'group' => $settings['default_role'],
                    'first_name' => $listPost['first_name'],
                    'last_name' => $listPost['last_name'],
                    'mobile' => trim($listPost['ddi']." ".$listPost['mobile']),
                    'city' => $listPost['city'],
                    'state' => $listPost['state'],
                    'country' => strtoupper($listPost['country']),
                    'picture' => '/assets/img/default-user.png',
                    'email' => $listPost['email'],
                    'password' => $phpass->HashPassword($listPost['password']),
                    'last_access' => date('Y-m-d h:i:s'),
                    'last_ip' => '::1',
                    'language' => $settings['default_language'],
                    'token' => $userToken,
                    'status' => true
                ]);
                //Get Data Template
                $templates = $this->template_model->findAll();

                //Notification E-mail User Welcome
                if($settings['send_email_welcome']??false){
                    $template = templateSelect($templates,'template_label_welcome','email');
                    if($template != null){
                        try {
                            $this->integration->send_email($listPost['email'],$template['subject'],$template['body'],$phpass->HashPassword(MD5($listPost['email'])));
                        }catch (\Exception $e){
                        }
                    }
                }
                //Notification SMS User Welcome
                if($settings['send_sms_welcome']??false){
                    $template = templateSelect($templates,'template_label_welcome','sms');
                    if($template != null){
                        try {
                            $this->integration->send_sms($listPost['mobile'],$template['body'],$phpass->HashPassword(MD5($listPost['mobile'])));
                        }catch (\Exception $e){
                        }
                    }
                }

                //E-mail Account Confirmation
                if($settings['email_confirmation']??false){
                    $template = templateSelect($templates,'template_label_confirmation_email','email');
                    if($template != null){
                        $token = random_string("alnum", 50);
                        $url = base_url().'/login/confirmation/'.$token;
                        $body = str_replace('[link_confirmation]',$url,$template['body']);
                        try {
                            $this->integration->send_email($listPost['email'],$template['subject'],$body,$phpass->HashPassword(MD5($listPost['email'])));
                            $this->confirmation_model->save([
                                'id_confirmation' => null,
                                'user' => $userToken,
                                'token' => $token,
                                'confirmed' => false,
                                'type' => 'email'
                            ]);
                        }catch (\Exception $e){
                        }
                    }
                }
                //SMS Account Confirmation
                if($settings['sms_confirmation']??false){
                    $template = templateSelect($templates,'template_label_confirmation_sms','sms');
                    if($template != null){
                        $token = random_string("alnum", 50);
                        $url = base_url().'/login/confirmation/'.$token;
                        $body = str_replace('[link_confirmation]',$url,$template['body']);
                        try {
                            $this->integration->send_sms($listPost['mobile'],$body,$phpass->HashPassword(MD5($listPost['mobile'])));
                            $this->confirmation_model->save([
                                'id_confirmation' => null,
                                'user' => $userToken,
                                'token' => $token,
                                'confirmed' => false,
                                'type' => 'sms'
                            ]);
                        }catch (\Exception $e){
                        }
                    }
                }

                //Notification New Register
                if($settings['send_notification_register']??false){
                    $template = templateSelect($templates,'template_label_notification','email');
                    if($template != null){
                        if(!empty($settings['send_user_register']??null)){
                            $data = [
                                'id_notification'           => null,
                                'user_sender'               => $settings['send_user_register']??null,
                                'user_recipient'            => $settings['send_user_register']??null,
                                'title'                     => $template['subject'],
                                'body'                      => $template['body'],
                                'is_read'                   => false,
                                'is_send_email'             => false,
                                'is_send_sms'               => false,
                                'send_email_notification'   => $settings['send_email_register']??false,
                                'send_sms_notification'     => $settings['send_sms_register']??false,
                                'token'                     => md5(uniqid(rand(), true))
                            ];
                            $this->notification_model->save($data);
                        }
                    }
                }else{
                    $userAdm = $this->user_model->where('token',$settings['send_user_register']??null)->first();
                    if($settings['send_email_register']??false){
                        $template = templateSelect($templates,'template_label_notification','email');
                        if($template != null){
                            try {
                                $this->integration->send_email($userAdm['email'],$template['subject'],$template['body'],$phpass->HashPassword(MD5($listPost['email'])));
                            }catch (\Exception $e){
                            }
                        }
                    }
                    if($settings['send_sms_register']??false){
                        $template = templateSelect($templates,'template_label_notification','sms');
                        if($template != null){
                            try {
                                $this->integration->send_sms($userAdm['mobile'],$template['body'],$phpass->HashPassword(MD5($listPost['mobile'])));
                            }catch (\Exception $e){
                            }
                        }
                    }
                }
                $session = session();
                $session->setFlashdata('toast', ['success', lang("App.login_alert_success"), lang("App.login_alert_success_register")]);
                return redirect()->to('/login');
            }else{
                $session->setFlashdata('toast', ['error', lang("App.login_alert"),lang("App.login_alert_parameter_invalid")]);
                $this->signup();
            }
        }else{
            $session = session();
            $session->setFlashdata('error','error');
            $this->signup();
        }
    }

    public function recovery($token=null)
    {
        $session = session();
        if(!empty($token) && $session->get('settings')['forgot_password']??false){
            $pass_recovery = $this->pass_recovery_model->where('token',$token)->where('changed',false)->first();
            if($pass_recovery != null){
                $data['token'] = $token;
                $data['user'] = $pass_recovery['user'];
                $header['title'] = lang("App.login_title_recovery");
                echo view(getenv('theme.backend.path').'login/header',$header);
                echo view(getenv('theme.backend.path').'form/login/password_recovery',$data);
                echo view(getenv('theme.backend.path').'login/footer');
            }else{
                $session->setFlashdata('toast', ['error', lang("App.login_alert"), lang("App.login_alert_invalid_token")]);
                return redirect()->to('/login');
            }
        }else{
            $session->setFlashdata('toast', ['error', lang("App.login_alert"), lang("App.login_alert_empty_token")]);
            return redirect()->to('/login');
        }
    }

    public function recovery_store()
    {
        $session = session();

        helper('form');

        $rules = [
            'password' => 'required|min_length[8]'
        ];

        $rules_error = [
            'password' => [
                'required' => lang("App.login_rules_password_r"),
                'min_length' => lang("App.login_rules_password_m")
            ]
        ];

        if ($this->validate($rules,$rules_error)){
            if($listPost = $this->request->getPost()) {
                $pass_recovery = $this->pass_recovery_model->where('user',$listPost['user'])->where('token',$listPost['token'])->where('changed',false)->first();
                if($pass_recovery != null){
                    $user = $this->user_model->select('id_user')->where('token',$listPost['user'])->first();
                    if($user != null){
                        $phpass = new PasswordHash(8, true);
                        $this->user_model->save([
                            'id_user' => $user['id_user'],
                            'password' => $phpass->HashPassword($listPost['password'])
                        ]);
                        $this->pass_recovery_model->save([
                            'id_pass_recovery' => $pass_recovery['id_pass_recovery'],
                            'changed' => true
                        ]);
                        $session->setFlashdata('toast', ['success', lang("App.login_alert_success"), lang("App.login_alert_success_recovery")]);
                    }
                }
                return redirect()->to('/login');
            }else{
                $session->setFlashdata('toast', ['error', lang("App.login_alert"), lang("App.login_alert_parameter_invalid")]);
                $this->recovery($this->request->getVar('token'));
            }
        }else{
            $session->setFlashdata('error','error');
            $this->recovery($this->request->getVar('token'));
        }
    }

    public function confirmation($token=null)
    {
        $session = session();
        if(!empty($token)){
            $confirmation = $this->confirmation_model->where('token',$token)->where('confirmed',false)->first();
            if($confirmation != null){
                $user = $this->user_model->select('id_user')->where('token',$confirmation['user'])->first();
                if($confirmation['type'] == 'email'){
                    $this->user_model->save([
                        'id_user'=>$user['id_user'],
                        'email_confirmed'=>true
                    ]);
                }
                if($confirmation['type'] == 'sms'){
                    $this->user_model->save([
                        'id_user'=>$user['id_user'],
                        'sms_confirmed'=>true
                    ]);
                }
                $this->confirmation_model->save([
                    'id_confirmation'=>$confirmation['id_confirmation'],
                    'confirmed'=>true
                ]);
                $session->setFlashdata('toast', ['success', lang("App.login_alert_success"), lang("App.login_alert_success_confirmation")]);
                return redirect()->to('/login');
            }else{
                $session->setFlashdata('toast', ['error', lang("App.login_alert"), lang("App.login_alert_invalid_token")]);
                return redirect()->to('/login');
            }
        }else{
            $session->setFlashdata('toast', ['error', lang("App.login_alert"), lang("App.login_alert_empty_token")]);
            return redirect()->to('/login');
        }
    }
}
