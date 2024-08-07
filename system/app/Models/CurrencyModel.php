<?php
namespace App\Models;

class CurrencyModel extends BaseModel
{
    protected $table = 'currency';
    protected $primaryKey = 'id_currency';
    protected $allowedFields = [
        'code',
        'name',
        'data_lang'
    ];
}