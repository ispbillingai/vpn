<?php
namespace App\Models;

class SettingsOauthModel extends BaseModel
{
    protected $table = 'settings_oauth';
    protected $primaryKey = 'id_oauth';
    protected $allowedFields = [
        'provider',
        'key',
        'secret',
        'btn_class',
        'btn_text',
        'show_text',
        'icon_class',
        'status'
    ];
}