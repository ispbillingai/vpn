<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateCountriesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_country' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'phone' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'code' => [
                'type' => 'CHAR',
                'constraint' => '2',
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '80',
            ],
            'symbol' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'capital' => [
                'type' => 'VARCHAR',
                'constraint' => '80',
            ],
            'currency' => [
                'type' => 'VARCHAR',
                'constraint' => '3',
            ],
            'continent' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
            ],
            'continent_code' => [
                'type' => 'VARCHAR',
                'constraint' => '2',
            ],
            'alpha_3' => [
                'type' => 'CHAR',
                'constraint' => '3',
            ],
            'data_lang' => [
                'type' => 'VARCHAR',
                'constraint' => '5',
            ],
        ]);
        $this->forge->addKey('id_country', true);
        $this->forge->createTable('countries');
    }

    public function down()
    {
        $this->forge->dropTable('countries');
    }
}
