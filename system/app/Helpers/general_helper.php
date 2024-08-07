<?php
////////////////////////////////////////////////////
/// Control Rules and Menus
////////////////////////////////////////////////////

function getAllClass($controller = null){
    try {
        helper('filesystem');
        helper('directory');
        if(strtolower(PHP_OS) == 'linux'){
            $compatibility = '/';
        }else{
            $compatibility = '\\';
        }
        if(empty($controller)){
            $map = directory_map(APPPATH.'Controllers');
            foreach ($map as $key=>$item)
            {
                if(!strpos(strtolower($key),$compatibility)){
                    $name = str_replace('.php', '', $item);
                    if(!getIgnoreController($name)){
                        $controllers[] = [
                            'name' => $name,
                            'path' => '',
                            'methods' => get_class_methods('App\Controllers\\'.$name)
                        ];
                    }
                }else{
                    foreach ($item as $subitem){
                        $name = str_replace('.php', '', $subitem);
                        if(!getIgnoreController($name)) {
                            $controllers[] = [
                                'name' => $name,
                                'path' => $key,
                                'methods' => get_class_methods('App\Controllers\\' . str_replace('/', '\\', $key) . $name)
                            ];
                        }
                    }
                }
            }
        }else{
            $array = explode('/',$controller);
            $dir = count($array) > 1 ? $array[0] : '';
            $name = count($array) > 1 ? '\\'.$array[1] : $array[0];
            $controllers[] = [
                'name' => $name,
                'path' => $dir,
                'methods' => get_class_methods('App\Controllers\\'.str_replace('/','\\',$dir).$name)
            ];
        }
        return $controllers??[];
    } catch (Exception $e) {
        return [];
    }
}

function getAllClassFolder($folder = null){
    try {
        helper('filesystem');
        helper('directory');

        if(!empty($folder)){
            $map = directory_map(APPPATH.'Controllers');
            foreach ($map as $key=>$item)
            {
                if(strtolower(PHP_OS) == 'linux'){
                    $compatibility = '/';
                }else{
                    $compatibility = '\\';
                }
                if(str_replace($compatibility,'',strtolower($key)) == strtolower($folder)){
                    foreach ($item as $subitem){
                        $name = str_replace('.php', '', $subitem);
                        $controllers[] = [
                            'name' => $name,
                            'path' => $key,
                            'methods' => get_class_methods('App\Controllers\\'.str_replace('/','\\',$key).$name)
                        ];
                    }
                }
            }
        }
        return $controllers??[];
    } catch (Exception $e) {
        return [];
    }
}

function getAllFolder(){
    try {
        helper('filesystem');
        helper('directory');
        $map = directory_map(APPPATH.'Controllers',1);
        if(strtolower(PHP_OS) == 'linux'){
            $compatibility = '/';
        }else{
            $compatibility = '\\';
        }
        foreach ($map as $item) {
            if(strpos(strtolower($item),$compatibility)){
                $folders[] = str_replace($compatibility,"",$item);
            }
        }
        return $folders??[];
    } catch (Exception $e) {
        return [];
    }
}

function getIgnoreController($controller)
{
    try {
        $loginAuthFilter = new \App\Filters\LoginAuthFilter();
        foreach ($loginAuthFilter->whiteListController() as $item){
            if($controller == $item){
                return true;
            }
        }
        return false;
    } catch (Exception $e) {
        return [];
    }
}

function getIgnoreMethod($method)
{
    try {
        $loginAuthFilter = new \App\Filters\LoginAuthFilter();
        foreach ($loginAuthFilter->whiteListMethod() as $item){
            if($method == $item){
                return true;
            }
        }
        return false;
    } catch (Exception $e) {
        return [];
    }
}

function getDictionary($word=''){
    try {
        $dictionary = [
            'Group'  => lang("App.group_rules_label_group"),
            'User'  => lang("App.group_rules_label_user"),
            'My'  => lang("App.group_rules_label_my"),
            'Notification'  => lang("App.group_rules_label_notification"),
            'Settings'  => lang("App.group_rules_label_settings"),
            'Activity'  => lang("App.group_rules_label_activity"),
            'index'  => lang("App.group_rules_label_index"),
            'add'  => lang("App.group_rules_label_add"),
            'edit'  => lang("App.group_rules_label_edit"),
            'delete'  => lang("App.group_rules_label_delete"),
            'store'  => lang("App.group_rules_label_store"),
            'oauth'  => lang("App.group_rules_label_oauth"),
            'template'  => lang("App.group_rules_label_template"),
            'module'  => lang("App.group_rules_label_module"),
            'all'  => lang("App.group_rules_label_all"),
            'view'  => lang("App.group_rules_label_view"),
            'oauth_store'  => lang("App.group_rules_label_oauth_store"),
            'template_store'  => lang("App.group_rules_label_template_store"),
            'notification'  => lang("App.notification_group_notification"),
            'notification_view'  => lang("App.notification_group_notification_view"),
            'module_permission'  => lang("App.module_permission_menu"),
        ];
        return array_key_exists($word,$dictionary)?$dictionary[$word] : $word;
    } catch (Exception $e) {
        return '';
    }
}

