<?php
namespace App\Models;

class TemplateModel extends BaseModel
{
    protected $table = 'template';
    protected $primaryKey = 'id_template';
    protected $allowedFields = [
        'name',
        'subject',
        'body',
        'type'
    ];
    protected $useTimestamps = true;
    protected $updatedField  = 'updated_at';
}