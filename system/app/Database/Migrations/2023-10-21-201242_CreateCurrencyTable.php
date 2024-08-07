<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateCurrencyTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_currency' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'code' => [
                'type' => 'VARCHAR',
                'constraint' => '3',
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'data_lang' => [
                'type' => 'VARCHAR',
                'constraint' => '5',
            ],
        ]);
        $this->forge->addKey('id_currency', true);
        $this->forge->createTable('currency');
    }

    public function down()
    {
        $this->forge->dropTable('currency');
    }
}
