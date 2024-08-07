<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateTemplateTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_template' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
            'subject' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'body' => [
                'type' => 'TEXT',
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['email', 'sms'],
                'default'    => 'email',
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id_template', true);
        $this->forge->createTable('template');
    }

    public function down()
    {
        $this->forge->dropTable('template');
    }
}
