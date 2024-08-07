<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateCrontabTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_crontab' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'routine' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'error' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id_crontab', true);
        $this->forge->createTable('crontab_history');
    }

    public function down()
    {
        $this->forge->dropTable('crontab_history');
    }
}
