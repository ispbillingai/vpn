<?php

namespace App\Controllers;

use App\Models\ActivityModel;
use App\Models\UserModel;
use App\Models\UserOauthModel;

class Dashboard extends BaseController
{
    private $user_model;
    private $oauth_model;
    private $activity_model;

    function __construct()
    {
        $this->user_model = new UserModel();
        $this->oauth_model = new UserOauthModel();
        $this->activity_model = new ActivityModel();
    }

    public function index()
    {

        $session = session();
        $id_user = $session->get('id_user');
        $name = $session->get('first_name');
        $hora = date('H');

        //Salutation
        if( $hora >= 6 && $hora <= 12 )
            $salutation = lang("App.dashboard_good_morning");
        else if ( $hora > 12 && $hora <=18  )
            $salutation = lang("App.dashboard_good_afternoon");
        else
            $salutation = lang("App.dashboard_good_night");

        switch ($session->get('dashboard')):
            case 'admin':
                $data['title'] = [
                    'module' => lang("App.dashboard_hello").' '.$name,
                    'page'   => lang("App.dashboard_indicators"),
                    'icon'  => ''
                ];

                $data['breadcrumb'] = [
                    ['title' => lang("App.menu_dashboard"), 'route' => "", 'active' => true]
                ];

                //Cards Top
                $initialDate = date('Y-m-d H:i:s', strtotime('-1 day', time()));
                $finalDate = date('Y-m-d H:i:s');
                $data['total_user'] = $this->user_model->countAllResults();
                $data['total_new'] = $this->user_model->where('created_at between \''.$initialDate.'\' and \''.$finalDate.'\'')->countAllResults();
                $data['total_enabled'] = $this->user_model->where('status',true)->countAllResults();
                $data['total_disabled'] = $this->user_model->where('status',false)->countAllResults();

                //Char Pie
                $titles_char_pie["labels"] = [];
                $value_char_pie["series"] = [];
                $className = socialBG();
                $return_char_pie = $this->oauth_model->select('provider,COUNT(*) AS total')->groupBy('provider')->findAll();
                foreach ($return_char_pie as $item){
                    array_push($titles_char_pie["labels"],strtoupper($item['provider']));
                    array_push($value_char_pie["series"],["value" => $item['total'],"className" => $className[strtolower($item['provider'])]??'']);
                }
                $data['data_char_pie'] = json_encode(array_merge($titles_char_pie,$value_char_pie));

                //Char Bar
                $titles_char_bar["labels"] = explode(',',lang("App.dashboard_chart_months"));
                $value_char_bar["series"] = [];
                $return_char_bar_geral = $this->user_model->select("DATE_FORMAT(created_at,'%m') AS month,COUNT(DATE_FORMAT(created_at,'%m')) AS total")
                    ->where("DATE_FORMAT(NOW(),'%Y') = DATE_FORMAT(created_at,'%Y')")
                    ->groupBy("DATE_FORMAT(created_at,'%m')")
                    ->findAll();
                $return_char_bar_enabled = $this->user_model->select("DATE_FORMAT(created_at,'%m') AS month,COUNT(DATE_FORMAT(created_at,'%m')) AS total")
                    ->where("DATE_FORMAT(NOW(),'%Y') = DATE_FORMAT(created_at,'%Y') AND status = true")
                    ->groupBy("DATE_FORMAT(created_at,'%m')")
                    ->findAll();
                $return_char_bar_disabled = $this->user_model->select("DATE_FORMAT(updated_at,'%m') AS month,COUNT(DATE_FORMAT(updated_at,'%m')) AS total")
                    ->where("DATE_FORMAT(NOW(),'%Y') = DATE_FORMAT(updated_at,'%Y') AND status = false")
                    ->groupBy("DATE_FORMAT(updated_at,'%m')")
                    ->findAll();
                $year = [];
                for ($i = 1; $i <= 12; $i++) {
                    $notFound = true;
                    foreach ($return_char_bar_geral as $item){
                        if($i == intval($item['month'])){
                            array_push($year,intval($item['total']));
                            $notFound = false;
                            break;
                        }
                    }
                    if($notFound){
                        array_push($year,0);
                    }
                }
                array_push($value_char_bar["series"],$year);
                $year = [];
                for ($i = 1; $i <= 12; $i++) {
                    $notFound = true;
                    foreach ($return_char_bar_enabled as $item){
                        if($i == intval($item['month'])){
                            array_push($year,intval($item['total']));
                            $notFound = false;
                            break;
                        }
                    }
                    if($notFound){
                        array_push($year,0);
                    }
                }
                array_push($value_char_bar["series"],$year);
                $year = [];
                for ($i = 1; $i <= 12; $i++) {
                    $notFound = true;
                    foreach ($return_char_bar_disabled as $item){
                        if($i == intval($item['month'])){
                            array_push($year,intval($item['total']));
                            $notFound = false;
                            break;
                        }
                    }
                    if($notFound){
                        array_push($year,0);
                    }
                }
                array_push($value_char_bar["series"],$year);
                $data['data_char_bar'] = json_encode(array_merge($titles_char_bar,$value_char_bar));

                $data['data_user'] = $this->user_model->select('picture,first_name,last_name,email,created_at')
                    ->orderBy('id_user','DESC')
                    ->findAll(15);

                $data['data_activity'] = $this->activity_model
                    ->select('user.first_name,user.email,activity.detail,activity.created_at')
                    ->join('user','user.token=activity.user')
                    ->orderBy('activity.id_activity','DESC')
                    ->findAll(30);

                echo view(getenv('theme.backend.path').'main/header');
                echo view(getenv('theme.backend.path').'form/dashboard/admin',$data);
                echo view(getenv('theme.backend.path').'main/footer');
                break;

            case 'user':
                $data['title'] = [
                    'module' => lang("App.dashboard_hello").' '.$name,
                    'page'   => lang("App.dashboard_indicators"),
                    'icon'  => ''
                ];

                $data['breadcrumb'] = [
                    ['title' => lang("App.menu_dashboard"), 'route' => "", 'active' => true]
                ];

                echo view(getenv('theme.backend.path').'main/header');
                echo view(getenv('theme.backend.path').'form/dashboard/user',$data);
                echo view(getenv('theme.backend.path').'main/footer');
                break;
            default:
                echo view(getenv('theme.backend.path').'main/header');
                echo view(getenv('theme.backend.path').'form/dashboard/index');
                echo view(getenv('theme.backend.path').'main/footer');
        endswitch;
    }
}
