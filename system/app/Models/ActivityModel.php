<?php
namespace App\Models;

class ActivityModel extends BaseModel
{
    protected $table = 'activity';
    protected $primaryKey = 'id_activity';
    protected $allowedFields = [
        'user',
        'level',
        'event',
        'ip',
        'os',
        'browser',
        'detail'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}