function getMenuControl(){
    try {
        $getClass = getAllClass();
        $getRules = json_decode(session()->get('rules')??'[]');
        foreach ($getClass as $item){
            foreach ($getRules as $key=>$value){
                if($key == $item['name']){
                    $item['methods'] = $value;
                    $data[] = $item;
                }
            }
        }
        return $data??[];
    } catch (Exception $e) {
        session()->setFlashdata('alert', 'error_acesso');
        return [];
    }
}

function getArrayItem(array $array, $key, $word, $isArray=false)
{
    try {
        foreach ($array as $item){
           if ($isArray){
               foreach ($item[$key] as $subitem){
                   if($subitem == $word){
                       $data[]=$subitem;
                   }
               }
           }else{
               if($item[$key] == $word){
                   $data[]=$item;
               }
           }
        }
        return $data??[];
    } catch (Exception $e) {
        return [];
    }
}

////////////////////////////////////////////////////
/// Notification Messages
////////////////////////////////////////////////////

function formAlert()
{
    $session = session();
    $alert = $session->getFlashdata('error');
    $validation = \Config\Services::validation()->listErrors();
    if (!empty($alert)){
        return '<div class="alert alert-danger alert-dismissible alert-alt solid fade show">'.
               '	<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>'.
               '	</button>'. $validation .
               '</div>';
    }
}

function sweetAlert()
{
    try {
        $session = session();
        $alert = $session->getFlashdata('sweet');
        if (count((array)$alert) == 2){
            return "<script>".
                "    $(document).ready(function () {".
                "       'use strict';".
                "        swal({".
                "            position: 'center',".
                "            type: '".$alert[0]."',".
                "            title: '".$alert[1]."',".
                "            showConfirmButton: false,".
                "            timer: 2000,".
                "            confirmButtonClass: 'btn btn-primary',".
                "            buttonsStyling: false".
                "        });".
                "    });".
                "</script>";
        }
        if (count((array)$alert) == 4){
            return  "<script>".
                "    $(document).ready(function () {".
                "            'use strict';".
                "            swal({".
                "                title: '".$alert[1]."',".
                "                text: '".$alert[2]."',".
                "                type: '".$alert[0]."',".
                "                showCancelButton: !0,".
                "                confirmButtonColor: '#f34141',".
                "                confirmButtonText: 'Sim, Deletar!',".
                "                cancelButtonText: 'Cancelar',".
                "                closeOnConfirm: !1".
                "            }).then(function(isConfirm) {".
                "                if (isConfirm.value) {".
                "                    window.location.href = '".$alert[3]."'".
                "                }".
                "            });".
                "        });".
                "</script>";
        }
    }catch (Exception $ex){
    }
}

function toastAlert()
{
    try {
        $session = session();
        $alert = $session->getFlashdata('toast');
        if (count((array)$alert) == 3) {
            return "<script>" .
                "    $(document).ready(function () {" .
                "           'use strict';".
                "           let config = {" .
                "	            positionClass: 'toast-top-center'," .
                "	            timeOut: 5e3," .
                "	            closeButton: !0," .
                "	            debug: !1," .
                "	            newestOnTop: !0," .
                "	            progressBar: !0," .
                "	            preventDuplicates: !0," .
                "	            onclick: null," .
                "	            showDuration: '300'," .
                "	            hideDuration: '1000'," .
                "	            extendedTimeOut: '1000'," .
                "	            showEasing: 'swing'," .
                "	            hideEasing: 'linear'," .
                "	            showMethod: 'fadeIn'," .
                "	            hideMethod: 'fadeOut'," .
                "	            tapToDismiss: !1" .
                "           };" .
                "           toastr." . $alert[0] . "('" . $alert[2] . "','" . $alert[1] . "',config);" .
                "        });" .
                "</script>";
        }
    }catch (Exception $ex){
    }
}

////////////////////////////////////////////////////
/// Security
////////////////////////////////////////////////////

function generatePassword($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_!@#$%&*()-+{[]}';
    $count = mb_strlen($chars);
    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = Rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }
    return $result;
}

////////////////////////////////////////////////////
/// Others
////////////////////////////////////////////////////

function now_db() {
    $unixdatetime = time();
    return strftime("%Y-%m-%d %H:%M:%S", $unixdatetime);
}

function escape_value($value='') {
    $value = strip_tags(htmlentities($value));
    return filter_var($value, FILTER_SANITIZE_STRING);
}

function escape_only($value='') {
    $value = strip_tags(htmlentities($value), '<b><i><u><p><a><img>');
    return filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
}

function unescape($value='') {
    return html_entity_decode($value,null,'UTF-8');;
}

function redirect_to( $location = NULL ) {
    if ($location != NULL) {
        header("Location: {$location}");
        exit;
    }
}

function momentDateJS() {
    $format = session()->get('settings')['default_date_format'];
    switch ($format) {
        case "Y-m-d":
            return "YYYY-MM-DD";
        case "d-m-Y":
            return "DD-MM-YYYY";
        case "d/m/Y":
            return "DD/MM/YYYY";
        case "m-d-Y":
            return "MM-DD-YYYY";
        case "m/d/Y":
            return "MM/DD/YYYY";
        default:
            return "";
    }
}

