<?php

namespace App\Controllers;

use App\Models\ActivityModel;
use App\Models\BackupModel;
use App\Models\CronTabModel;
use App\Models\NotificationModel;
use App\Models\SettingsModel;
use App\Models\UserModel;

class Cron extends BaseController
{
    private $integration;
    private $user_model;
    private $notification_model;
    private $crontab_model;
    private $settings_model;
    private $activity_model;
    private $backup_model;

    function __construct()
    {
        $this->integration = new Integration();
        $this->user_model = new UserModel();
        $this->notification_model = new NotificationModel();
        $this->settings_model = new SettingsModel();
        $this->crontab_model = new CronTabModel();
        $this->activity_model = new ActivityModel();
        $this->backup_model = new BackupModel();
    }

    public function index()
    {
        $settings = $this->settings_model->first()??[];

        // Cron Notification E-mail
        try {
            $email_list = $this->notification_model
                ->select('notification.id_notification, recipient.email, notification.title, notification.body')
                ->join('user AS recipient','notification.user_recipient = recipient.token','left')
                ->where('send_email_notification',true)
                ->where('is_send_email',false)
                ->orderBy('notification.id_notification','desc')
                ->findAll(25);
            foreach ($email_list as $item){
                if($this->integration->send_email($item['email'],$item['title'],$item['body'])){
                    $this->notification_model->save(['id_notification' => $item['id_notification'],'is_send_email' => true]);
                }
            }
        }catch (\Exception $e){
            $this->crontab_model->save(['routine'=>'Notification Email','error'=>$e->getMessage()]);
        }

        // Cron Notification SMS
        try {
            $sms_list = $this->notification_model
                ->select('notification.id_notification, recipient.mobile, recipient.token, notification.title, notification.body')
                ->join('user AS recipient','notification.user_recipient = recipient.token','left')
                ->where('send_sms_notification',true)
                ->where('is_send_sms',false)
                ->orderBy('notification.id_notification','desc')
                ->findAll(25);
            foreach ($sms_list as $item){
                if($this->integration->send_sms($item['mobile'],$item['body'],$item['token'])){
                    $this->notification_model->save(['id_notification' => $item['id_notification'],'is_send_sms' => true]);
                }
            }
        }catch (\Exception $e){
            $this->crontab_model->save(['routine'=>'Notification SMS','error'=>$e->getMessage()]);
        }

        // Cron Backup
        if(date('Y-m-d') > date('Y-m-d',strtotime($settings['backup_latest']))){
            if(date('H:i:s') >= date('H:i:s',strtotime($settings['backup_time']))){
                try {
                    $this->settings_model->save([
                        'id_settings' => $settings['id_settings'],
                        'backup_latest' => date('Y-m-d H:i:s')
                    ]);
                    $this->integration->create_backup();
                }catch (\Exception $e){
                    $this->crontab_model->save(['routine'=>'Backup','error'=>$e->getMessage()]);
                }
            }
        }

        // Cron Log Delete
        if(date('Y-m-d') >= date('Y-m-d',strtotime(date($settings['remove_log_latest']) . ' +'.$settings['remove_log_time'].' day'))){
            try {
                $this->settings_model->save([
                    'id_settings' => $settings['id_settings'],
                    'remove_log_latest' => date('Y-m-d H:i:s')
                ]);
                $dateStart = date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s') . ' -5 year'));
                $dateEnd = date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s') . ' -30 day'));
                $this->crontab_model->where('created_at between "'.$dateStart.'" and "'.$dateEnd.'"')->delete();
                $this->activity_model->where('created_at between "'.$dateStart.'" and "'.$dateEnd.'"')->delete();
                $this->backup_model->where('created_at between "'.$dateStart.'" and "'.$dateEnd.'"')->delete();
            }catch (\Exception $e){
                $this->crontab_model->save(['routine'=>'Delete Log','error'=>$e->getMessage()]);
            }
        }
    }

    public function test()
    {
        $this->integration->send_sms('5566996386300','Olá Eduardo!');
    }

}
