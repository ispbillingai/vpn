<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateUserOauthTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user_oauth' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user' => [
                'type' => 'VARCHAR',
                'constraint' => '35',
            ],
            'provider' => [
                'type'       => 'ENUM',
                'constraint' => ['facebook','google','twitter','linkedin','github','instagram','slack','spotify','reddit','discord','dribbble','dropbox','gitlab','strava','tumblr','twitch','vkontakte','wordpress','yahoo','bitbucket','wechat'],
            ],
            'identifier' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'picture' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id_user_oauth', true);
        $this->forge->createTable('user_oauth');
    }

    public function down()
    {
        $this->forge->dropTable('user_oauth');
    }
}
