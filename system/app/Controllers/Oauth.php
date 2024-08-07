<?php
namespace App\Controllers;

use App\Libraries\PasswordHash;
use App\Models\SettingsModel;
use App\Models\SettingsOauthModel;
use App\Models\UserOauthModel;
use App\Models\UserModel;

class Oauth extends BaseController
{
    private $user_model;
    private $oauth_model;
    private $user_oauth_model;

    function __construct()
    {
        $this->user_model = new UserModel();
        $this->oauth_model = new SettingsOauthModel();
        $this->user_oauth_model = new UserOauthModel();
    }

    public function index()
    {
        return redirect()->to('/login');
    }

    private function validation($userProfile,$provider)
    {
        $session = session();
        helper('text');
        if($user = $this->user_model->select('id_user,token')->where('email', $userProfile->email)->first())
        {
            $userProvider = $this->user_oauth_model->where('provider', $provider)->where('identifier', $userProfile->identifier)->countAllResults();
            if($userProvider == 0){
                $this->user_oauth_model->save([
                    'user' =>  $user['token'],
                    'provider' => $provider,
                    'identifier' => $userProfile->identifier??'',
                    'picture' => $userProfile->photoURL??''
                ]);
            }
        }else{
            if(empty($session->get('settings'))){
                $settingsBase = new SettingsModel();
                $settings = $settingsBase->first()??[];
                $session->set('settings', $settings);
            }
            $phpass = new PasswordHash(8, true);
            $pass = random_string("alnum", 15);
            $token = md5(uniqid(rand(), true));
            $this->user_model->save([
                "group" => $session->get('settings')['default_role'],
                "first_name" => $userProfile->firstName??$userProfile->displayName??'',
                "last_name" => $userProfile->lastName??'',
                "email" => $userProfile->email??'',
                "picture" => $userProfile->photoURL??'/assets/img/default-user.png',
                "language" => $session->get('settings')['default_language'],
                'password' => $phpass->HashPassword($pass),
                "token" => $token,
                "email_confirmed" => true,
                "status" => true
            ]);
            $this->user_oauth_model->save([
                'user' => $token,
                'provider' => $provider,
                'identifier' => $userProfile->identifier??'',
                'picture' => $userProfile->photoURL??''
            ]);
        }
        $session->set('oauth',$userProfile);
    }

