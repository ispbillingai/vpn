<?php
namespace App\Models;

class TimezoneModel extends BaseModel
{
    protected $table = 'timezone';
    protected $primaryKey = 'id_timezone';
    protected $allowedFields = [
        'timezone',
        'description'
    ];
}