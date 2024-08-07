<?php

namespace App\Controllers;

use App\Models\ActivityModel;
use App\Models\PasswordRecoveryModel;
use App\Models\SettingsModel;
use App\Models\TemplateModel;
use App\Models\UserModel;
use App\Libraries\PasswordHash;
use CodeIgniter\HTTP\Files\FileCollection;
use Pusher\Pusher;

class Integration extends BaseController
{
    private $user_model;
    private $settings_model;
    private $pass_recovery_model;
    private $template_model;
    private $activity_model;
    private $id_user;
    private $token_user;

    function __construct()
    {
        $this->user_model = new UserModel();
        $this->settings_model = new SettingsModel();
        $this->pass_recovery_model = new PasswordRecoveryModel();
        $this->template_model = new TemplateModel();
        $this->activity_model = new ActivityModel();
        $this->id_user = session()->get('id_user');
        $this->token_user = session()->get('token');
    }

    public function index()
    {
        echo view(getenv('theme.backend.path').'main/header');
        echo view(getenv('theme.backend.path').'form/dashboard/index');
        echo view(getenv('theme.backend.path').'main/footer');
    }

    public function send_email($email='',$subject='',$body='',$key='',$json=false){
        if(empty($email)){
            return $json ? json_encode(["return" => false]) : false;
        }
        $phpass = new PasswordHash(8, true);
        if(!$phpass->CheckPassword(MD5($email), $key)){
            return $json ? json_encode(["return" => false]) : false;
        }
        $user = $this->user_model->where('email',$email??null)->first();
        if(!empty($user)){
            foreach (keywordEmail()??[] as $item){
                $field = str_replace(['[','user_',']'],'',$item);
                $body = str_replace('['.$item.']',$user[$field],$body);
            }
        }
        if($this->sendMail($subject,unescape($body),$email)){
            return $json ? json_encode(["return" => true]) : true;
        }else{
            return $json ? json_encode(["return" => false]) : false;
        }
    }

    public function send_email_test($email=''){
        $token = session()->get('token')??'';
        if(!empty($token)){
            if(empty($email)){
                return $this->response->setJSON(["return" => false]);
            }
            $subject = "Email Test";
            $body = "Email working successfully!";
            if($this->sendMail($subject,unescape($body),$email)){
                return $this->response->setJSON(["return" => true]);
            }else{
                return $this->response->setJSON(["return" => false]);
            }
        }else{
            return $this->response->setJSON(["return" => false]);
        }
    }

    public function send_sms($number='',$body='',$token='',$key='',$json=false){
        if(empty($number)){
            return $json ? json_encode(["return" => false]) : false;
        }
        $phpass = new PasswordHash(8, true);
        if(!$phpass->CheckPassword(MD5($number), $key)){
            return $json ? json_encode(["return" => false]) : false;
        }
        if(!empty($token)){
            $user = $this->user_model->where('token',$token??null)->first();
            if(!empty($user)){
                foreach (keywordEmail()??[] as $item){
                    $field = str_replace(['[','user_',']'],'',$item);
                    $body = str_replace('['.$item.']',$user[$field],$body);
                }
            }
        }
        $body = strip_tags(unescape($body));
        $body = str_replace('&nbsp;', ' ',$body);
        if($this->sendSMS($body,$number)){
            return $json ? json_encode(["return" => true]) : true;
        }else{
            return $json ? json_encode(["return" => false]) : false;
        }
    }

    public function send_pusher($channel='',$data='',$key='',$json=false){
        if(empty($channel)){
            return $json ? json_encode(["return" => false]) : false;
        }
        $phpass = new PasswordHash(8, true);
        if(!$phpass->CheckPassword(MD5($channel), $key)){
            return $json ? json_encode(["return" => false]) : false;
        }
        $user = $this->user_model->where('token',$channel??null)->first();
        if(!empty($user)){
            if($this->sendPusher($channel,$data)){
                return $json ? json_encode(["return" => true]) : true;
            }else{
                return $json ? json_encode(["return" => false]) : false;
            }
        }
        return $json ? json_encode(["return" => false]) : false;
    }

