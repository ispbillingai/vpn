<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateBackupTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_backup' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'path' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
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
        $this->forge->addKey('id_backup', true);
        $this->forge->createTable('backup');
    }

    public function down()
    {
        $this->forge->dropTable('backup');
    }
}
