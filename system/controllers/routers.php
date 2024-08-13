<?php
include "../init.php";
/**
 *  PHP Mikrotik Billing (https://freeispradius.com/)
 *  by https://t.me/freeispradius
 **/

_admin();
$ui->assign('_title', Lang::T('Network'));
$ui->assign('_system_menu', 'network');

$action = $routes['1'];
//$admin = Admin::_info();
$ui->assign('_admin', $admin);

use PEAR2\Net\RouterOS;

require_once 'system/autoload/PEAR2/Autoload.php';
// Logging function
function logMessage($message) {
    $logFile = __DIR__ . '/../logs/router_backup.log';
    $maxLines = 5000;
    
    // Read existing log file
    $logs = file_exists($logFile) ? file($logFile, FILE_IGNORE_NEW_LINES) : [];
    
    // Add new log message
    $logs[] = date('Y-m-d H:i:s') . ' - ' . $message;
    
    // Keep only the last 5000 lines
    if (count($logs) > $maxLines) {
        $logs = array_slice($logs, -$maxLines);
    }
    
    // Write back to the log file
    file_put_contents($logFile, implode("\n", $logs) . "\n");
}



if (!in_array($admin['user_type'], ['SuperAdmin', 'Admin'])) {
    _alert(Lang::T('You do not have permission to access this page'),'danger', "dashboard");
}
// Function to download backup

