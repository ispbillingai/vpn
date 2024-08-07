<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateTimezoneTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_timezone' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'timezone' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
        ]);
        $this->forge->addKey('id_timezone', true);
        $this->forge->createTable('timezone');
    }

    public function down()
    {
        $this->forge->dropTable('timezone');
    }
}
