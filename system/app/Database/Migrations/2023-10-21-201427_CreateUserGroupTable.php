<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateUserGroupTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_group' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
            'dashboard' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'rules' => [
                'type' => 'MEDIUMTEXT',
            ],
            'token' => [
                'type' => 'VARCHAR',
                'constraint' => '35',
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id_group', true);
        $this->forge->createTable('user_group');
    }

    public function down()
    {
        $this->forge->dropTable('user_group');
    }
}
