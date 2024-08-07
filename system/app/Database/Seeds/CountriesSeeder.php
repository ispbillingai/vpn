<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CountriesSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('countries');
        $jsonContent = file_get_contents(APPPATH . 'Database\Data\CountriesData.json');
        $data = json_decode($jsonContent, true);
        if (!empty($data)) {
            $builder->insertBatch($data);
        }
    }
}
