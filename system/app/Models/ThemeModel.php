<?php
namespace App\Models;

class ThemeModel extends BaseModel
{
    protected $table = 'theme';
    protected $primaryKey = 'id_theme';
    protected $allowedFields = [
        'name',
        'type',
        'path'
    ];
}