<?php
namespace App\Models;

class CountriesModel extends BaseModel
{
    protected $table = 'countries';
    protected $primaryKey = 'id_country';
    protected $allowedFields = [
        'phone',
        'code',
        'name',
        'symbol',
        'capital',
        'currency',
        'continent',
        'continent_code',
        'alpha_3',
        'data_lang'
    ];
}