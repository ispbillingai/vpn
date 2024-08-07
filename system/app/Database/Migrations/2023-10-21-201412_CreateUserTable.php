<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateUserTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'group' => [
                'type' => 'VARCHAR',
                'constraint' => '35',
            ],
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
            'date_birth' => [
                'type' => 'DATE',
                'default' => NULL,
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL,
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL,
            ],
            'state' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'country' => [
                'type' => 'CHAR',
                'constraint' => '2',
            ],
            'zip_code' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'default' => NULL,
            ],
            'mobile' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '35',
            ],
            'last_ip' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'last_access' => [
                'type' => 'DATETIME',
            ],
            'picture' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
            'language' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'tfa' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => '0',
            ],
            'tfa_secret' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'tfa_code' => [
                'type' => 'VARCHAR',
                'constraint' => '60',
            ],
            'blocked' => [
                'type' => 'DATETIME',
                'default' => NULL,
            ],
            'email_confirmed' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => '0',
            ],
            'sms_confirmed' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => '0',
            ],
            'token' => [
                'type' => 'VARCHAR',
                'constraint' => '35',
            ],
            'status' => [
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
        $this->forge->addKey('id_user', true);
        $this->forge->createTable('user');
    }

    public function down()
    {
        $this->forge->dropTable('user');
    }
}
