<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateConfirmationTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_confirmation' => [
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
            'confirmed' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['email','sms'],
                'default'    => 'email',
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id_confirmation', true);
        $this->forge->createTable('confirmation_token');
    }

    public function down()
    {
        $this->forge->dropTable('confirmation_token');
    }
}
