<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateThemeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_theme' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['backend', 'frontend'],
                'default'    => 'backend',
            ],
            'path' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
        ]);
        $this->forge->addKey('id_theme', true);
        $this->forge->createTable('theme');
    }

    public function down()
    {
        $this->forge->dropTable('theme');
    }
}
