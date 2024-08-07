<?php
namespace App\Models;

class UserGroupModel extends BaseModel
{
    protected $table = 'user_group';
    protected $primaryKey = 'id_group';
    protected $allowedFields = [
        'title',
        'dashboard',
        'rules',
        'token'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}