<?php
namespace App\Models;

class ConfirmationTokenModel extends BaseModel
{
    protected $table = 'confirmation_token';
    protected $primaryKey = 'id_confirmation';
    protected $allowedFields = [
        'user',
        'token',
        'confirmed',
        'type'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}