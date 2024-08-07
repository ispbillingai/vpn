<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingsOauthSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('settings_oauth');
        $jsonContent = file_get_contents(APPPATH . 'Database\Data\SettingsOauthData.json');
        $data = json_decode($jsonContent, true);
        if (!empty($data)) {
            $builder->insertBatch($data);
        }
    }
}
