<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserGroupSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('user_group');
        $jsonContent = file_get_contents(APPPATH . 'Database\Data\UserGroupData.json');
        $data = json_decode($jsonContent, true);
        if (!empty($data)) {
            $builder->insertBatch($data);
        }
    }
}
