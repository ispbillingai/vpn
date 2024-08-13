<?php

include "../init.php";
$isCli = true;


if (php_sapi_name() !== 'cli') {
    $isCli = false;
    echo "<pre>";
}

echo "PHP Time\t" . date('Y-m-d H:i:s') . "\n";
$res = ORM::raw_execute('SELECT NOW() AS WAKTU;');
$statement = ORM::get_last_statement();
$rows = array();
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    echo "MYSQL Time\t" . $row['WAKTU'] . "\n";
}

$_c = $config;


$textExpired = Lang::getNotifText('expired');

$d = ORM::for_table('tbl_user_recharges')->where('status', 'on')->where_lte('expiration', date("Y-m-d"))->find_many();
echo "Found " . count($d) . " user(s)\n";
run_hook('cronjob'); #HOOK

foreach ($d as $ds) {
    if ($ds['type'] == 'Hotspot') {
        $date_now = strtotime(date("Y-m-d H:i:s"));
        $expiration = strtotime($ds['expiration'] . ' ' . $ds['time']);
        echo $ds['expiration'] . " : " . (($isCli) ? $ds['username'] : Lang::maskText($ds['username']));
        if ($date_now >= $expiration) {
            echo " : EXPIRED \r\n";
            $u = ORM::for_table('tbl_user_recharges')->where('id', $ds['id'])->find_one();
            $c = ORM::for_table('tbl_customers')->where('id', $ds['customer_id'])->find_one();
            $m = Mikrotik::info($ds['routers']);
            $p = ORM::for_table('tbl_plans')->where('id', $u['plan_id'])->find_one();
            $price = Lang::moneyFormat($p['price']);
            if ($p['is_radius']) {
                if (empty($p['pool_expired'])) {
                    print_r(Radius::customerDeactivate($c['username']));
                } else {
                    Radius::upsertCustomerAttr($c['username'], 'Framed-Pool', $p['pool_expired'], ':=');
                    print_r(Radius::disconnectCustomer($c['username']));
                }
            } else {
                try {
                    $client = Mikrotik::getClient($m['ip_address'], $m['username'], $m['password']);
                    if (!empty($p['pool_expired'])) {
                        Mikrotik::setHotspotUserPackage($client, $c['username'], 'EXPIRED FREEISPRADIUS ' . $p['pool_expired']);
                    } else {
                        Mikrotik::removeHotspotUser($client, $c['username']);
                    }
                    Mikrotik::removeHotspotActiveUser($client, $c['username']);
                } catch (Exception $e) {
                    echo "Failed to connect to router: " . $m['ip_address'] . "\n";
                    echo "Error: " . $e->getMessage() . "\n";
                    continue; // Skip to the next router
                }
            }
            echo Message::sendPackageNotification($c, $u['namebp'], $price, $textExpired, $config['user_notification_expired'])."\n";
            //update database user dengan status off
            $u->status = 'off';
            $u->save();

            // autorenewal from deposit
            if ($config['enable_balance'] == 'yes' && $c['auto_renewal']) {
                if ($p && $p['enabled'] && $c['balance'] >= $p['price']) {
                    if (Package::rechargeUser($ds['customer_id'], $p['routers'], $p['id'], 'Customer', 'Balance')) {
                        // if success, then get the balance
                        Balance::min($ds['customer_id'], $p['price']);
                        echo "plan enabled: $p[enabled] | User balance: $c[balance] | price $p[price]\n";
                        echo "auto renewall Success\n";
                    } else {
                        echo "plan enabled: $p[enabled] | User balance: $c[balance] | price $p[price]\n";
                        echo "auto renewall Failed\n";
                        Message::sendTelegram("FAILED RENEWAL #cron\n\n#u$c[username] #buy #Hotspot \n" . $p['name_plan'] .
                            "\nRouter: " . $p['routers'] .
                            "\nPrice: " . $p['price']);
                    }
                } else {
                    echo "no renewall | plan enabled: $p[enabled] | User balance: $c[balance] | price $p[price]\n";
                }
            } else {
                echo "no renewall | balance $config[enable_balance] auto_renewal $c[auto_renewal]\n";
            }
        } else
            echo " : ACTIVE \r\n";

    }elseif ($ds['type'] == 'Static') {
                $date_now = strtotime(date("Y-m-d H:i:s"));
                $expiration = strtotime($ds['expiration'] . ' ' . $ds['time']);
                echo $ds['expiration'] . " : " . (($isCli) ? $ds['username'] : Lang::maskText($ds['username']));
                if ($date_now >= $expiration) {
                    echo " : EXPIRED \r\n";
                    $u = ORM::for_table('tbl_user_recharges')->where('id', $ds['id'])->find_one();
                    $c = ORM::for_table('tbl_customers')->where('id', $ds['customer_id'])->find_one();
                    $m = Mikrotik::info($ds['routers']);
                    $p = ORM::for_table('tbl_plans')->where('id', $u['plan_id'])->find_one();
                    $price = Lang::moneyFormat($p['price']);
                    if ($p['is_radius']) {
                        if (empty($p['pool_expired'])) {
                            print_r(Radius::customerDeactivate($c['username']));
                        } else {
                            Radius::upsertCustomerAttr($c['username'], 'Framed-Pool', $p['pool_expired'], ':=');
                            print_r(Radius::disconnectCustomer($c['username']));
                        }
                    } else {
                        try {
                        $client = Mikrotik::getClient($m['ip_address'], $m['username'], $m['password']);
                       
                        if (!empty($p['pool_expired'])) {
                            Mikrotik::setStaticUserPackage($client, $c['username'], 'Expired FreeIspRadius ' . $p['pool_expired']);
                        } else {
                            Mikrotik::removeStaticUser($client, $c['username']);
                        }
                        } catch (Exception $e) {
                            echo "Failed to connect to router: " . $m['ip_address'] . "\n";
                            echo "Error: " . $e->getMessage() . "\n";
                            continue; // Skip to the next router
                        }
                    }
                
                    
                    echo Message::sendPackageNotification($c, $u['namebp'], $price, $textExpired, $config['user_notification_expired'])."\n";
                    //update database user dengan status off
                    $u->status = 'off';
                    $u->save();
        
                    // autorenewal from deposit
                    if ($config['enable_balance'] == 'yes' && $c['auto_renewal']) {
                        if ($p && $p['enabled'] && $c['balance'] >= $p['price']) {
                            if (Package::rechargeUser($ds['customer_id'], $p['routers'], $p['id'], 'Customer', 'Balance')) {
                                // if success, then get the balance
                                Balance::min($ds['customer_id'], $p['price']);
                                echo "plan enabled: $p[enabled] | User balance: $c[balance] | price $p[price]\n";
                                echo "auto renewall Success\n";
                            } else {
                                echo "plan enabled: $p[enabled] | User balance: $c[balance] | price $p[price]\n";
                                echo "auto renewall Failed\n";
                                Message::sendTelegram("FAILED RENEWAL #cron\n\n#u$c[username] #buy #Hotspot \n" . $p['name_plan'] .
                                    "\nRouter: " . $p['routers'] .
                                    "\nPrice: " . $p['price']);
                            }
                        } else {
                            echo "no renewall | plan enabled: $p[enabled] | User balance: $c[balance] | price $p[price]\n";
                        }
                    } else {
                        echo "no renewall | balance $config[enable_balance] auto_renewal $c[auto_renewal]\n";
                    }
                } else
                    echo " : ACTIVE \r\n";


    } else {
        $date_now = strtotime(date("Y-m-d H:i:s"));
        $expiration = strtotime($ds['expiration'] . ' ' . $ds['time']);
        echo $ds['expiration'] . " : " . (($isCli) ? $ds['username'] : Lang::maskText($ds['username']));
        if ($date_now >= $expiration) {
            echo " : EXPIRED \r\n";
            $u = ORM::for_table('tbl_user_recharges')->where('id', $ds['id'])->find_one();
            $c = ORM::for_table('tbl_customers')->where('id', $ds['customer_id'])->find_one();
            $m = ORM::for_table('tbl_routers')->where('name', $ds['routers'])->find_one();
            $p = ORM::for_table('tbl_plans')->where('id', $u['plan_id'])->find_one();
            $price = Lang::moneyFormat($p['price']);
            if ($p['is_radius']) {
                if (empty($p['pool_expired'])) {
                    print_r(Radius::customerDeactivate($c['username']));
                } else {
                    Radius::upsertCustomerAttr($c['username'], 'Framed-Pool', $p['pool_expired'], ':=');
                    print_r(Radius::disconnectCustomer($c['username']));
                }
            } else {
                try {
                $client = Mikrotik::getClient($m['ip_address'], $m['username'], $m['password']);
                if (!empty($p['pool_expired'])) {
                    Mikrotik::setPpoeUserPlan($client, $c['username'], 'EXPIRED FREEISPRADIUS ' . $p['pool_expired']);
                } else {
                    Mikrotik::removePpoeUser($client, $c['username']);
                }
                Mikrotik::removePpoeActive($client, $c['username']);
            } catch (Exception $e) {
                echo "Failed to connect to router: " . $m['ip_address'] . "\n";
                echo "Error: " . $e->getMessage() . "\n";
                continue; // Skip to the next router
            }
        }
        echo Message::sendPackageNotification($c, $u['namebp'], $price, $textExpired, $config['user_notification_expired'])."\n";

            $u->status = 'off';
            $u->save();

            // autorenewal from deposit
            if ($config['enable_balance'] == 'yes' && $c['auto_renewal']) {
                if ($p && $p['enabled'] && $c['balance'] >= $p['price']) {
                    if (Package::rechargeUser($ds['customer_id'], $p['routers'], $p['id'], 'Customer', 'Balance')) {
                        // if success, then get the balance
                        Balance::min($ds['customer_id'], $p['price']);
                        echo "plan enabled: $p[enabled] | User balance: $c[balance] | price $p[price]\n";
                        echo "auto renewall Success\n";
                    } else {
                        echo "plan enabled: $p[enabled] | User balance: $c[balance] | price $p[price]\n";
                        echo "auto renewall Failed\n";
                        Message::sendTelegram("FAILED RENEWAL #cron\n\n#u$c[username] #buy #PPPOE \n" . $p['name_plan'] .
                            "\nRouter: " . $p['routers'] .
                            "\nPrice: " . $p['price']);
                    }
                }
            }
        } else
            echo " : ACTIVE \r\n";
    }
}