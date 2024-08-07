<?php
namespace App\Models;

class QueryModel extends BaseModel
{
    protected $table = 'query';
    protected $primaryKey = 'id_query';
    protected $allowedFields = [
        'id_user',
        'json'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}