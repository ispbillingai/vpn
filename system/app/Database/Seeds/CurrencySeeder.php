<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CurrencySeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('currency');
        $jsonContent = file_get_contents(APPPATH . 'Database\Data\CurrencyData.json');
        $data = json_decode($jsonContent, true);
        if (!empty($data)) {
            $builder->insertBatch($data);
        }
    }
}
