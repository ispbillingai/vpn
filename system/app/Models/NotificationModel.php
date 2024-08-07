<?php
namespace App\Models;

class NotificationModel extends BaseModel
{
    protected $table = 'notification';
    protected $primaryKey = 'id_notification';
    protected $allowedFields = [
        'user_sender',
        'user_recipient',
        'title',
        'body',
        'is_read',
        'is_send_email',
        'is_send_sms',
        'send_email_notification',
        'send_sms_notification',
        'token'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}