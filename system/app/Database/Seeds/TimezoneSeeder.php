<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TimezoneSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('timezone');
        $jsonContent = file_get_contents(APPPATH . 'Database\Data\TimezoneData.json');
        $data = json_decode($jsonContent, true);
        if (!empty($data)) {
            $builder->insertBatch($data);
        }
    }
}
