<?php
namespace App\Models;

class BackupModel extends BaseModel
{
    protected $table = 'backup';
    protected $primaryKey = 'id_backup';
    protected $allowedFields = [
        'path',
        'error'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}