function momentDateTimeJS() {
    $format = session()->get('settings')['default_date_format'];
    switch ($format) {
        case "Y-m-d":
            return "YYYY-MM-DD HH:mm:ss";
        case "d-m-Y":
            return "DD-MM-YYYY HH:mm:ss";
        case "d/m/Y":
            return "DD/MM/YYYY HH:mm:ss";
        case "m-d-Y":
            return "MM-DD-YYYY HH:mm:ss";
        case "m/d/Y":
            return "MM/DD/YYYY HH:mm:ss";
        default:
            return "";
    }
}

function dateFormatWeb($date) {
    $format = session()->get('settings')['default_date_format'];
    switch ($format) {
        case "Y-m-d":
            return $date;
        case "d-m-Y":
        case "d/m/Y":
        case "m-d-Y":
        case "m/d/Y":
            $phpDate = strtotime($date);
            if(strlen($date) > 10){
                return date( $format.' H:i:s', $phpDate);
            }else{
                return date( $format, $phpDate);
            }
        default:
            return null;
    }
}

function dateFormatMysql($date) {
    $format = session()->get('settings')['default_date_format'];
    switch ($format) {
        case "Y-m-d":
            return $date;
        case "d-m-Y":
            $dateTimeSplit = explode(' ',$date);
            $dateSplit = explode('-',$dateTimeSplit[0]);
            if(count($dateTimeSplit) > 1){
                return $dateSplit[2].'-'.$dateSplit[1].'-'.$dateSplit[0].' '. $dateTimeSplit[1];
            }else{
                return $dateSplit[2].'-'.$dateSplit[1].'-'.$dateSplit[0];
            }
        case "d/m/Y":
            $dateTimeSplit = explode(' ',$date);
            $dateSplit = explode('/',$dateTimeSplit[0]);
            if(count($dateTimeSplit) > 1){
                return $dateSplit[2].'-'.$dateSplit[1].'-'.$dateSplit[0].' '. $dateTimeSplit[1];
            }else{
                return $dateSplit[2].'-'.$dateSplit[1].'-'.$dateSplit[0];
            }
        case "m-d-Y":
            $dateTimeSplit = explode(' ',$date);
            $dateSplit = explode('-',$dateTimeSplit[0]);
            if(count($dateTimeSplit) > 1){
                return $dateSplit[2].'-'.$dateSplit[0].'-'.$dateSplit[1].' '. $dateTimeSplit[1];
            }else{
                return $dateSplit[2].'-'.$dateSplit[0].'-'.$dateSplit[1];
            }
        case "m/d/Y":
            $dateTimeSplit = explode(' ',$date);
            $dateSplit = explode('/',$dateTimeSplit[0]);
            if(count($dateTimeSplit) > 1){
                return $dateSplit[2].'-'.$dateSplit[0].'-'.$dateSplit[1].' '. $dateTimeSplit[1];
            }else {
                return $dateSplit[2] . '-' . $dateSplit[0] . '-' . $dateSplit[1];
            }
        default:
            return null;
    }
}

function langJS() {
    $lang = session()->get('lang')??'en';
    switch ($lang) {
        case "pt":
            return "pt-br";
        default:
            return $lang;
    }
}

function socialBG() {
    return  [
        "facebook" => "bg-facebook",
        "linkedin" => "bg-linkedin",
        "google" => "bg-google-plus",
        "youtube" => "bg-youtube",
        "twitter" => "bg-twitter",
        "instagram" => "bg-instagram",
        "tiktok" => "bg-tiktok",
        "whatsapp" => "bg-whatsapp",
        "website" => "bg-website",
        "api" => "bg-api",
        "github" => "bg-github",
        "slack" => "bg-slack",
        "spotify" => "btn-spotify",
        "reddit" => "btn-reddit",
        "discord" => "btn-discord",
        "dribbble" => "btn-dribbble",
        "dropbox" => "btn-dropbox",
        "gitlab" => "btn-gitlab",
        "tumblr" => "btn-tumblr",
        "strava" => "btn-strava",
        "twitch" => "btn-twitch",
        "vkontakte" => "btn-vk",
        "wordpress" => "btn-wordpress",
        "yahoo" => "btn-yahoo",
        "bitbucket" => "btn-bitbucket",
        "wechat" => "btn-wechat",
    ];
}
function keywordEmail() {
    return [
        'user_first_name',
        'user_last_name',
        'user_date_birth',
        'user_address',
        'user_city',
        'user_state',
        'user_country',
        'user_zip_code',
        'user_mobile',
        'user_email',
        'user_picture'
    ];
}

function templateSelect($templates=[],$name='',$type='') {
    foreach ($templates as $item){
            if($item['type'] == $type){
                if($item['name'] == $name){
                    return $item;
                }
            }
    }
    return null;
}

function version() {
    return "1.3.5";
}

function delTree($dir) {
    $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}