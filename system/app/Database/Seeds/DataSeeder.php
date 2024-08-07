<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DataSeeder extends Seeder
{
    public function run()
    {
        $this->call('CountriesSeeder');
        $this->call('CurrencySeeder');
        $this->call('SettingsOauthSeeder');
        $this->call('SettingsSeeder');
        $this->call('TemplateSeeder');
        $this->call('ThemeSeeder');
        $this->call('TimezoneSeeder');
        $this->call('UserGroupSeeder');
        $this->call('UserSeeder');
    }
}
