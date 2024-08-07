<?php
namespace App\Models;

class UserOauthModel extends BaseModel
{
    protected $table = 'user_oauth';
    protected $primaryKey = 'id_user_oauth';
    protected $allowedFields = [
        'user',
        'provider',
        'identifier',
        'picture'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}