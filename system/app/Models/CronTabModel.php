<?php
namespace App\Models;

class CronTabModel extends BaseModel
{
    protected $table = 'crontab_history';
    protected $primaryKey = 'id_crontab';
    protected $allowedFields = [
        'routine',
        'error'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}