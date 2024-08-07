<?php

namespace App\Controllers;

use App\Models\CronTabModel;
use App\Models\NotificationModel;
use App\Models\UserModel;
use App\Models\UserGroupModel;
use App\Models\ActivityModel;
use CodeIgniter\RESTful\ResourceController;

class Ajax extends ResourceController
{
    private $user_model;
    private $group_model;
    private $activity_model;
    private $crontab_model;
    private $notification_model;
    private $id_user;
    private $token_user;

    function __construct()
    {
        $this->user_model = new UserModel();
        $this->group_model = new UserGroupModel();
        $this->activity_model = new ActivityModel();
        $this->crontab_model = new CronTabModel();
        $this->notification_model = new NotificationModel();
        $this->id_user = session()->get('id_user');
        $this->token_user = session()->get('token');
        $language = \Config\Services::language();
        $language->setLocale(session()->lang);
    }

    public function index()
    {
        return redirect()->to('/home');
    }

    public function getUsers(){
        $postData = service('request')->getVar();
        if($postData != null && isset($postData->data)){
            $dtpostData = $postData->data;

            //Read value
            $draw = $dtpostData->draw;
            $start = $dtpostData->start;
            $rowperpage = $dtpostData->length; // Rows display per page
            $columnIndex = $dtpostData->order[0]->column; // Column index
            $columnName = $dtpostData->columns[$columnIndex]->data; // Column name
            $columnSortOrder = $dtpostData->order[0]->dir; // asc or desc
            $searchValue = $dtpostData->search->value; // Search value

            //Total number of records without filtering
            $totalRecords = $this->user_model->select('id_user')
                ->join('user_group','user_group.token = user.group')
                ->countAllResults();

            //Total number of records with filtering
            $totalRecordwithFilter = $this->user_model->select('id_user')
                ->join('user_group','user_group.token = user.group')
                ->orLike('first_name', $searchValue)
                ->orLike('email', $searchValue)
                ->countAllResults();

            //Fetch records
            $records = $this->user_model->select('user.*,user_group.title')
                ->join('user_group','user_group.token = user.group')
                ->orLike('first_name', $searchValue)
                ->orLike('email', $searchValue)
                ->orderBy($columnName,$columnSortOrder)
                ->findAll($rowperpage, $start);

            //Format records
            foreach ($records as $key => $value){
                if($records[$key]['email_confirmed'] == 1){
                    $records[$key]['email'] = $records[$key]['email'].' '.'<span class="text-success"><i class="fas fa-check-circle"></i></span>';
                }
                if($records[$key]['sms_confirmed'] == 1){
                    $records[$key]['mobile'] = $records[$key]['mobile'].' '.'<span class="text-success"><i class="fas fa-check-circle"></i></span>';
                }
                $editLink = site_url('user/edit/').$records[$key]['token'];
                $records[$key]['options'] = ''.
                    '<div class="btn-group mr-1 mb-1" xmlns="http://www.w3.org/1999/html">
                    <button type="button" class="btn btn-primary btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        '.lang("App.user_grid_options").'
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="'.$editLink.'"><i class="fas fa-edit"></i> '.lang("App.user_btn_edit").'</a>
                        <button type="button" class="dropdown-item" onclick="delete_user(\''.$records[$key]['token'].'\');"><i class="fas fa-trash"></i> '.lang("App.user_btn_delete").'</button>
                    </div>
                 </div>
				';
            }

            //Data records
            $data = array();
            foreach($records as $record ){
                $data[] = array(
                    "first_name"=>$record['first_name'],
                    "email"=>$record['email'],
                    "group"=>$record['title'],
                    "mobile"=>$record['mobile'],
                    "last_access"=>$record['last_access'],
                    "last_ip"=>$record['last_ip'],
                    "created_at"=>$record['created_at'],
                    "options"=>$record['options']
                );
            }

            //Response
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data,
                "token" => csrf_hash() // New token hash
            );
            return $this->response->setJSON($response);
        }else{
            return $this->response->setJSON(["error"=>true]);
        }
    }

    public function getGroups(){
        $postData = service('request')->getVar();
        if($postData != null && isset($postData->data)){
            $dtpostData = $postData->data;

            //Read value
            $draw = $dtpostData->draw;
            $start = $dtpostData->start;
            $rowperpage = $dtpostData->length; // Rows display per page
            $columnIndex = $dtpostData->order[0]->column; // Column index
            $columnName = $dtpostData->columns[$columnIndex]->data; // Column name
            $columnSortOrder = $dtpostData->order[0]->dir; // asc or desc
            $searchValue = $dtpostData->search->value; // Search value

            //Total number of records without filtering
            $totalRecords = $this->group_model->select('id_group')
                ->countAllResults();

            //Total number of records with filtering
            $totalRecordwithFilter = $this->group_model->select('id_group')
                ->orLike('title', $searchValue)
                ->countAllResults();

            //Fetch records
            $records = $this->group_model->select('*')
                ->orLike('title', $searchValue)
                ->orderBy($columnName,$columnSortOrder)
                ->findAll($rowperpage, $start);

            //Format records
            foreach ($records as $key => $value){
                $editLink = site_url('group/edit/').$records[$key]['token'];
                $records[$key]['options'] = ''.
                    '<div class="btn-group mr-1 mb-1" xmlns="http://www.w3.org/1999/html">
                    <button type="button" class="btn btn-primary btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        '.lang("App.group_grid_options").'
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="'.$editLink.'"><i class="fas fa-edit"></i>'.lang("App.group_btn_edit").'</a>
                        <button type="button" class="dropdown-item" onclick="delete_group(\''.$records[$key]['token'].'\');"><i class="fas fa-trash"></i> '.lang("App.group_btn_delete").'</button>
                    </div>
                 </div>
				';
            }

            //Data records
            $data = array();
            foreach($records as $record ){
                $data[] = array(
                    "title"=>$record['title'],
                    "dashboard"=>$record['dashboard'],
                    "created_at"=>$record['created_at'],
                    "updated_at"=>$record['updated_at'],
                    "options"=>$record['options']
                );
            }

            //Response
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data,
                "token" => csrf_hash() // New token hash
            );
            return $this->response->setJSON($response);
        }else{
            return $this->response->setJSON(["error"=>true]);
        }
    }

    public function getActivities($all=""){
        $postData = service('request')->getVar();
        if($postData != null && isset($postData->data)){
            $dtpostData = $postData->data;

            //Read value
            $draw = $dtpostData->draw;
            $start = $dtpostData->start;
            $rowperpage = $dtpostData->length; // Rows display per page
            $columnIndex = $dtpostData->order[0]->column; // Column index
            $columnName = $dtpostData->columns[$columnIndex]->data; // Column name
            $columnSortOrder = $dtpostData->order[0]->dir; // asc or desc
            $searchValue = $dtpostData->search->value; // Search value

            $session = session();

            //Total number of records without filtering
            if($session->get('dashboard')=='admin' && !empty($all)){
                $totalRecords = $this->activity_model->select('id_activity')
                    ->join('user','user.token = activity.user')
                    ->countAllResults();
            }else{
                $totalRecords = $this->activity_model->select('id_activity')
                    ->join('user','user.token = activity.user')
                    ->where('activity.user',$session->get('token'))
                    ->countAllResults();
            }

            //Total number of records with filtering
            if($session->get('dashboard')=='admin' && !empty($all)){
                $totalRecordwithFilter = $this->activity_model->select('id_activity')
                    ->join('user','user.token = activity.user')
                    ->orLike('first_name', $searchValue)
                    ->countAllResults();
            }else{
                $totalRecordwithFilter = $this->activity_model->select('id_activity')
                    ->join('user','user.token = activity.user')
                    ->orLike('first_name', $searchValue)
                    ->where('activity.user',$session->get('token'))
                    ->countAllResults();
            }

            //Fetch records
            if($session->get('dashboard')=='admin' && !empty($all)){
                $records = $this->activity_model->select('activity.*,concat(first_name, " (",email, ")") AS name')
                    ->join('user','user.token = activity.user')
                    ->orLike('first_name', $searchValue)
                    ->orderBy($columnName,$columnSortOrder)
                    ->findAll($rowperpage, $start);
            }else{
                $records = $this->activity_model->select('activity.*,concat(first_name, " (",email, ")") AS name')
                    ->join('user','user.token = activity.user')
                    ->orLike('first_name', $searchValue)
                    ->where('activity.user',$session->get('token'))
                    ->orderBy($columnName,$columnSortOrder)
                    ->findAll($rowperpage, $start);
            }


            //Data records
            $data = array();
            foreach($records as $record ){
                $data[] = array(
                    "name"=>$record['name'],
                    "level"=>$record['level'],
                    "event"=>$record['event'],
                    "ip"=>$record['ip'],
                    "os"=>$record['os'],
                    "browser"=>$record['browser'],
                    "created_at"=>$record['created_at']
                );
            }

            //Response
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data,
                "token" => csrf_hash() // New token hash
            );
            return $this->response->setJSON($response);
        }else{
            return $this->response->setJSON(["error"=>true]);
        }
    }

    public function getCronHistory(){
        $postData = service('request')->getVar();
        if($postData != null && isset($postData->data)){
            $dtpostData = $postData->data;

            //Read value
            $draw = $dtpostData->draw;
            $start = $dtpostData->start;
            $rowperpage = $dtpostData->length; // Rows display per page
            $columnIndex = $dtpostData->order[0]->column; // Column index
            $columnName = $dtpostData->columns[$columnIndex]->data; // Column name
            $columnSortOrder = $dtpostData->order[0]->dir; // asc or desc
            $searchValue = $dtpostData->search->value; // Search value

            //Total number of records without filtering
            $totalRecords = $this->crontab_model->select('id_crontab')
                ->countAllResults();

            //Total number of records with filtering
            $totalRecordwithFilter = $this->crontab_model->select('id_crontab')
                ->orLike('routine', $searchValue)
                ->orLike('error', $searchValue)
                ->countAllResults();

            //Fetch records
            $records = $this->crontab_model->select('*')
                ->orLike('routine', $searchValue)
                ->orLike('error', $searchValue)
                ->orderBy($columnName,$columnSortOrder)
                ->findAll($rowperpage, $start);

            //Data records
            $data = array();
            foreach($records as $record ){
                $data[] = array(
                    "routine"=>$record['routine'],
                    "error"=>$record['error'],
                    "created_at"=>$record['created_at']
                );
            }

            //Response
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data,
                "token" => csrf_hash() // New token hash
            );
            return $this->response->setJSON($response);
        }else{
            return $this->response->setJSON(["error"=>true]);
        }
    }

    public function getNotification(){
        $postData = service('request')->getVar();
        if($postData != null && isset($postData->data)){
            $dtpostData = $postData->data;

            //Read value
            $draw = $dtpostData->draw;
            $start = $dtpostData->start;
            $rowperpage = $dtpostData->length; // Rows display per page
            $columnIndex = $dtpostData->order[0]->column; // Column index
            $columnName = $dtpostData->columns[$columnIndex]->data; // Column name
            $columnSortOrder = $dtpostData->order[0]->dir; // asc or desc
            $searchValue = $dtpostData->search->value; // Search value

            //Total number of records without filtering
            $totalRecords = $this->notification_model->select('id_notification')
                ->join('user AS sender','notification.user_sender = sender.token','left')
                ->join('user AS recipient','notification.user_recipient = recipient.token','left')
                ->countAllResults();

            //Total number of records with filtering
            $totalRecordwithFilter = $this->notification_model->select('id_notification')
                ->join('user AS sender','notification.user_sender = sender.token','left')
                ->join('user AS recipient','notification.user_recipient = recipient.token','left')
                ->orLike('title', $searchValue)
                ->orLike('sender.first_name', $searchValue)
                ->orLike('recipient.first_name', $searchValue)
                ->countAllResults();

            //Fetch records
            $records = $this->notification_model->select('notification.token, sender.first_name AS sender, recipient.first_name AS recipient, notification.title, is_send_email, is_send_sms, is_read, notification.created_at')
                ->join('user AS sender','notification.user_sender = sender.token','left')
                ->join('user AS recipient','notification.user_recipient = recipient.token','left')
                ->orLike('title', $searchValue)
                ->orLike('sender.first_name', $searchValue)
                ->orLike('recipient.first_name', $searchValue)
                ->orderBy($columnName,$columnSortOrder)
                ->findAll($rowperpage, $start);

            //Format records
            foreach ($records as $key => $value){
                $records[$key]['options'] = ''.
                    '<div class="btn-group mr-1 mb-1" xmlns="http://www.w3.org/1999/html">
                    <button type="button" class="btn btn-primary btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        '.lang("App.notification_grid_options").'
                    </button>
                    <div class="dropdown-menu">
                        <button type="button" class="dropdown-item" onclick="delete_this(\''.$records[$key]['token'].'\');"><i class="fas fa-trash"></i> '.lang("App.user_btn_delete").'</button>
                    </div>
                 </div>
				';
            }

            //Data records
            $data = array();
            foreach($records as $record ){
                $data[] = array(
                    "sender"=>$record['sender'],
                    "recipient"=>$record['recipient'],
                    "title"=>$record['title'],
                    "is_send_email"=>$record['is_send_email'],
                    "is_send_sms"=>$record['is_send_sms'],
                    "is_read"=>$record['is_read'],
                    "created_at"=>$record['created_at'],
                    "options"=>$record['options']
                );
            }

            //Response
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data,
                "token" => csrf_hash() // New token hash
            );
            return $this->response->setJSON($response);
        }else{
            return $this->response->setJSON(["error"=>true]);
        }
    }

    public function getMyNotification(){
        $postData = service('request')->getVar();
        if($postData != null && isset($postData->data)){
            $dtpostData = $postData->data;

            //Read value
            $draw = $dtpostData->draw;
            $start = $dtpostData->start;
            $rowperpage = $dtpostData->length; // Rows display per page
            $columnIndex = $dtpostData->order[0]->column; // Column index
            $columnName = $dtpostData->columns[$columnIndex]->data; // Column name
            $columnSortOrder = $dtpostData->order[0]->dir; // asc or desc
            $searchValue = $dtpostData->search->value; // Search value

            //Total number of records without filtering
            $totalRecords = $this->notification_model->select('id_notification')
                ->join('user AS sender','notification.user_sender = sender.token','left')
                ->join('user AS recipient','notification.user_recipient = recipient.token','left')
                ->where('user_recipient',$this->token_user)
                ->countAllResults();

            //Total number of records with filtering
            $totalRecordwithFilter = $this->notification_model->select('id_notification')
                ->join('user AS sender','notification.user_sender = sender.token','left')
                ->join('user AS recipient','notification.user_recipient = recipient.token','left')
                ->orLike('title', $searchValue)
                ->where('user_recipient',$this->token_user)
                ->countAllResults();

            //Fetch records
            $records = $this->notification_model->select('notification.token, sender.first_name AS sender, recipient.first_name AS recipient, notification.title, is_read, notification.created_at')
                ->join('user AS sender','notification.user_sender = sender.token','left')
                ->join('user AS recipient','notification.user_recipient = recipient.token','left')
                ->orLike('title', $searchValue)
                ->where('user_recipient',$this->token_user)
                ->orderBy($columnName,$columnSortOrder)
                ->findAll($rowperpage, $start);

            //Format records
            foreach ($records as $key => $value){
                $records[$key]['options'] = '<a class="btn btn-primary" href="/my/notification_view/'.$records[$key]['token'].'"><i class="fas fa-eye"></i> '.lang("App.notification_view_btn").'</a>';
            }

            //Data records
            $data = array();
            foreach($records as $record ){
                $data[] = array(
                    "sender"=>$record['sender'],
                    "recipient"=>$record['recipient'],
                    "title"=>$record['title'],
                    "created_at"=>$record['created_at'],
                    "is_read"=>$record['is_read'],
                    "options"=>$record['options']
                );
            }

            //Response
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data,
                "token" => csrf_hash() // New token hash
            );
            return $this->response->setJSON($response);
        }else{
            return $this->response->setJSON(["error"=>true]);
        }
    }
}
