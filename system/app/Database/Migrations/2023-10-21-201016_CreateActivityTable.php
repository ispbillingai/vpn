<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateActivityTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_activity' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user' => [
                'type' => 'VARCHAR',
                'constraint' => '35',
            ],
            'level' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'event' => [
                'type' => 'VARCHAR',
                'constraint' => '60',
            ],
            'ip' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'os' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'browser' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'detail' => [
                'type' => 'TEXT',
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id_activity', true);
        $this->forge->createTable('activity');
    }

    public function down()
    {
        $this->forge->dropTable('activity');
    }
}
