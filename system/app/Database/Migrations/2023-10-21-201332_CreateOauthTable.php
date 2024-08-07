<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateOauthTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_oauth' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'provider' => [
                'type'       => 'ENUM',
                'constraint' => ['facebook','google','twitter','linkedin','github','instagram','slack','spotify','reddit','discord','dribbble','dropbox','gitlab','strava','tumblr','twitch','vkontakte','wordpress','yahoo','bitbucket','wechat'],
            ],
            'key' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'secret' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'btn_class' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'btn_text' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'show_text' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => '0',
            ],
            'icon_class' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => '0',
            ],
        ]);
        $this->forge->addKey('id_oauth', true);
        $this->forge->createTable('settings_oauth');
    }

    public function down()
    {
        $this->forge->dropTable('settings_oauth');
    }
}
