<?php

/**

 **/


include "../init.php";


if (php_sapi_name() !== 'cli') {
    echo "<pre>";
}

if(!file_exists('../config.php')){
    die("config.php file not found");
}


if(!file_exists('orm.php')){
    die("orm.php file not found");
}

if(!file_exists('uploads/notifications.default.json')){
    die("uploads/notifications.default.json file not found");
}

require_once '../config.php';
require_once 'orm.php';
require_once 'autoload/PEAR2/Autoload.php';
include "autoload/Hookers.php";

ORM::configure("mysql:host=$db_host;dbname=$db_name");
ORM::configure('username', $db_user);
ORM::configure('password', $db_password);
ORM::configure('return_result_sets', true);
ORM::configure('logging', true);


// notification message
if (file_exists("uploads/notifications.json")) {
    $_notifmsg = json_decode(file_get_contents('uploads/notifications.json'), true);
}
$_notifmsg_default = json_decode(file_get_contents('uploads/notifications.default.json'), true);

//register all plugin
foreach (glob(File::pathFixer("plugin/*.php")) as $filename) {
 include $filename;
}

$result = ORM::for_table('tbl_appconfig')->find_many();
foreach ($result as $value) {
    $config[$value['setting']] = $value['value'];
}

if (!empty($radius_user) && $config['radius_enable']) {
    ORM::configure("mysql:host=$radius_host;dbname=$radius_name", null, 'radius');
    ORM::configure('username', $radius_user, 'radius');
    ORM::configure('password', $radius_pass, 'radius');
    ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'), 'radius');
    ORM::configure('return_result_sets', true, 'radius');
}

echo "PHP Time\t" . date('Y-m-d H:i:s') . "\n";
$res = ORM::raw_execute('SELECT NOW() AS WAKTU;');
$statement = ORM::get_last_statement();
$rows = array();
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    echo "MYSQL Time\t" . $row['WAKTU'] . "\n";
}

$_c = $config;

date_default_timezone_set($config['timezone']);

$textExpired = Lang::getNotifText('expired');

$d = ORM::for_table('tbl_user_recharges')->where('status', 'on')->where_lte('expiration', date("Y-m-d"))->find_many();
echo "Found " . count($d) . " user(s)\n";
run_hook('cronjob'); #HOOK

foreach ($d as $ds)
    if ($ds['type'] == 'Static') {
    $date_now = strtotime(date("Y-m-d H:i:s"));
    $expiration = strtotime($ds['expiration'] . ' ' . $ds['time']);
    echo $ds['expiration'] . " : " . $ds['username'];
    if ($date_now >= $expiration) {
        echo " : EXPIRED \r\n";
        $u = ORM::for_table('tbl_user_recharges')->where('id', $ds['id'])->find_one();
        $c = ORM::for_table('tbl_customers')->where('id', $ds['customer_id'])->find_one();
        $m = ORM::for_table('tbl_routers')->where('name', $ds['routers'])->find_one();
        $p = ORM::for_table('tbl_plans')->where('id', $u['plan_id'])->find_one();

        if ($p['is_radius']) {
            if (empty($p['pool_expired'])) {
                print_r(Radius::customerDeactivate($c['username']));
            } else {
                Radius::upsertCustomerAttr($c['username'], 'Framed-Pool', $p['pool_expired'], ':=');
                print_r(Radius::disconnectCustomer($c['username']));
            }
        } else {
            $client = Mikrotik::getClient($m['ip_address'], $m['username'], $m['password']);
          //remove user from MikroTik
            Mikrotik::removeStaticUser($client, $c['username']);
            Mikrotik::removeStaticPlan($client, $c['ip_address']);

        }
        Message::sendPackageNotification($c['phonenumber'], $c['fullname'], $u['namebp'], $textExpired, $config['user_notification_expired']);
        //update database user dengan status off
        $u->status = 'off';
        $u->save();

        // autorenewal from deposit
        if ($config['enable_balance'] == 'yes' && $c['auto_renewal']) {
            if ($p && $p['enabled'] && $c['balance'] >= $p['price'] && $p['allow_purchase'] =='yes') {
                if (Package::rechargeUser($ds['customer_id'], $p['routers'], $p['id'], 'Customer', 'Balance')) {
                    // if success, then get the balance
                    Balance::min($ds['customer_id'], $p['price']);
                    echo "plan enabled: $p[enabled] | User balance: $c[balance] | price $p[price]\n";
                    echo "auto renewall Success\n";
                } else {
                    echo "plan enabled: $p[enabled] | User balance: $c[balance] | price $p[price]\n";
                    echo "auto renewall Failed\n";
                    Message::sendTelegram("FAILED RENEWAL #cron\n\n#u$c[username] #buy #Hotspot \n" . $p['name_plan'] .
                        "\nRouter: " . $router_name .
                        "\nPrice: " . $p['price']);
                }
            } else {
                echo "no renewall | plan enabled: $p[enabled] | User balance: $c[balance] | price $p[price]\n";
            }
        } else {
            echo "no renewall | balance $config[enable_balance] auto_renewal $c[auto_renewal]\n";
        }
    } else echo " : ACTIVE \r\n";
}
