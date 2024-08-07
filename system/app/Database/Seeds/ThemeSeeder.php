<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('theme');
        $jsonContent = file_get_contents(APPPATH . 'Database\Data\ThemeData.json');
        $data = json_decode($jsonContent, true);
        if (!empty($data)) {
            $builder->insertBatch($data);
        }
    }
}
