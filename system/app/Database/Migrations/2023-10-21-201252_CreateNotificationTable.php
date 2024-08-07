<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateNotificationTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_notification' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_sender' => [
                'type' => 'VARCHAR',
                'constraint' => '35',
            ],
            'user_recipient' => [
                'type' => 'VARCHAR',
                'constraint' => '35',
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'body' => [
                'type' => 'TEXT',
            ],
            'is_read' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => '0',
            ],
            'is_send_email' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => '0',
            ],
            'is_send_sms' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => '0',
            ],
            'send_email_notification' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => '0',
            ],
            'send_sms_notification' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => '0',
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
        $this->forge->addKey('id_notification', true);
        $this->forge->createTable('notification');
    }

    public function down()
    {
        $this->forge->dropTable('notification');
    }
}
