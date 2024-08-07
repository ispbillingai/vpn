<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_settings' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'activate_frontend' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'logo' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default'    => null,
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default'    => null,
            ],
            'default_language' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'default_role' => [
                'type' => 'VARCHAR',
                'constraint' => '35',
            ],
            'default_date_format' => [
                'type' => 'VARCHAR',
                'constraint' => '35',
            ],
            'default_hour_format' => [
                'type' => 'VARCHAR',
                'constraint' => '35',
            ],
            'default_currency' => [
                'type' => 'VARCHAR',
                'constraint' => '35',
            ],
            'default_currency_position' => [
                'type'       => 'ENUM',
                'constraint' => ['left', 'right'],
                'default'    => 'left',
            ],
            'default_currency_separation' => [
                'type'       => 'ENUM',
                'constraint' => ['dot', 'comma'],
                'default'    => 'dot',
            ],
            'default_country' => [
                'type' => 'VARCHAR',
                'constraint' => '35',
            ],
            'default_theme' => [
                'type' => 'INT',
                'constraint' => 11,
                'default'    => '1',
            ],
            'default_theme_front' => [
                'type' => 'INT',
                'constraint' => 11,
                'default'    => '2',
            ],
            'default_timezone' => [
                'type' => 'VARCHAR',
                'constraint' => '35',
            ],
            'seo_description' => [
                'type' => 'TEXT',
                'default'    => null,
            ],
            'seo_keywords' => [
                'type' => 'TEXT',
                'default'    => null,
            ],
            'email_gateway' => [
                'type'       => 'ENUM',
                'constraint' => ['smtp'],
                'default'    => 'smtp',
            ],
            'email_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default'    => null,
            ],
            'email_address' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default'    => null,
            ],
            'email_smtp' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default'    => null,
            ],
            'email_port' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'default'    => null,
            ],
            'email_pass' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default'    => null,
            ],
            'email_cert' => [
                'type'       => 'ENUM',
                'constraint' => ['none','ssl','tls'],
                'default'    => 'none',
            ],
            'email_account_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default'    => null,
            ],
            'email_auth_token' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default'    => null,
            ],
            'email_info_add' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default'    => null,
            ],
            'sms_gateway' => [
                'type'       => 'ENUM',
                'constraint' => ['twilio'],
                'default'    => 'twilio',
            ],
            'sms_account_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default'    => null,
            ],
            'sms_auth_token' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default'    => null,
            ],
            'sms_info_add' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default'    => null,
            ],
            'captcha_gateway' => [
                'type'       => 'ENUM',
                'constraint' => ['recaptcha','hcaptcha'],
                'default'    => 'recaptcha',
            ],
            'captcha_site_key' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default'    => null,
            ],
            'captcha_secret_key' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default'    => null,
            ],
            'captcha_register' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'captcha_login' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'captcha_recovery' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'registration' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'terms_conditions' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'terms_conditions_text' => [
                'type' => 'TEXT',
                'default'    => null,
            ],
            'email_confirmation' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'sms_confirmation' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'send_user_register' => [
                'type' => 'VARCHAR',
                'constraint' => '35',
            ],
            'send_email_register' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'send_sms_register' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'send_notification_register' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'send_email_welcome' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'send_sms_welcome' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'remember_me' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'forgot_password' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'two_factor_auth' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'throttle_auth' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'throttle_auth_max_attempts' => [
                'type' => 'INT',
                'constraint' => 11,
                'default'    => '5',
            ],
            'throttle_auth_lockour_time' => [
                'type' => 'INT',
                'constraint' => 11,
                'default'    => '12',
            ],
            'jwt_token_lifetime' => [
                'type' => 'INT',
                'constraint' => 11,
                'default'    => '30',
            ],
            'jwt_private_key' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
            'group_api' => [
                'type' => 'TEXT',
            ],
            'block_external_api' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'ip_allowed_api' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'default'    => null,
            ],
            'enable_api' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'remove_log' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'remove_log_time' => [
                'type' => 'INT',
                'constraint' => 11,
                'default'    => '180',
            ],
            'remove_log_latest' => [
                'type' => 'DATETIME',
            ],
            'storage_gateway' => [
                'type'       => 'ENUM',
                'constraint' => ['local','aws','minio'],
                'default'    => 'local',
            ],
            'aws_endpoint' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'default'    => null,
            ],
            'aws_key' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'default'    => null,
            ],
            'aws_secret' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'default'    => null,
            ],
            'aws_region' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'default'    => null,
            ],
            'aws_bucket' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'default'    => null,
            ],
            'backup_storage' => [
                'type'       => 'ENUM',
                'constraint' => ['local','aws','minio'],
                'default'    => 'local',
            ],
            'backup_table' => [
                'type' => 'TEXT',
            ],
            'backup_email' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'default'    => null,
            ],
            'backup_notification_email' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'backup_automatic' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'backup_time' => [
                'type' => 'TIME',
            ],
            'backup_latest' => [
                'type' => 'DATETIME',
                'default'    => null,
            ],
            'pusher_appId' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'pusher_key' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'pusher_secret' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'pusher_cluster' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'pusher_useTLS' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'pusher_scheme' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'pusher_enable' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'module_enable' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'layout_enable' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default'    => '0',
            ],
            'purchase_code' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default'    => null,
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id_settings', true);
        $this->forge->createTable('settings');
    }

    public function down()
    {
        $this->forge->dropTable('settings');
    }
}
