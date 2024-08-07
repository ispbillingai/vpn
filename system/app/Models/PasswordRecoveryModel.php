<?php

namespace App\Models;

class PasswordRecoveryModel extends BaseModel
{
    protected $table = 'password_recovery';
    protected $primaryKey = 'id_pass_recovery';
    protected $allowedFields = [
        'user',
        'token',
        'changed'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}