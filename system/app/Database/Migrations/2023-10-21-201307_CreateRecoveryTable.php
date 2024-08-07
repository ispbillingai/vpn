<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateRecoveryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pass_recovery' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user' => [
                'type' => 'VARCHAR',
                'constraint' => '35',
            ],
            'token' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'changed' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => '0',
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id_pass_recovery', true);
        $this->forge->createTable('password_recovery');
    }

    public function down()
    {
        $this->forge->dropTable('password_recovery');
    }
}