    public function reset_password(){
        $session = session();
        $settings = $session->get('settings');
        helper('text');

        if($listPost = $this->request->getPost()){

            // Captcha Validation
            if($settings['captcha_recovery']??false){
                if($settings['captcha_gateway'] == 'recaptcha'){
                    if(isset($listPost['g-recaptcha-response'])){
                        $captcha = $listPost['g-recaptcha-response'];
                        $url = 'https://www.google.com/recaptcha/api/siteverify?secret='.urlencode($settings['captcha_secret_key']??'').'&response='.urlencode($captcha);
                        $response = file_get_contents($url);
                        $responseKeys = json_decode($response,true);
                        if(!$responseKeys["success"]) {
                            $session->setFlashdata('toast', ['error',lang("App.login_alert"),lang("App.login_alert_captcha_invalid")]);
                            return redirect()->to('/login/forgot_password');
                        }
                    }else{
                        $session->setFlashdata('toast', ['error',lang("App.login_alert"),lang("App.login_alert_captcha_not_found")]);
                        return redirect()->to('/login/forgot_password');
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
                            return redirect()->to('/login/forgot_password');
                        }
                    }else{
                        $session->setFlashdata('toast', ['error',lang("App.login_alert"),lang("App.login_alert_captcha_not_found")]);
                        return redirect()->to('/login/forgot_password');
                    }
                }
            }

            $user = $this->user_model->where('email',$listPost['email']??null)->first();

            if(empty($user)){
                $session->setFlashdata('toast', ['error',lang("App.login_alert"),lang("App.login_alert_user_not_found")]);
                return redirect()->to('/login/forgot_password');
            }

            $template = $this->template_model->where('id_template',1)->first();

            foreach (keywordEmail()??[] as $item){
                $field = str_replace(['[','user_',']'],'',$item);
                $template = str_replace('['.$item.']',$user[$field],$template);
            }

            $token = random_string("alnum", 50);
            $url = base_url().'/login/recovery/'.$token;

            $this->pass_recovery_model->save([
                'user' => $user['token'],
                'token' => $token
            ]);

            $title = $template['subject']??'';
            $msg = $template['body']??'';
            $msg = str_replace('[recovery_password]',$url,$msg);
            $email = $user['email'];

            $this->setLog('recovery','recovery-password',$user['token']);
            $send = $this->sendMail($title,$msg,$email);
            if($send){
                $session->setFlashdata('toast', ['success',lang("App.login_alert_send"),lang("App.login_alert_send_pass")]);
                return redirect()->to('/login/forgot_password');
            }else{
                $session->setFlashdata('toast', ['error',lang("App.login_alert"),lang("App.login_alert_error_email")]);
                return redirect()->to('/login/forgot_password');
            }
        }else{
            $session->setFlashdata('toast', ['error',lang("App.login_alert"),lang("App.login_alert_error_pass")]);
            return redirect()->to('/login/forgot_password');
        }
    }

    public function setLog($level,$event,$user='')
    {
        $request = \Config\Services::request();
        $ip = $request->getIPAddress();
        $agent = $request->getUserAgent();

        if ($agent->isBrowser())
        {
            $currentAgent = $agent->getBrowser().' '.$agent->getVersion();
        }
        elseif ($agent->isRobot())
        {
            $currentAgent = $this->agent->robot();
        }
        elseif ($agent->isMobile())
        {
            $currentAgent = $agent->getMobile();
        }
        else
        {
            $currentAgent = 'Unidentified User Agent';
        }

        $this->activity_model->save([
            'user' => $this->token_user??$user,
            'level' => $level,
            'event' => $event,
            'ip' => $ip,
            'os' => $agent->getPlatform(),
            'browser' => $currentAgent,
            'detail' => $agent
        ]);
    }

    private function sendPusher($channel,$data)
    {
        try {
            $obj = $this->settings_model->first();
            if($obj['pusher_enable']){
                $appId = $obj['pusher_appId'];
                $key = $obj['pusher_key'];
                $secret = $obj['pusher_secret'];
                $cluster = $obj['pusher_cluster'];
                $useTLS = $obj['pusher_useTLS'];
                $scheme = $obj['pusher_scheme'] ? 'https' : 'http';
                $pusher = new Pusher($key, $secret, $appId, [
                    'cluster' => $cluster,
                    'useTLS' => $useTLS,
                    'scheme' => $scheme,
                ]);
                $pusher->trigger($channel, 'notification-web', $data);
                return true;
            }
            return false;
        } catch (\Exception $ex) {
            return false;
        }
    }

    private function sendMail($subject,$body,$recipient)
    {
        $config = $this->settings_model->first();
        $gateway = $config['email_gateway'];
        $body = html_entity_decode($body);

        if($gateway == 'smtp'){
            try {
                //https://codeigniter.com/user_guide/libraries/email.html
                $email = \Config\Services::email();
                $config['protocol'] = $config['email_gateway'];
                $config['SMTPHost'] = $config['email_smtp'];
                $config['SMTPUser'] = $config['email_address'];
                $config['SMTPPass'] = $config['email_pass'];
                $config['SMTPPort'] = $config['email_port'];
                $config['SMTPCrypto'] = $config['email_cert']=='none'?'':$config['email_cert'];
                $config['SMTPTimeout'] = 15;
                $config['mailType'] = 'html';
                $config['wordWrap'] = true;

                $email->initialize($config);

                $email->setFrom($config['email_address'],  $config['email_name']);
                $email->setTo($recipient);

                $email->setSubject($subject);
                $email->setMessage($body);

                if (!$email->send())
                {
                    return false;
                }else{
                    return true;
                }
            } catch (\Exception $ex) {
                return false;
            }
        }
        return false;
    }

    private function sendSMS($body,$recipient)
    {
        $config = $this->settings_model->first();
        $gateway = $config['sms_gateway'];
        $sid = $config['sms_account_id'];
        $token = $config['sms_auth_token'];
        $number = $config['sms_info_add'];

        if($gateway == 'twilio'){
            try {
                $client = new \Twilio\Rest\Client($sid, $token);
                $message = $client->messages->create(
                    $number, // Text this number
                    [
                        'from' => $recipient, // From a valid Twilio number
                        'body' => $body
                    ]
                );
                //var_dump($message->sid);
                return true;
            } catch (\Exception $ex) {
                //print 'Twilio error: ' . $ex->getMessage();
                return false;
            }
        }
        return false;
    }

    public function saveStorage($file=null,$path='',$allow=[]){
        $config = $this->settings_model->first();
        $gateway = $config['storage_gateway'];

        switch ($gateway) {
            case "local":
                try {
                    $ext =  $file ? $file->getExtension() : '';
                    if (in_array(strtolower($ext), $allow)) {
                        if(strtolower(PHP_OS) == 'linux'){
                            $pathServer = $path;
                        }else{
                            $pathServer = str_replace('/','\\',$path);
                        }
                        if ($file->isValid()) {
                            $name = $file->getName();
                            $rename = $file->getRandomName();
                            $file->move($pathServer,$rename);
                            return $path.$rename;
                        }
                    }
                    return null;
                } catch (\Exception $ex) {
                    return null;
                }

            case "aws":
            case "minio":
            $aws_endpoint = $config['aws_endpoint'];
            $aws_key = $config['aws_key'];
            $aws_secret = $config['aws_secret'];
            $aws_region = $config['aws_region'];
            $aws_bucket = $config['aws_bucket'];

            try {
                $ext =  $file ? $file->getExtension() : '';
                if (in_array(strtolower($ext), $allow)) {

                    if($gateway=="minio"){
                        $s3Client = new \Aws\S3\S3Client([
                            'version' => 'latest',
                            'region'  => $aws_region,
                            'endpoint' => $aws_endpoint,
                            'use_path_style_endpoint' => true,
                            'credentials' => [
                                'key'    => $aws_key,
                                'secret' => $aws_secret
                            ]
                        ]);
                    }else{
                        $s3Client = new \Aws\S3\S3Client([
                            'version' => 'latest',
                            'region'  => $aws_region,
                            'credentials' => [
                                'key'    => $aws_key,
                                'secret' => $aws_secret
                            ]
                        ]);
                    }

                    try {
                        $rename = $file->getRandomName();
                        $file->move(WRITEPATH.'uploads',$rename);
                        if(strtolower(PHP_OS) == 'linux'){
                            $file_Path = WRITEPATH.'uploads/'. $rename;
                        }else{
                            $file_Path = WRITEPATH.'uploads\\'. $rename;
                        }
                        $result = $s3Client->putObject([
                            'Bucket' => $aws_bucket,
                            'Key'    => $rename,
                            'Body'   => fopen($file_Path, 'r')
                        ]);
                        unlink($file_Path);
                        if($result['@metadata']['statusCode'] == 200){
                            return $result['@metadata']['effectiveUri'];
                        }else{
                            return null;
                        }
                    } catch (\Aws\S3\Exception\S3Exception $e) {
                        return null;
                    }
                }
                return null;
            } catch (\Exception $ex) {
                return null;
            }
            default:
                return null;
        }
    }

    public function saveStorageBackup($file=null,$name=null){
        $config = $this->settings_model->first();
        $gateway = $config['backup_storage'];

        switch ($gateway) {
            case "local":
                try {
                    return $file;
                } catch (\Exception $ex) {
                    return null;
                }

            case "aws":
            case "minio":
                $aws_endpoint = $config['aws_endpoint'];
                $aws_key = $config['aws_key'];
                $aws_secret = $config['aws_secret'];
                $aws_region = $config['aws_region'];
                $aws_bucket = $config['aws_bucket'];

                try {
                    if($gateway=="minio"){
                        $s3Client = new \Aws\S3\S3Client([
                            'version' => 'latest',
                            'region'  => $aws_region,
                            'endpoint' => $aws_endpoint,
                            'use_path_style_endpoint' => true,
                            'credentials' => [
                                'key'    => $aws_key,
                                'secret' => $aws_secret
                            ]
                        ]);
                    }else{
                        $s3Client = new \Aws\S3\S3Client([
                            'version' => 'latest',
                            'region'  => $aws_region,
                            'credentials' => [
                                'key'    => $aws_key,
                                'secret' => $aws_secret
                            ]
                        ]);
                    }

                    try {
                        $result = $s3Client->putObject([
                            'Bucket' => $aws_bucket,
                            'Key'    => $name,
                            'Body'   => fopen($file, 'r')
                        ]);
                        unlink($file);
                        if($result['@metadata']['statusCode'] == 200){
                            return $result['@metadata']['effectiveUri'];
                        }else{
                            return null;
                        }
                    } catch (\Aws\S3\Exception\S3Exception $e) {
                        return null;
                    }
                } catch (\Exception $ex) {
                    return null;
                }
            default:
                return null;
        }
    }

    public function create_backup($download=false)
    {
        //Demo Mode
        if(env('demo.mode')??false){
            if($download==true){
                session()->setFlashdata('sweet', ['warning',lang("App.general_demo_mode")]);
                return redirect()->to('/settings');
            }else{
                die();
            }
        }
        $settings = $this->settings_model->first()??[];
        if($settings['backup_automatic']){
            helper('text');
            $db = db_connect('default');
            try {
                $all = false;
                $tables = explode(',',$settings['backup_table']??'');
                foreach ($tables as $item){
                    if ($item == 'all'){
                        $all = true;
                    }
                }
                $token = random_string("alnum", 10);
                $name ='mysql_'.$token.'_'.date("YmdHis").'.sql';
                if(strtolower(PHP_OS) == 'linux'){
                    $file_Path = WRITEPATH.'uploads/'.$name;
                }else{
                    $file_Path = WRITEPATH.'uploads\\'.$name;
                }
                if($all){
                    \Spatie\DbDumper\Databases\MySql::create()
                        ->setHost(getenv('database.default.hostname'))
                        ->setDbName(getenv('database.default.database'))
                        ->setUserName(getenv('database.default.username'))
                        ->setPassword(getenv('database.default.password'))
                        ->setDumpBinaryPath(getenv('database.default.dump'))
                        ->dumpToFile($file_Path);
                }else{
                    \Spatie\DbDumper\Databases\MySql::create()
                        ->setHost(getenv('database.default.hostname'))
                        ->setDbName(getenv('database.default.database'))
                        ->setUserName(getenv('database.default.username'))
                        ->setPassword(getenv('database.default.password'))
                        ->setDumpBinaryPath(getenv('database.default.dump'))
                        ->includeTables($tables)
                        ->dumpToFile($file_Path);
                }
                $file = $this->saveStorageBackup($file_Path,$name);
                $db->query("INSERT INTO backup VALUES (NULL,'".$file."','',NOW(),NOW())");
                if($settings['backup_notification_email']){
                    $send = $this->send_email($settings['backup_email'],$settings['title']." (BACKUP)",lang("App.crontab_backup_success").date("Y-m-d H:i:s"));
                    if(!$send){
                        $db->query("INSERT INTO backup VALUES (NULL,'','".lang("App.crontab_email_error")."',NOW(),NOW())");
                    }
                }
                if($download){
                    $this->download_backup($file,$name);
                }
            } catch (\Spatie\DbDumper\Exceptions\DumpFailed $e) {
                $error = str_replace("'","\'",$e->getMessage());
                $db->query("INSERT INTO backup VALUES (NULL,'','".$error."',NOW(),NOW())");
                if($settings['backup_notification_email']){
                    $send = $this->send_email($settings['backup_email'],$settings['title']." (BACKUP ERROR)",'Error: '.$e->getMessage());
                    if(!$send){
                        $db->query("INSERT INTO backup VALUES (NULL,'','".lang("App.crontab_email_error")."',NOW(),NOW())");
                    }
                }
                if($download){
                    session()->setFlashdata('sweet', ['error',lang("App.crontab_backup_error")]);
                    return redirect()->to('/settings');
                }
            }
        }
    }

    private function download_backup($path=null,$name=null)
    {
        if (!empty(session()->get('token')??'')){
            set_time_limit(0);
            if(!empty($path) && !empty($name) && file_exists($path)){
                header('Content-Description: File Transfer');
                header('Content-Disposition: attachment; filename="'.$name.'"');
                header('Content-Type: application/octet-stream');
                header('Content-Transfer-Encoding: binary');
                header('Content-Length: ' . filesize($path));
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
                header('Expires: 0');
                readfile($path);
            }
        }else{
            return redirect()->to('/settings');
        }
    }

    public function download_postman()
    {
        if(!empty(session()->get('token')??'')){
            set_time_limit(0);
            $path = WRITEPATH.'postman_collection.json';
            if(file_exists($path)){
                header('Content-Description: File Transfer');
                header('Content-Disposition: attachment; filename="WebGuard ApiRest - postman_collection.json"');
                header('Content-Type: application/octet-stream');
                header('Content-Transfer-Encoding: binary');
                header('Content-Length: ' . filesize($path));
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
                header('Expires: 0');
                readfile($path);
            }
        }else{
            return redirect()->to('/settings');
        }
    }
}