switch ($action) {
    case 'list':
        $ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/routers.js"></script>');
        $name = _post('name');
        if ($name != '') {
            $paginator = Paginator::build(ORM::for_table('tbl_routers'), ['name' => '%' . $name . '%'], $name);
            $routers = ORM::for_table('tbl_routers')
                ->table_alias('r')
                ->select('r.*')
                ->select('c.state', 'pingStatus')
                ->select('c.uptime')
                ->select('c.model')
                ->select('c.last_seen')
                ->left_outer_join('tbl_router_cache', array('r.id', '=', 'c.router_id'), 'c')
                ->where_like('r.name', '%' . $name . '%')
                ->offset($paginator['startpoint'])
                ->limit($paginator['limit'])
                ->order_by_desc('r.id')
                ->find_array();
        } else {
            $paginator = Paginator::build(ORM::for_table('tbl_routers'));
            $routers = ORM::for_table('tbl_routers')
                ->table_alias('r')
                ->select('r.*')
                ->select('c.state', 'pingStatus')
                ->select('c.uptime')
                ->select('c.model')
                ->select('c.last_seen')
                ->left_outer_join('tbl_router_cache', array('r.id', '=', 'c.router_id'), 'c')
                ->offset($paginator['startpoint'])
                ->limit($paginator['limit'])
                ->order_by_desc('r.id')
                ->find_array();
        }

        foreach ($routers as &$router) {
            if ($router['pingStatus'] == 'Online') {
                $router['pingClass'] = 'success';
            } else {
                $router['pingClass'] = 'danger';
                if (!isset($router['uptime'])) {
                    $router['uptime'] = 'Error';
                }
                if (!isset($router['model'])) {
                    $router['model'] = 'Error';
                }
            }
            if (!isset($router['pingStatus'])) {
                $router['pingStatus'] = 'Offline';
                $router['pingClass'] = 'danger';
                $router['uptime'] = 'Error';
                $router['model'] = 'Error';
            }
        }

        $ui->assign('routers', $routers);
        $ui->assign('paginator', $paginator);
        run_hook('view_list_routers'); #HOOK
        $ui->display('routers.tpl');
        break;

    
        case 'ping':
            $id = $routes['2'];
            $cache = ORM::for_table('tbl_router_cache')->where('router_id', $id)->find_one();
            if ($cache) {
                http_response_code(200);
                echo json_encode(['status' => $cache->state]);
            } else {
                http_response_code(404);
                echo json_encode(['status' => 'Error']);
            }
            exit;
        
            case 'reboot':
                $id = $routes['2'];
                $router = ORM::for_table('tbl_routers')->find_one($id);
                if ($router) {
                    $result = Mikrotik::rebootRouter($router['ip_address'], $router['username'], $router['password']);
                    // Redirect back to the routers list page with a success message
                    r2(U . 'routers/list', 's', Lang::T('Router reboot initiated'));
                } else {
                    // Handle the case when the router is not found
                    // Redirect back to the routers list page with an error message
                    r2(U . 'routers/list', 'e', Lang::T('Router Not Found'));
                }
                break;
    case 'add':
        run_hook('view_add_routers'); #HOOK
        $ui->display('routers-add.tpl');
        break;

        case 'edit':
            $id  = $routes['2'];
            $d = ORM::for_table('tbl_routers')->find_one($id);
            if (!$d) {
                $d = ORM::for_table('tbl_routers')->where_equal('name', _get('name'))->find_one();
            }
            if ($d) {
                $ui->assign('d', $d);
                run_hook('view_router_edit'); #HOOK
                $ui->display('routers-edit.tpl');
            } else {
                r2(U . 'routers/list', 'e', Lang::T('Account Not Found'));
            }
            break;

            case 'delete':
                $id  = $routes['2'];
                run_hook('router_delete'); #HOOK
                $d = ORM::for_table('tbl_routers')->find_one($id);
                if ($d) {
                    // Add log entry for router deletion
                    _log('[' . $admin['username'] . ']: Router ' . $d->name . ' deleted successfully', $admin['user_type'], $admin['id']);
                    $d->delete();
                    r2(U . 'routers/list', 's', Lang::T('Data Deleted Successfully'));
                }
                break;
            

    case 'add-post':
        $name = _post('name');
        $ip_address = _post('ip_address');
        $username = _post('username');
        $password = _post('password');
        $description = _post('description');
        $enabled = _post('enabled');

        $msg = '';
        if (Validator::Length($name, 30, 4) == false) {
            $msg .= 'Name should be between 5 to 30 characters' . '<br>';
        }
        if ($ip_address == '' or $username == '') {
            $msg .= Lang::T('All field is required') . '<br>';
        }

        $d = ORM::for_table('tbl_routers')->where('ip_address', $ip_address)->find_one();
        if ($d) {
            $msg .= Lang::T('IP Router Already Exist') . '<br>';
        }
        if (strtolower($name) == 'radius') {
            $msg .= '<b>Radius</b> name is reserved<br>';
        }

        if ($msg == '') {
            Mikrotik::getClient($ip_address, $username, $password);
            run_hook('add_router'); #HOOK
            $d = ORM::for_table('tbl_routers')->create();
            $d->name = $name;
            $d->ip_address = $ip_address;
            $d->username = $username;
            $d->password = $password;
            $d->description = $description;
            $d->enabled = $enabled;
            $d->save();
            _log('[' . $admin['username'] . ']: Router ' . $d->name . ' created successfully', $admin['user_type'], $admin['id']);

            r2(U . 'routers/list', 's', Lang::T('Data Created Successfully'));
        } else {
            r2(U . 'routers/add', 'e', $msg);
        }
        break;



            case 'wireless':
                $routers = ORM::for_table('tbl_routers')->find_many();
                $ui->assign('routers', $routers);
                $ui->assign('current_ssid', '');
                $ui->assign('selected_router', null);
            
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (_post('action') == 'select_router') {
                        $id = _post('router_id');
                        $router = ORM::for_table('tbl_routers')->find_one($id);
            
                        if ($router) {
                            try {
                                $client = Mikrotik::getClient($router['ip_address'], $router['username'], $router['password']);
                                $ssidRequest = new RouterOS\Request('/interface/wireless/print');
                                $ssidResponse = $client->sendSync($ssidRequest);
                                $ssid = $ssidResponse->getProperty('ssid');
            
                                $ui->assign('current_ssid', $ssid);
                                $ui->assign('selected_router', $router);
                            } catch (Exception $e) {
                                r2(U . 'routers/wireless', 'e', Lang::T('Error: ') . $e->getMessage());
                            }
                        }
                    } else {
                        $id = _post('router_id');
                        $ssid = _post('ssid');
                        $password = _post('password');
            
                        if ($ssid == '') {
                            r2(U . "routers/wireless/$id", 'e', Lang::T('SSID is required'));
                        }
            
                        $router = ORM::for_table('tbl_routers')->find_one($id);
                        if (!$router) {
                            r2(U . 'routers/list', 'e', Lang::T('Router Not Found'));
                        }
            
                        try {
                            $client = Mikrotik::getClient($router['ip_address'], $router['username'], $router['password']);
                            $ssidRequest = new RouterOS\Request('/interface/wireless/set');
                            $ssidRequest->setArgument('numbers', '0'); // Assuming '0' is the wireless interface index
                            $ssidRequest->setArgument('ssid', $ssid);
                            $client->sendSync($ssidRequest);
            
                            if ($password != '') {
                                $passwordRequest = new RouterOS\Request('/interface/wireless/security-profiles/set');
                                $passwordRequest->setArgument('numbers', 'default'); // Assuming 'default' is the security profile name
                                $passwordRequest->setArgument('wpa-pre-shared-key', $password);
                                $passwordRequest->setArgument('wpa2-pre-shared-key', $password);
                                $client->sendSync($passwordRequest);
                            }
            
                            r2(U . "routers/wireless/$id", 's', Lang::T('Wireless settings updated successfully'));
                        } catch (Exception $e) {
                            r2(U . "routers/wireless/$id", 'e', Lang::T('Error: ') . $e->getMessage());
                        }
                    }
                } else {
                    $id = $routes['2'];
                    if ($id) {
                        $router = ORM::for_table('tbl_routers')->find_one($id);
                        if ($router) {
                            try {
                                $client = Mikrotik::getClient($router['ip_address'], $router['username'], $router['password']);
                                $ssidRequest = new RouterOS\Request('/interface/wireless/print');
                                $ssidResponse = $client->sendSync($ssidRequest);
                                $ssid = $ssidResponse->getProperty('ssid');
            
                                $ui->assign('current_ssid', $ssid);
                                $ui->assign('selected_router', $router);
                            } catch (Exception $e) {
                                r2(U . 'routers/wireless', 'e', Lang::T('Error: ') . $e->getMessage());
                            }
                        }
                    }
                }
            
                $ui->display('routers-wireless.tpl');
                break;
            
            

            
    case 'edit-post':
        $name = _post('name');
        $ip_address = _post('ip_address');
        $username = _post('username');
        $password = _post('password');
        $description = _post('description');
        $enabled = $_POST['enabled'];
        $msg = '';
        if (Validator::Length($name, 30, 4) == false) {
            $msg .= 'Name should be between 5 to 30 characters' . '<br>';
        }
        if ($ip_address == '' or $username == '') {
            $msg .= Lang::T('All field is required') . '<br>';
        }

        $id = _post('id');
        $d = ORM::for_table('tbl_routers')->find_one($id);
        if ($d) {
        } else {
            $msg .= Lang::T('Data Not Found') . '<br>';
        }

        if ($d['name'] != $name) {
            $c = ORM::for_table('tbl_routers')->where('name', $name)->where_not_equal('id', $id)->find_one();
            if ($c) {
                $msg .= 'Name Already Exists<br>';
            }
        }
        $oldname = $d['name'];

        if ($d['ip_address'] != $ip_address) {
            $c = ORM::for_table('tbl_routers')->where('ip_address', $ip_address)->where_not_equal('id', $id)->find_one();
            if ($c) {
                $msg .= 'IP Already Exists<br>';
            }
        }

        if (strtolower($name) == 'radius') {
            $msg .= '<b>Radius</b> name is reserved<br>';
        }


        if ($msg == '') {
            Mikrotik::getClient($ip_address, $username, $password);
            run_hook('router_edit'); #HOOK
            $d->name = $name;
            $d->ip_address = $ip_address;
            $d->username = $username;
            $d->password = $password;
            $d->description = $description;
            $d->enabled = $enabled;
            $d->save();

            _log('[' . $admin['username'] . ']: Router ' . $d->name . ' edited successfully', $admin['user_type'], $admin['id']);
            if ($name != $oldname) {
                $p = ORM::for_table('tbl_plans')->where('routers', $oldname)->find_result_set();
                $p->set('routers', $name);
                $p->save();
                $p = ORM::for_table('tbl_payment_gateway')->where('routers', $oldname)->find_result_set();
                $p->set('routers', $name);
                $p->save();
                $p = ORM::for_table('tbl_pool')->where('routers', $oldname)->find_result_set();
                $p->set('routers', $name);
                $p->save();
                $p = ORM::for_table('tbl_transactions')->where('routers', $oldname)->find_result_set();
                $p->set('routers', $name);
                $p->save();
                $p = ORM::for_table('tbl_user_recharges')->where('routers', $oldname)->find_result_set();
                $p->set('routers', $name);
                $p->save();
                $p = ORM::for_table('tbl_voucher')->where('routers', $oldname)->find_result_set();
                $p->set('routers', $name);
                $p->save();
            }
            r2(U . 'routers/list', 's', Lang::T('Data Updated Successfully'));
        } else {
            r2(U . 'routers/edit/' . $id, 'e', $msg);
        }
        break;

    default:
        r2(U . 'routers/list/', 's', '');
}
