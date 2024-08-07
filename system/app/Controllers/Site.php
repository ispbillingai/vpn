<?php
namespace App\Controllers;

use App\Models\SettingsModel;

class Site extends BaseController
{

    function __construct()
    {
        $session = session();
        $settingsBase = new SettingsModel();
        $settings = $settingsBase->first()??[];
        $session->set('settings', $settings);
        if(!session()->get('settings')['activate_frontend']){
            header('Location: /dashboard');
            die();
        }
    }

    public function index()
    {
        $data = [];
        echo view(getenv('theme.frontend.path').'main/header');
        echo view(getenv('theme.frontend.path').'form/index',$data);
        echo view(getenv('theme.frontend.path').'main/footer');
    }

    public function about()
    {
        $data = [];
        echo view(getenv('theme.frontend.path').'main/header');
        echo view(getenv('theme.frontend.path').'form/about',$data);
        echo view(getenv('theme.frontend.path').'main/footer');
    }

    public function blog_home()
    {
        $data = [];
        echo view(getenv('theme.frontend.path').'main/header');
        echo view(getenv('theme.frontend.path').'form/blog-home',$data);
        echo view(getenv('theme.frontend.path').'main/footer');
    }

    public function blog_post()
    {
        $data = [];
        echo view(getenv('theme.frontend.path').'main/header');
        echo view(getenv('theme.frontend.path').'form/blog-post',$data);
        echo view(getenv('theme.frontend.path').'main/footer');
    }

    public function contact()
    {
        $data = [];
        echo view(getenv('theme.frontend.path').'main/header');
        echo view(getenv('theme.frontend.path').'form/contact',$data);
        echo view(getenv('theme.frontend.path').'main/footer');
    }

    public function faq()
    {
        $data = [];
        echo view(getenv('theme.frontend.path').'main/header');
        echo view(getenv('theme.frontend.path').'form/faq',$data);
        echo view(getenv('theme.frontend.path').'main/footer');
    }

    public function portfolio_item()
    {
        $data = [];
        echo view(getenv('theme.frontend.path').'main/header');
        echo view(getenv('theme.frontend.path').'form/portfolio-item',$data);
        echo view(getenv('theme.frontend.path').'main/footer');
    }

    public function portfolio_overview()
    {
        $data = [];
        echo view(getenv('theme.frontend.path').'main/header');
        echo view(getenv('theme.frontend.path').'form/portfolio-overview',$data);
        echo view(getenv('theme.frontend.path').'main/footer');
    }

    public function pricing()
    {
        $data = [];
        echo view(getenv('theme.frontend.path').'main/header');
        echo view(getenv('theme.frontend.path').'form/pricing',$data);
        echo view(getenv('theme.frontend.path').'main/footer');
    }
}