    public function twitter()
    {
        $providerName = 'twitter';
        $provider = $this->oauth_model->where('provider',$providerName)->first();
        $config = [
            'callback' => base_url().'/oauth/'.$providerName,
            'keys' => [
                'key' => $provider['key']??'',
                'secret' => $provider['secret']??'',
            ],
        ];
        try {
            $oauth = new \Hybridauth\Provider\Twitter($config);
            $oauth->authenticate();
            if($userProfile = $oauth->getUserProfile()){
                $this->validation($userProfile,$providerName);
                return redirect()->to('/login/authenticate');
            }
        }
        catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }
    }

    public function facebook()
    {
        $providerName = 'facebook';
        $provider = $this->oauth_model->where('provider',$providerName)->first();
        $config = [
            'callback' => base_url().'/oauth/'.$providerName,
            'keys' => [
                'id' => $provider['key']??'',
                'secret' => $provider['secret']??'',
            ],
        ];
        try {
            $oauth = new \Hybridauth\Provider\Facebook($config);
            $oauth->authenticate();
            if($userProfile = $oauth->getUserProfile()){
                $this->validation($userProfile,$providerName);
                return redirect()->to('/login/authenticate');
            }
        }
        catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }
    }

    public function google()
    {
        $providerName = 'google';
        $provider = $this->oauth_model->where('provider',$providerName)->first();
        $config = [
            'callback' => base_url().'/oauth/'.$providerName,
            'keys' => [
                'id' => $provider['key']??'',
                'secret' => $provider['secret']??'',
            ],
        ];
        try {
            $oauth = new \Hybridauth\Provider\Google($config);
            $oauth->authenticate();
            if($userProfile = $oauth->getUserProfile()){
                $this->validation($userProfile,$providerName);
                return redirect()->to('/login/authenticate');
            }
        }
        catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }
    }

    public function linkedin()
    {
        $providerName = 'linkedin';
        $provider = $this->oauth_model->where('provider',$providerName)->first();
        $config = [
            'callback' => base_url().'/oauth/'.$providerName,
            'keys' => [
                'id' => $provider['key']??'',
                'secret' => $provider['secret']??'',
            ],
        ];
        try {
            $oauth = new \Hybridauth\Provider\LinkedIn($config);
            $oauth->authenticate();
            if($userProfile = $oauth->getUserProfile()){
                $this->validation($userProfile,$providerName);
                return redirect()->to('/login/authenticate');
            }
        }
        catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }
    }

    public function github()
    {
        $providerName = 'github';
        $provider = $this->oauth_model->where('provider',$providerName)->first();
        $config = [
            'callback' => base_url().'/oauth/'.$providerName,
            'keys' => [
                'id' => $provider['key']??'',
                'secret' => $provider['secret']??'',
            ],
        ];
        try {
            $oauth = new \Hybridauth\Provider\GitHub($config);
            $oauth->authenticate();
            if($userProfile = $oauth->getUserProfile()){
                $this->validation($userProfile,$providerName);
                return redirect()->to('/login/authenticate');
            }
        }
        catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }
    }

    public function instagram()
    {
        $providerName = 'instagram';
        $provider = $this->oauth_model->where('provider',$providerName)->first();
        $config = [
            'callback' => base_url().'/oauth/'.$providerName,
            'keys' => [
                'id' => $provider['key']??'',
                'secret' => $provider['secret']??'',
            ],
        ];
        try {
            $oauth = new \Hybridauth\Provider\Instagram($config);
            $oauth->authenticate();
            if($userProfile = $oauth->getUserProfile()){
                $this->validation($userProfile,$providerName);
                return redirect()->to('/login/authenticate');
            }
        }
        catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }
    }

    public function slack()
    {
        $providerName = 'slack';
        $provider = $this->oauth_model->where('provider',$providerName)->first();
        $config = [
            'callback' => base_url().'/oauth/'.$providerName,
            'keys' => [
                'id' => $provider['key']??'',
                'secret' => $provider['secret']??'',
            ],
        ];
        try {
            $oauth = new \Hybridauth\Provider\Slack($config);
            $oauth->authenticate();
            if($userProfile = $oauth->getUserProfile()){
                $this->validation($userProfile,$providerName);
                return redirect()->to('/login/authenticate');
            }
        }
        catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }
    }

    public function spotify()
    {
        $providerName = 'spotify';
        $provider = $this->oauth_model->where('provider',$providerName)->first();
        $config = [
            'callback' => base_url().'/oauth/'.$providerName,
            'keys' => [
                'id' => $provider['key']??'',
                'secret' => $provider['secret']??'',
            ],
        ];
        try {
            $oauth = new \Hybridauth\Provider\Spotify($config);
            $oauth->authenticate();
            if($userProfile = $oauth->getUserProfile()){
                $this->validation($userProfile,$providerName);
                return redirect()->to('/login/authenticate');
            }
        }
        catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }
    }

    public function reddit()
    {
        $providerName = 'reddit';
        $provider = $this->oauth_model->where('provider',$providerName)->first();
        $config = [
            'callback' => base_url().'/oauth/'.$providerName,
            'keys' => [
                'id' => $provider['key']??'',
                'secret' => $provider['secret']??'',
            ],
        ];
        try {
            $oauth = new \Hybridauth\Provider\Reddit($config);
            $oauth->authenticate();
            if($userProfile = $oauth->getUserProfile()){
                $this->validation($userProfile,$providerName);
                return redirect()->to('/login/authenticate');
            }
        }
        catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }
    }

    public function discord()
    {
        $providerName = 'discord';
        $provider = $this->oauth_model->where('provider',$providerName)->first();
        $config = [
            'callback' => base_url().'/oauth/'.$providerName,
            'keys' => [
                'id' => $provider['key']??'',
                'secret' => $provider['secret']??'',
            ],
        ];
        try {
            $oauth = new \Hybridauth\Provider\Discord($config);
            $oauth->authenticate();
            if($userProfile = $oauth->getUserProfile()){
                $this->validation($userProfile,$providerName);
                return redirect()->to('/login/authenticate');
            }
        }
        catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }
    }

    public function dribbble()
    {
        $providerName = 'dribbble';
        $provider = $this->oauth_model->where('provider',$providerName)->first();
        $config = [
            'callback' => base_url().'/oauth/'.$providerName,
            'keys' => [
                'id' => $provider['key']??'',
                'secret' => $provider['secret']??'',
            ],
        ];
        try {
            $oauth = new \Hybridauth\Provider\Dribbble($config);
            $oauth->authenticate();
            if($userProfile = $oauth->getUserProfile()){
                $this->validation($userProfile,$providerName);
                return redirect()->to('/login/authenticate');
            }
        }
        catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }
    }

    public function dropbox()
    {
        $providerName = 'dropbox';
        $provider = $this->oauth_model->where('provider',$providerName)->first();
        $config = [
            'callback' => base_url().'/oauth/'.$providerName,
            'keys' => [
                'id' => $provider['key']??'',
                'secret' => $provider['secret']??'',
            ],
        ];
        try {
            $oauth = new \Hybridauth\Provider\Dropbox($config);
            $oauth->authenticate();
            if($userProfile = $oauth->getUserProfile()){
                $this->validation($userProfile,$providerName);
                return redirect()->to('/login/authenticate');
            }
        }
        catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }
    }

    public function gitlab()
    {
        $providerName = 'gitlab';
        $provider = $this->oauth_model->where('provider',$providerName)->first();
        $config = [
            'callback' => base_url().'/oauth/'.$providerName,
            'keys' => [
                'id' => $provider['key']??'',
                'secret' => $provider['secret']??'',
            ],
        ];
        try {
            $oauth = new \Hybridauth\Provider\GitLab($config);
            $oauth->authenticate();
            if($userProfile = $oauth->getUserProfile()){
                $this->validation($userProfile,$providerName);
                return redirect()->to('/login/authenticate');
            }
        }
        catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }
    }

    public function strava()
    {
        $providerName = 'strava';
        $provider = $this->oauth_model->where('provider',$providerName)->first();
        $config = [
            'callback' => base_url().'/oauth/'.$providerName,
            'keys' => [
                'id' => $provider['key']??'',
                'secret' => $provider['secret']??'',
            ],
        ];
        try {
            $oauth = new \Hybridauth\Provider\Strava($config);
            $oauth->authenticate();
            if($userProfile = $oauth->getUserProfile()){
                $this->validation($userProfile,$providerName);
                return redirect()->to('/login/authenticate');
            }
        }
        catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }
    }

    public function tumblr()
    {
        $providerName = 'tumblr';
        $provider = $this->oauth_model->where('provider',$providerName)->first();
        $config = [
            'callback' => base_url().'/oauth/'.$providerName,
            'keys' => [
                'id' => $provider['key']??'',
                'secret' => $provider['secret']??'',
            ],
        ];
        try {
            $oauth = new \Hybridauth\Provider\Tumblr($config);
            $oauth->authenticate();
            if($userProfile = $oauth->getUserProfile()){
                $this->validation($userProfile,$providerName);
                return redirect()->to('/login/authenticate');
            }
        }
        catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }
    }

    public function twitch()
    {
        $providerName = 'twitch';
        $provider = $this->oauth_model->where('provider',$providerName)->first();
        $config = [
            'callback' => base_url().'/oauth/'.$providerName,
            'keys' => [
                'id' => $provider['key']??'',
                'secret' => $provider['secret']??'',
            ],
        ];
        try {
            $oauth = new \Hybridauth\Provider\TwitchTV($config);
            $oauth->authenticate();
            if($userProfile = $oauth->getUserProfile()){
                $this->validation($userProfile,$providerName);
                return redirect()->to('/login/authenticate');
            }
        }
        catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }
    }

    public function vkontakte()
    {
        $providerName = 'vkontakte';
        $provider = $this->oauth_model->where('provider',$providerName)->first();
        $config = [
            'callback' => base_url().'/oauth/'.$providerName,
            'keys' => [
                'id' => $provider['key']??'',
                'secret' => $provider['secret']??'',
            ],
        ];
        try {
            $oauth = new \Hybridauth\Provider\Vkontakte($config);
            $oauth->authenticate();
            if($userProfile = $oauth->getUserProfile()){
                $this->validation($userProfile,$providerName);
                return redirect()->to('/login/authenticate');
            }
        }
        catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }
    }

    public function wordpress()
    {
        $providerName = 'wordpress';
        $provider = $this->oauth_model->where('provider',$providerName)->first();
        $config = [
            'callback' => base_url().'/oauth/'.$providerName,
            'keys' => [
                'id' => $provider['key']??'',
                'secret' => $provider['secret']??'',
            ],
        ];
        try {
            $oauth = new \Hybridauth\Provider\WordPress($config);
            $oauth->authenticate();
            if($userProfile = $oauth->getUserProfile()){
                $this->validation($userProfile,$providerName);
                return redirect()->to('/login/authenticate');
            }
        }
        catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }
    }

    public function yahoo()
    {
        $providerName = 'yahoo';
        $provider = $this->oauth_model->where('provider',$providerName)->first();
        $config = [
            'callback' => base_url().'/oauth/'.$providerName,
            'keys' => [
                'id' => $provider['key']??'',
                'secret' => $provider['secret']??'',
            ],
        ];
        try {
            $oauth = new \Hybridauth\Provider\Yahoo($config);
            $oauth->authenticate();
            if($userProfile = $oauth->getUserProfile()){
                $this->validation($userProfile,$providerName);
                return redirect()->to('/login/authenticate');
            }
        }
        catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }
    }

    public function bitbucket()
    {
        $providerName = 'bitbucket';
        $provider = $this->oauth_model->where('provider',$providerName)->first();
        $config = [
            'callback' => base_url().'/oauth/'.$providerName,
            'keys' => [
                'id' => $provider['key']??'',
                'secret' => $provider['secret']??'',
            ],
        ];
        try {
            $oauth = new \Hybridauth\Provider\BitBucket($config);
            $oauth->authenticate();
            if($userProfile = $oauth->getUserProfile()){
                $this->validation($userProfile,$providerName);
                return redirect()->to('/login/authenticate');
            }
        }
        catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }
    }

    public function wechat()
    {
        $providerName = 'wechat';
        $provider = $this->oauth_model->where('provider',$providerName)->first();
        $config = [
            'callback' => base_url().'/oauth/'.$providerName,
            'keys' => [
                'id' => $provider['key']??'',
                'secret' => $provider['secret']??'',
            ],
        ];
        try {
            $oauth = new \Hybridauth\Provider\WeChat($config);
            $oauth->authenticate();
            if($userProfile = $oauth->getUserProfile()){
                $this->validation($userProfile,$providerName);
                return redirect()->to('/login/authenticate');
            }
        }
        catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }
    }
}
