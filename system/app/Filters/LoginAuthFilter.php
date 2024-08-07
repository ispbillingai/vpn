<?php
namespace App\Filters;

use App\Models\SettingsModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class LoginAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        try {
            if(!$this->validateIgnoreControllerAccess()){
                $session = session();
                $token = $session->get('token')??'';
                $tfa = $session->get('tfa')??false;
    
                $this->getSettings();
    
                if (empty($token) || $tfa == true) {
                    return redirect()->to('/login');
                }else{
                    $this->validateControllerAccess();
                }
            }
        } catch (Exception $e) {

        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }

    /**
     * Access to controllers is valid.
     */
    public function validateControllerAccess(){
        $request = \Config\Services::request();
        $uri = $request->uri;

        $language = \Config\Services::language();
        $language->setLocale(session()->lang);

        //White List
        $getWhiteList = $this->whiteListController();
        foreach ($getWhiteList as $item){
            if(strtolower($item) == $uri->getSegment(1)){
                return true;
            }
        }

        //Module List
        $module = $this->modules($uri->getSegment(1));
        if($module != null){
            if (in_array(session()->get('group'), $module)) {
                return true;
            }
        }

        $getRules = json_decode(session()->get('rules')??'[]');

        foreach ($this->whiteListMethod() as $item){
            if(strtolower($item) == $uri->getSegment(2)){
                return true;
            }
        }

        foreach ($getRules as $key=>$value){
            if(strtolower($key) == $uri->getSegment(1)){
                if($uri->getTotalSegments() <= 1){
                    return true;
                }
                foreach ($value as $item){
                    if(strtolower($item) == $uri->getSegment(2)){
                        return true;
                    }
                }
            }
        }
        session()->setFlashdata('sweet', ['error',lang("App.dashboard_alert_rules")]);
        header('Location: /dashboard');
        exit();
    }

    /**
     * Returns the white list of allowed controllers.
     */
    public function whiteListController(){
        return [
            '',
            'BaseController',
            'Dashboard',
            'Login',
            'Oauth',
            'Language',
            'Api',
            'Cron',
            'lang',
            'Ajax',
            'Integration',
            'Site',
        ];
    }

    /**
     * Returns the whitelist of public controllers.
     */
    public function ignoreListController(){
        return [
            '',
            'site',
        ];
    }

    public function validateIgnoreControllerAccess(){
        $request = \Config\Services::request();
        $uri = $request->uri;
        $getList = $this->ignoreListController();
        foreach ($getList as $item){
            if(strtolower($item) == $uri->getSegment(1)){
                return true;
            }
        }
        return false;
    }

    public function whiteListMethod(){
        return [
            'initController',
            '__construct',
            'validateControllerAccess',
            'whiteListController',
            'whiteListMethod'
        ];
    }

    public function getSettings(){
        // Get Settings
        $session = session();
        $settingsBase = new SettingsModel();
        $settings = $settingsBase->first()??[];
        $session->set('settings', $settings);
        if(empty($session->get('lang'))) {
            $session->set('lang', $settings['default_language'] ?? 'en');
        }
    }

    private function modules($name) {
        if(file_exists(APPPATH . "Modules/Modules.json")){
            $mods = file_get_contents(APPPATH . "Modules/Modules.json");
            $mods = @json_decode($mods);
            if (!($mods && is_array($mods) && count($mods))) {
                return [];
            }
            foreach ($mods as $item) {
                if(strtoupper($item->directory) == strtoupper($name)){
                    return $item->rules;
                }
            }
            return [];
        }
        return [];
    }
}