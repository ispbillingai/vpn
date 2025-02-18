<?php

_admin();
$ui->assign('_title', Lang::T('Recharge Account'));
$ui->assign('_system_menu', 'prepaid');

$action = $routes['1'];
//$admin = Admin::_info();
$ui->assign('_admin', $admin);

$select2_customer = <<<EOT
<script>
document.addEventListener("DOMContentLoaded", function(event) {
    $('#personSelect').select2({
        theme: "bootstrap",
        ajax: {
            url: function(params) {
                if(params.term != undefined){
                    return './index.php?_route=autoload/customer_select2&s='+params.term;
                }else{
                    return './index.php?_route=autoload/customer_select2';
                }
            }
        }
    });
});
</script>
EOT;

switch ($action) {
    case 'sync':
        if (!in_array($admin['user_type'], ['SuperAdmin', 'Admin'])) {
            _alert(Lang::T('You do not have permission to access this page'), 'danger', "dashboard");
        }
        set_time_limit(-1);
        $plans = ORM::for_table('tbl_user_recharges')->where('status', 'on')->find_many();
        $log = '';
        $router = '';
        foreach ($plans as $plan) {
            if ($router != $plan['routers'] && $plan['routers'] != 'radius') {
                $mikrotik = Mikrotik::info($plan['routers']);
                $client = Mikrotik::getClient($mikrotik['ip_address'], $mikrotik['username'], $mikrotik['password']);
                $router = $plan['routers'];
            }
            $p = ORM::for_table('tbl_plans')->findOne($plan['plan_id']);
            $c = ORM::for_table('tbl_customers')->findOne($plan['customer_id']);
            if ($plan['routers'] == 'radius') {
                Radius::customerAddPlan($c, $p, $plan['expiration'] . ' ' . $plan['time']);
            } else {
                if ($plan['type'] == 'Hotspot') {
                    Mikrotik::addHotspotUser($client, $p, $c);
                } else if ($plan['type'] == 'PPPOE') {
                    Mikrotik::addPpoeUser($client, $p, $c);
                }
                ////////////////////////////////
                ///////////////////////////////
                ///////////////////////my added code

                else if ($plan['type'] == 'Static') {
                    Mikrotik::addStaticUser($client, $p, $c);
                }
            }
            $log .= "DONE : $plan[username], $plan[namebp], $plan[type], $plan[routers]<br>";
        }
        if ($isApi) {
            showResult(true, $log);
        }        
        r2(U . 'prepaid/list', 's', $log);
    case 'list':
        $ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/prepaid.js"></script>');
        $ui->assign('_title', Lang::T('Customer'));
        $search = _post('search');
        if ($search != '') {
            $paginator = Paginator::build(ORM::for_table('tbl_user_recharges'), ['username' => '%' . $search . '%'], $search);
            $d = ORM::for_table('tbl_user_recharges')->where_like('username', '%' . $search . '%')->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_many();
        } else {
            $paginator = Paginator::build(ORM::for_table('tbl_user_recharges'));
            $d = ORM::for_table('tbl_user_recharges')->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_array();
        }
        run_hook('view_list_billing'); #HOOK
        if ($isApi) {
            showResult(true, $action, $d, ['search' => $search]);            
        }


        $ui->assign('d', $d);
        $ui->assign('search', $search);
        $ui->assign('paginator', $paginator);
        $ui->display('prepaid.tpl');
        break;

        case 'list_hotspot':
            $ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/prepaid.js"></script>');
            $ui->assign('_title', Lang::T('Hotspot Users'));
            $search = _post('search');
            $queryBuilder = ORM::for_table('tbl_user_recharges')
                ->where('type', 'Hotspot');
        
            if ($search != '') {
                $queryBuilder->where_like('username', '%' . $search . '%');
            }
        
            $paginator = Paginator::build($queryBuilder);
            $d = $queryBuilder->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_array();
        
            $ui->assign('d', $d);
            $ui->assign('search', $search);
            $ui->assign('paginator', $paginator);
            $ui->display('prepaid_list_hotspot.tpl');
            break;
        
        case 'list_static':
            $ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/prepaid.js"></script>');
            $ui->assign('_title', Lang::T('Static Users'));
            $search = _post('search');
            $queryBuilder = ORM::for_table('tbl_user_recharges')
                ->where('type', 'Static');
        
            if ($search != '') {
                $queryBuilder->where_like('username', '%' . $search . '%');
            }
        
            $paginator = Paginator::build($queryBuilder);
            $d = $queryBuilder->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_array();
        
            $ui->assign('d', $d);
            $ui->assign('search', $search);
            $ui->assign('paginator', $paginator);
            $ui->display('prepaid_list_static.tpl');
            break;
        
        case 'list_pppoe':
            $ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/prepaid.js"></script>');
            $ui->assign('_title', Lang::T('PPPoE Users'));
            $search = _post('search');
            $queryBuilder = ORM::for_table('tbl_user_recharges')
                ->where('type', 'PPPoE');
        
            if ($search != '') {
                $queryBuilder->where_like('username', '%' . $search . '%');
            }
        
            $paginator = Paginator::build($queryBuilder);
            $d = $queryBuilder->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_array();
        
            $ui->assign('d', $d);
            $ui->assign('search', $search);
            $ui->assign('paginator', $paginator);
            $ui->display('prepaid_list_pppoe.tpl');
            break;
        

            case 'active_packages':
                $ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/prepaid.js"></script>');
                $ui->assign('_title', Lang::T('Active Packages'));
                $search = _post('search');
                $queryBuilder = ORM::for_table('tbl_user_recharges')
                    ->where('status', 'on');
                
                if ($search != '') {
                    $queryBuilder->where_like('username', '%' . $search . '%');
                }
                
                $paginator = Paginator::build($queryBuilder);
                $d = $queryBuilder->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_array();
                
                $ui->assign('d', $d);
                $ui->assign('search', $search);
                $ui->assign('paginator', $paginator);
                $ui->display('prepaid_active.tpl');
                break;
            
            case 'active_hotspot':
                $ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/prepaid.js"></script>');
                $ui->assign('_title', Lang::T('Active Hotspot Packages'));
                $search = _post('search');
                $queryBuilder = ORM::for_table('tbl_user_recharges')
                    ->where('status', 'on')
                    ->where('type', 'Hotspot');
                
                if ($search != '') {
                    $queryBuilder->where_like('username', '%' . $search . '%');
                }
                
                $paginator = Paginator::build($queryBuilder);
                $d = $queryBuilder->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_array();
                
                $ui->assign('d', $d);
                $ui->assign('search', $search);
                $ui->assign('paginator', $paginator);
                $ui->display('prepaid_active_hotspot.tpl');
                break;
            
            case 'active_static':
                $ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/prepaid.js"></script>');
                $ui->assign('_title', Lang::T('Active Static Packages'));
                $search = _post('search');
                $queryBuilder = ORM::for_table('tbl_user_recharges')
                    ->where('status', 'on')
                    ->where('type', 'Static');
                
                if ($search != '') {
                    $queryBuilder->where_like('username', '%' . $search . '%');
                }
                
                $paginator = Paginator::build($queryBuilder);
                $d = $queryBuilder->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_array();
                
                $ui->assign('d', $d);
                $ui->assign('search', $search);
                $ui->assign('paginator', $paginator);
                $ui->display('prepaid_active_static.tpl');
                break;
            
            case 'active_pppoe':
                $ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/prepaid.js"></script>');
                $ui->assign('_title', Lang::T('Active PPPoE Packages'));
                $search = _post('search');
                $queryBuilder = ORM::for_table('tbl_user_recharges')
                    ->where('status', 'on')
                    ->where('type', 'PPPoE');
                
                if ($search != '') {
                    $queryBuilder->where_like('username', '%' . $search . '%');
                }
                
                $paginator = Paginator::build($queryBuilder);
                $d = $queryBuilder->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_array();
                
                $ui->assign('d', $d);
                $ui->assign('search', $search);
                $ui->assign('paginator', $paginator);
                $ui->display('prepaid_active_pppoe.tpl');
                break;
            
        
                case 'expired_packages':
                    $ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/prepaid.js"></script>');
                    $ui->assign('_title', Lang::T('Expired Packages'));
                    $search = _post('search');
                    $queryBuilder = ORM::for_table('tbl_user_recharges')
                        ->where('status', 'off');
                    
                    if ($search != '') {
                        $queryBuilder->where_like('username', '%' . $search . '%');
                    }
                    
                    $paginator = Paginator::build($queryBuilder);
                    $d = $queryBuilder->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_array();
                    
                    $ui->assign('d', $d);
                    $ui->assign('search', $search);
                    $ui->assign('paginator', $paginator);
                    $ui->display('prepaid_expired.tpl');
                    break;
                
                case 'expired_hotspot':
                    $ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/prepaid.js"></script>');
                    $ui->assign('_title', Lang::T('Expired Hotspot Packages'));
                    $search = _post('search');
                    $queryBuilder = ORM::for_table('tbl_user_recharges')
                        ->where('status', 'off')
                        ->where('type', 'Hotspot');
                    
                    if ($search != '') {
                        $queryBuilder->where_like('username', '%' . $search . '%');
                    }
                    
                    $paginator = Paginator::build($queryBuilder);
                    $d = $queryBuilder->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_array();
                    
                    $ui->assign('d', $d);
                    $ui->assign('search', $search);
                    $ui->assign('paginator', $paginator);
                    $ui->display('prepaid_expired_hotspot.tpl');
                    break;
                
                case 'expired_static':
                    $ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/prepaid.js"></script>');
                    $ui->assign('_title', Lang::T('Expired Static Packages'));
                    $search = _post('search');
                    $queryBuilder = ORM::for_table('tbl_user_recharges')
                        ->where('status', 'off')
                        ->where('type', 'Static');
                    
                    if ($search != '') {
                        $queryBuilder->where_like('username', '%' . $search . '%');
                    }
                    
                    $paginator = Paginator::build($queryBuilder);
                    $d = $queryBuilder->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_array();
                    
                    $ui->assign('d', $d);
                    $ui->assign('search', $search);
                    $ui->assign('paginator', $paginator);
                    $ui->display('prepaid_expired_static.tpl');
                    break;
                
                case 'expired_pppoe':
                    $ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/prepaid.js"></script>');
                    $ui->assign('_title', Lang::T('Expired PPPoE Packages'));
                    $search = _post('search');
                    $queryBuilder = ORM::for_table('tbl_user_recharges')
                        ->where('status', 'off')
                        ->where('type', 'PPPoE');
                    
                    if ($search != '') {
                        $queryBuilder->where_like('username', '%' . $search . '%');
                    }
                    
                    $paginator = Paginator::build($queryBuilder);
                    $d = $queryBuilder->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_array();
                    
                    $ui->assign('d', $d);
                    $ui->assign('search', $search);
                    $ui->assign('paginator', $paginator);
                    $ui->display('prepaid_expired_pppoe.tpl');
                    break;
                
        
                    case 'online_users':
                        $ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/prepaid.js"></script>');
                        $ui->assign('_title', Lang::T('Online Users'));
                        $search = _post('search');
                        $queryBuilder = ORM::for_table('tbl_user_recharges')
                            ->where('state', 'Online');
                        
                        if ($search != '') {
                            $queryBuilder->where_like('username', '%' . $search . '%');
                        }
                        
                        $paginator = Paginator::build($queryBuilder);
                        $d = $queryBuilder->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_array();
                        
                        $ui->assign('d', $d);
                        $ui->assign('search', $search);
                        $ui->assign('paginator', $paginator);
                        $ui->display('prepaid_online.tpl');
                        break;
                    
                    case 'online_hotspot':
                        $ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/prepaid.js"></script>');
                        $ui->assign('_title', Lang::T('Online Hotspot Users'));
                        $search = _post('search');
                        $queryBuilder = ORM::for_table('tbl_user_recharges')
                            ->where('state', 'Online')
                            ->where('type', 'Hotspot');
                        
                        if ($search != '') {
                            $queryBuilder->where_like('username', '%' . $search . '%');
                        }
                        
                        $paginator = Paginator::build($queryBuilder);
                        $d = $queryBuilder->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_array();
                        
                        $ui->assign('d', $d);
                        $ui->assign('search', $search);
                        $ui->assign('paginator', $paginator);
                        $ui->display('prepaid_online_hotspot.tpl');
                        break;
                    
                    case 'online_static':
                        $ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/prepaid.js"></script>');
                        $ui->assign('_title', Lang::T('Online Static Users'));
                        $search = _post('search');
                        $queryBuilder = ORM::for_table('tbl_user_recharges')
                            ->where('state', 'Online')
                            ->where('type', 'Static');
                        
                        if ($search != '') {
                            $queryBuilder->where_like('username', '%' . $search . '%');
                        }
                        
                        $paginator = Paginator::build($queryBuilder);
                        $d = $queryBuilder->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_array();
                        
                        $ui->assign('d', $d);
                        $ui->assign('search', $search);
                        $ui->assign('paginator', $paginator);
                        $ui->display('prepaid_online_static.tpl');
                        break;
                    
                    case 'online_pppoe':
                        $ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/prepaid.js"></script>');
                        $ui->assign('_title', Lang::T('Online PPPoE Users'));
                        $search = _post('search');
                        $queryBuilder = ORM::for_table('tbl_user_recharges')
                            ->where('state', 'Online')
                            ->where('type', 'PPPoE');
                        
                        if ($search != '') {
                            $queryBuilder->where_like('username', '%' . $search . '%');
                        }
                        
                        $paginator = Paginator::build($queryBuilder);
                        $d = $queryBuilder->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_array();
                        
                        $ui->assign('d', $d);
                        $ui->assign('search', $search);
                        $ui->assign('paginator', $paginator);
                        $ui->display('prepaid_online_pppoe.tpl');
                        break;
                    

                        case 'offline_users':
                            $ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/prepaid.js"></script>');
                            $ui->assign('_title', Lang::T('Offline Users'));
                            $search = _post('search');
                            $queryBuilder = ORM::for_table('tbl_user_recharges')
                                ->where('state', 'Offline');
                            
                            if ($search != '') {
                                $queryBuilder->where_like('username', '%' . $search . '%');
                            }
                            
                            $paginator = Paginator::build($queryBuilder);
                            $d = $queryBuilder->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_array();
                            
                            $ui->assign('d', $d);
                            $ui->assign('search', $search);
                            $ui->assign('paginator', $paginator);
                            $ui->display('prepaid_offline.tpl');
                            break;
                        
                        case 'offline_hotspot':
                            $ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/prepaid.js"></script>');
                            $ui->assign('_title', Lang::T('Offline Hotspot Users'));
                            $search = _post('search');
                            $queryBuilder = ORM::for_table('tbl_user_recharges')
                                ->where('state', 'Offline')
                                ->where('type', 'Hotspot');
                            
                            if ($search != '') {
                                $queryBuilder->where_like('username', '%' . $search . '%');
                            }
                            
                            $paginator = Paginator::build($queryBuilder);
                            $d = $queryBuilder->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_array();
                            
                            $ui->assign('d', $d);
                            $ui->assign('search', $search);
                            $ui->assign('paginator', $paginator);
                            $ui->display('prepaid_offline_hotspot.tpl');
                            break;
                        
                        case 'offline_static':
                            $ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/prepaid.js"></script>');
                            $ui->assign('_title', Lang::T('Offline Static Users'));
                            $search = _post('search');
                            $queryBuilder = ORM::for_table('tbl_user_recharges')
                                ->where('state', 'Offline')
                                ->where('type', 'Static');
                            
                            if ($search != '') {
                                $queryBuilder->where_like('username', '%' . $search . '%');
                            }
                            
                            $paginator = Paginator::build($queryBuilder);
                            $d = $queryBuilder->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_array();
                            
                            $ui->assign('d', $d);
                            $ui->assign('search', $search);
                            $ui->assign('paginator', $paginator);
                            $ui->display('prepaid_offline_static.tpl');
                            break;
                        
                        case 'offline_pppoe':
                            $ui->assign('xfooter', '<script type="text/javascript" src="ui/lib/c/prepaid.js"></script>');
                            $ui->assign('_title', Lang::T('Offline PPPoE Users'));
                            $search = _post('search');
                            $queryBuilder = ORM::for_table('tbl_user_recharges')
                                ->where('state', 'Offline')
                                ->where('type', 'PPPoE');
                            
                            if ($search != '') {
                                $queryBuilder->where_like('username', '%' . $search . '%');
                            }
                            
                            $paginator = Paginator::build($queryBuilder);
                            $d = $queryBuilder->offset($paginator['startpoint'])->limit($paginator['limit'])->order_by_desc('id')->find_array();
                            
                            $ui->assign('d', $d);
                            $ui->assign('search', $search);
                            $ui->assign('paginator', $paginator);
                            $ui->display('prepaid_offline_pppoe.tpl');
                            break;
                        
            

        case 'recharge':
            if (!in_array($admin['user_type'], ['SuperAdmin', 'Admin', 'Agent', 'Sales'])) {
                _log("User " . strval($admin['username']) . " does not have permission to access the recharge page", 'error');
                _alert(Lang::T('You do not have permission to access this page'), 'danger', "dashboard");
            } else {

                $ui->assign('xfooter', $select2_customer);
                $p = ORM::for_table('tbl_plans')->where('enabled', '1')->find_many();
                $ui->assign('p', $p);
                $r = ORM::for_table('tbl_routers')->where('enabled', '1')->find_many();
                $ui->assign('r', $r);
                if (isset($routes['2']) && !empty($routes['2'])) {
                    $ui->assign('cust', ORM::for_table('tbl_customers')->find_one($routes['2']));
                }
                run_hook('view_recharge'); #HOOK
                $ui->display('recharge.tpl');
            }
            break;
        
        case 'recharge-user':

            if (!in_array($admin['user_type'], ['SuperAdmin', 'Admin', 'Agent', 'Sales'])) {
                _alert(Lang::T('You do not have permission to access this page'), 'danger', "dashboard");
            } else {
                $id = $routes['2'];
                $ui->assign('id', $id);
                $c = ORM::for_table('tbl_customers')->find_many();
                $ui->assign('c', $c);
                $p = ORM::for_table('tbl_plans')->where('enabled', '1')->find_many();
                $ui->assign('p', $p);
                $r = ORM::for_table('tbl_routers')->where('enabled', '1')->find_many();
                $ui->assign('r', $r);
                run_hook('view_recharge_customer'); #HOOK
                $ui->display('recharge-user.tpl');
            }
            break;
            case 'recharge-post':
                if (!in_array($admin['user_type'], ['SuperAdmin', 'Admin', 'Agent', 'Sales'])) {
                    _alert(Lang::T('You do not have permission to access this page'), 'danger', "dashboard");
                }
                $id_customer = _post('id_customer');
                $server = _post('server');
                $planId = _post('plan');
            
                $msg = '';
                if ($id_customer == '' or $server == '' or $planId == '') {
                    $msg .= Lang::T('All fields are required') . '<br>';
                }
            
                if ($msg == '') {
                    $gateway = 'Recharge';
                    $channel = $admin['fullname'];
                    $cust = User::_info($id_customer);
                    $plan = ORM::for_table('tbl_plans')->find_one($planId);
            
                    if (!$cust) {
                        r2(U . 'prepaid/recharge', 'e', Lang::T('Customer not found'));
                    }
            
                    if (!$plan) {
                        r2(U . 'prepaid/recharge', 'e', Lang::T('Plan not found'));
                    }
            
                    $planPrice = $plan['price'];
                    $customerBalance = $cust['balance'];
            
                    if ($customerBalance >= $planPrice) {
                        // Deduct the plan price from the customer's balance
                        $newBalance = $customerBalance - $planPrice;
                    } else {
                        // Insufficient balance, set the new balance to zero
                        $newBalance = 0;
                    }
            
                    if (Package::rechargeUser($id_customer, $server, $planId, $gateway, $channel)) {
                        // Update the customer's balance after successful recharge
                        $cust->balance = $newBalance;
                        $cust->save();
            
                        $in = ORM::for_table('tbl_transactions')->where('username', $cust['username'])->order_by_desc('id')->find_one();
                        Package::createInvoice($in);
                        $ui->display('invoice.tpl');
                        _log('[' . $admin['username'] . ']: ' . 'Recharge ' . $cust['username'] . ' [' . $in['plan_name'] . '][' . Lang::moneyFormat($in['price']) . ']', $admin['user_type'], $admin['id']);
                    } else {
                        r2(U . 'prepaid/recharge', 'e', "Failed to recharge account");
                    }
                } else {
                    r2(U . 'prepaid/recharge', 'e', $msg);
                }
                break;
            
            
            
            
            

                case 'extend':
                    if (!in_array($admin['user_type'], ['SuperAdmin', 'Admin', 'Agent'])) {
                        _alert(Lang::T('You do not have permission to access this page'), 'danger', "dashboard");
                    }
                    $id  = $routes['2'];
                    
                    // Ensure the 'extend' column exists
                    $columns = ORM::for_table('tbl_user_recharges')->raw_query('SHOW COLUMNS FROM tbl_user_recharges LIKE "extend"')->find_array();
                    if (empty($columns)) {
                        ORM::for_table('tbl_user_recharges')->raw_execute('ALTER TABLE tbl_user_recharges ADD COLUMN extend INT DEFAULT 0');
                    }
                
                    $d = ORM::for_table('tbl_user_recharges')->find_one($id);
                    if ($d) {
                        $ui->assign('d', $d);
                        $ui->assign('_title', 'Extend Plan');
                        $ui->display('prepaid-extend.tpl');
                    } else {
                        r2(U . 'services/list', 'e', $_L['Account_Not_Found']);
                    }
                    break;
                
                    case 'extend-post':
                        if (!in_array($admin['user_type'], ['SuperAdmin', 'Admin', 'Agent'])) {
                            _alert(Lang::T('You do not have permission to access this page'), 'danger', "dashboard");
                        }
                        $id = _post('id');
                        $extension_days = _post('extension_days');
                        
                        // Ensure the 'extend' column exists
                        $columns = ORM::for_table('tbl_user_recharges')->raw_query('SHOW COLUMNS FROM tbl_user_recharges LIKE "extend"')->find_array();
                        if (empty($columns)) {
                            ORM::for_table('tbl_user_recharges')->raw_execute('ALTER TABLE tbl_user_recharges ADD COLUMN extend INT DEFAULT 0');
                        }
                    
                        $d = ORM::for_table('tbl_user_recharges')->find_one($id);
                        if ($d) {
                            $original_expiration = $d->expiration;
                            $new_expiration = date('Y-m-d H:i:s', strtotime($d->expiration . " + $extension_days days"));
                            $d->expiration = $new_expiration;
                            
                            // Save the extension days in the 'extend' column
                            $d->extend = $extension_days;
                    
                            if ($d->status == 'off' && strtotime($new_expiration) > time()) {
                                $d->status = 'on';
                            }
                    
                            $d->save();
                    
                            // Call Package::changeTo to interact with the router
                            Package::changeTo($d->username, $d->plan_id, $id);
                    
                            _log('[' . $admin['username'] . ']: ' . 'Extended Plan for Customer ' . $d['username'] . ' by ' . $extension_days . ' days', $admin['user_type'], $admin['id']);
                            r2(U . 'prepaid/list', 's', Lang::T('Plan Extended Successfully'));
                        } else {
                            r2(U . 'prepaid/extend/' . $id, 'e', $_L['Data_Not_Found']);
                        }
                        break;
                    
                
                
            
            case 'view':
                $id = $routes['2'];
                $in = ORM::for_table('tbl_transactions')->where('id', $id)->find_one();
                $ui->assign('in', $in);
            
                if (!empty($routes['3']) && $routes['3'] == 'send') {
                    $c = ORM::for_table('tbl_customers')->where('username', $in['username'])->find_one();
                    if ($c) {
                        Message::sendInvoice($c, $in);
                        r2(U . 'prepaid/view/' . $id, 's', "Success send to customer");
                    }
                    r2(U . 'prepaid/view/' . $id, 'd', "Customer not found");
                }
            
                Package::createInvoice($in);
                $ui->assign('_title', 'View Invoice');
                $ui->display('invoice.tpl');
                break;

    case 'print':
        $content = $_POST['content'];
        if (!empty($content)) {
            $ui->assign('content', $content);
        }else{
            $id = _post('id');
            $d = ORM::for_table('tbl_transactions')->where('id', $id)->find_one();
            $ui->assign('in', $d);
            $ui->assign('date', Lang::dateAndTimeFormat($d['recharged_on'], $d['recharged_time']));
        }

        run_hook('print_invoice'); #HOOK
        $ui->display('invoice-print.tpl');
        break;

    case 'edit':
        if (!in_array($admin['user_type'], ['SuperAdmin', 'Admin', 'Agent'])) {
            _alert(Lang::T('You do not have permission to access this page'), 'danger', "dashboard");
        }
        $id  = $routes['2'];
        $d = ORM::for_table('tbl_user_recharges')->find_one($id);
        if ($d) {
            $ui->assign('d', $d);
            if (in_array($admin['user_type'], array('SuperAdmin', 'Admin'))) {
            $p = ORM::for_table('tbl_plans')->where('enabled', '1')->where_not_equal('type', 'Balance')->find_many();
        } else {
            $p = ORM::for_table('tbl_plans')->where('enabled', '1')->where_not_equal('type', 'Balance')->find_many();
        }
        $ui->assign('p', $p);
        run_hook('view_edit_customer_plan'); #HOOK
        $ui->assign('_title', 'Edit Plan');
        $ui->display('prepaid-edit.tpl');
    } else {
        r2(U . 'services/list', 'e', $_L['Account_Not_Found']);
    }
    break;

    case 'delete':
        if (!in_array($admin['user_type'], ['SuperAdmin', 'Admin'])) {
            _alert(Lang::T('You do not have permission to access this page'), 'danger', "dashboard");
        }
        $id  = $routes['2'];
        $d = ORM::for_table('tbl_user_recharges')->find_one($id);
        if ($d) {
            run_hook('delete_customer_active_plan'); #HOOK
            $p = ORM::for_table('tbl_plans')->find_one($d['plan_id']);
            if ($p['is_radius']) {
                Radius::customerDeactivate($d['username']);
            } else {
                $mikrotik = Mikrotik::info($d['routers']);
                if ($d['type'] == 'Hotspot') {
                    $client = Mikrotik::getClient($mikrotik['ip_address'], $mikrotik['username'], $mikrotik['password']);
                    Mikrotik::removeHotspotUser($client, $d['username']);
                    Mikrotik::removeHotspotActiveUser($client, $d['username']);
                } elseif ($d['type'] == 'PPPOE') {

                    $client = Mikrotik::getClient($mikrotik['ip_address'], $mikrotik['username'], $mikrotik['password']);
                    Mikrotik::removePpoeUser($client, $d['username']);
                    Mikrotik::removePpoeActive($client, $d['username']);

                }
                 //my added code i also added else if for each type
                 //use of elseif instead of else
                 elseif ($d['type'] == 'Static') {

                    $client = Mikrotik::getClient($mikrotik['ip_address'], $mikrotik['username'], $mikrotik['password']);
                    Mikrotik::removeStaticUser($client, $d['username']);
                    //Mikrotik::removeStaticPlan($client);
                
                }
            }

            $d->delete();
    _log('[' . $admin['username'] . ']: ' . 'Delete Plan for Customer ' . $c['username'] . '  [' . $in['plan_name'] . '][' . Lang::moneyFormat($in['price']) . ']', $admin['user_type'], $admin['id']);
            r2(U . 'prepaid/list', 's', Lang::T('Data Deleted Successfully'));
        }
        break;

        case 'disable':
            if (!in_array($admin['user_type'], ['SuperAdmin', 'Admin'])) {
                _alert(Lang::T('You do not have permission to access this page'), 'danger', "dashboard");
            }
            $id  = $routes['2'];
            $d = ORM::for_table('tbl_user_recharges')->find_one($id);
            if ($d) {
                run_hook('disable_customer_active_plan'); #HOOK
                $p = ORM::for_table('tbl_plans')->find_one($d['plan_id']);
                if ($p['is_radius']) {
                    Radius::customerDeactivate($d['username']);
                } else {
                    $mikrotik = Mikrotik::info($d['routers']);
                    $client = Mikrotik::getClient($mikrotik['ip_address'], $mikrotik['username'], $mikrotik['password']);
        
                    if ($d['type'] == 'Hotspot') {
                        Mikrotik::disableHotspotUser($client, $d['username']);
                    } elseif ($d['type'] == 'PPPOE') {
                        Mikrotik::disablePpoeUser($client, $d['username']);
                    } elseif ($d['type'] == 'Static') {
                        Mikrotik::disableStaticUser($client, $d['username']);
                    }
                }
        
                _log('[' . $admin['username'] . ']: ' . 'Disable Plan for Customer ' . $d['username'], $admin['user_type'], $admin['id']);
                r2(U . 'prepaid/list', 's', Lang::T('User Disabled Successfully'));
            }
            break;

            case 'enable':
                if (!in_array($admin['user_type'], ['SuperAdmin', 'Admin'])) {
                    _alert(Lang::T('You do not have permission to access this page'), 'danger', "dashboard");
                }
                $id = $routes['2'];
                $d = ORM::for_table('tbl_user_recharges')->find_one($id);
                if ($d) {
                    run_hook('enable_customer_active_plan'); #HOOK
                    $p = ORM::for_table('tbl_plans')->find_one($d['plan_id']);
                    if ($p['is_radius']) {
                        Radius::customerDeactivate($d['username']);
                    } else {
                        $mikrotik = Mikrotik::info($d['routers']);
                        $client = Mikrotik::getClient($mikrotik['ip_address'], $mikrotik['username'], $mikrotik['password']);
            
                        if ($d['type'] == 'Hotspot') {
                            Mikrotik::enableHotspotUser($client, $d['username']);
                        } elseif ($d['type'] == 'PPPOE') {
                            Mikrotik::enablePpoeUser($client, $d['username']);
                        } elseif ($d['type'] == 'Static') {
                            Mikrotik::enableStaticUser($client, $d['username']);
                        }
                    }
            
                    _log('[' . $admin['username'] . ']: ' . 'Enable Plan for Customer ' . $d['username'], $admin['user_type'], $admin['id']);
                    r2(U . 'prepaid/list', 's', Lang::T('User Enabled Successfully'));
                }
                break;
                    
        

    case 'edit-post':
        if (!in_array($admin['user_type'], ['SuperAdmin', 'Admin'])) {
            _alert(Lang::T('You do not have permission to access this page'), 'danger', "dashboard");
        }
        $username = _post('username');
        $id_plan = _post('id_plan');
        $recharged_on = _post('recharged_on');
        $expiration = _post('expiration');
        $time = _post('time');

        $id = _post('id');
        $d = ORM::for_table('tbl_user_recharges')->find_one($id);
        if ($d) {
        } else {
            $msg .= Lang::T('Data Not Found') . '<br>';
        }
        $p = ORM::for_table('tbl_plans')->where('id', $id_plan)->where('enabled', '1')->find_one();
        if ($d) {
        } else {
            $msg .= ' Plan Not Found<br>';
        }
        if ($msg == '') {
            run_hook('edit_customer_plan'); #HOOK
            $d->username = $username;
            $d->plan_id = $id_plan;
            //$d->recharged_on = $recharged_on;
            $d->expiration = $expiration;
            $d->time = $time;
                    if ($d['status'] == 'off') {
                if (strtotime($expiration . ' ' . $time) > time()) {
                    $d->status = 'on';
                }
            }
            if($p['is_radius']){
                $d->routers = 'radius';
            }else{
                $d->routers = $p['routers'];
            }
            $d->save();
            if($d['status'] == 'on'){
                Package::changeTo($username, $id_plan, $id);
            }
            _log('[' . $admin['username'] . ']: ' . 'Edit Plan for Customer ' . $d['username'] . ' to [' . $d['namebp'] . '][' . Lang::moneyFormat($p['price']) . ']', $admin['user_type'], $admin['id']);
            r2(U . 'prepaid/list', 's', Lang::T('Data Updated Successfully'));
        } else {
            r2(U . 'prepaid/edit/' . $id, 'e', $msg);
        }
        break;

        case 'voucher':
            $ui->assign('_title', Lang::T('Vouchers'));
            $search = _req('search');
            if ($search != '') {
                if (in_array($admin['user_type'], ['SuperAdmin', 'Admin'])) {
                    $query = ORM::for_table('tbl_plans')->where('enabled', '1')
                        ->left_outer_join('tbl_voucher', array('tbl_plans.id', '=', 'tbl_voucher.id_plan'))
                        ->where_like('tbl_voucher.code', '%' . $search . '%');
                    $d = Paginator::findMany($query, ["search" => $search]);
                } else if ($admin['user_type'] == 'Agent') {
                    $sales = [];
                    $sls = ORM::for_table('tbl_users')->select('id')->where('root', $admin['id'])->findArray();
                    foreach ($sls as $s) {
                        $sales[] = $s['id'];
                    }
                    $sales[] = $admin['id'];
                    $query = ORM::for_table('tbl_plans')
                        ->left_outer_join('tbl_voucher', array('tbl_plans.id', '=', 'tbl_voucher.id_plan'))
                        ->where_in('generated_by', $sales)
                        ->where_like('tbl_voucher.code', '%' . $search . '%');
                    $d = Paginator::findMany($query, ["search" => $search]);
                }
            } else {
                if (in_array($admin['user_type'], ['SuperAdmin', 'Admin'])) {
                    $query = ORM::for_table('tbl_plans')->where('enabled', '1')
                        ->left_outer_join('tbl_voucher', array('tbl_plans.id', '=', 'tbl_voucher.id_plan'));
                    $d = Paginator::findMany($query);
                } else if ($admin['user_type'] == 'Agent') {
                    $sales = [];
                    $sls = ORM::for_table('tbl_users')->select('id')->where('root', $admin['id'])->findArray();
                    foreach ($sls as $s) {
                        $sales[] = $s['id'];
                    }
                    $sales[] = $admin['id'];
                    $query = ORM::for_table('tbl_plans')
                        ->left_outer_join('tbl_voucher', array('tbl_plans.id', '=', 'tbl_voucher.id_plan'))
                        ->where_in('generated_by', $sales);
                    $d = Paginator::findMany($query);
                }
            }
            // extract admin
            $admins = [];
            foreach ($d as $k) {
                if (!empty($k['generated_by'])) {
                    $admins[] = $k['generated_by'];
                }
            }
            if (count($admins) > 0) {
                $adms = ORM::for_table('tbl_users')->where_in('id', $admins)->find_many();
                unset($admins);
                foreach ($adms as $adm) {
                    $tipe = $adm['user_type'];
                    if ($tipe == 'Sales') {
                        $tipe = ' [S]';
                    } else if ($tipe == 'Agent') {
                        $tipe = ' [A]';
                    } else {
                        $tipe == '';
                    }
                    $admins[$adm['id']] = $adm['fullname'] . $tipe;
                }
            }
            $ui->assign('admins', $admins);
            $ui->assign('d', $d);
            $ui->assign('search', $search);
            $ui->assign('page', $page);
            run_hook('view_list_voucher'); #HOOK
            $ui->display('voucher.tpl');
            break;
    
        case 'add-voucher':
            if (!in_array($admin['user_type'], ['SuperAdmin', 'Admin', 'Agent', 'Sales'])) {
                _alert(Lang::T('You do not have permission to access this page'), 'danger', "dashboard");
            }
            $ui->assign('_title', Lang::T('Add Vouchers'));
            $c = ORM::for_table('tbl_customers')->find_many();
            $ui->assign('c', $c);
            $p = ORM::for_table('tbl_plans')->where('enabled', '1')->find_many();
            $ui->assign('p', $p);
            $r = ORM::for_table('tbl_routers')->where('enabled', '1')->find_many();
            $ui->assign('r', $r);
            run_hook('view_add_voucher'); #HOOK
            $ui->display('voucher-add.tpl');
            break;
    
        case 'remove-voucher':
            if (!in_array($admin['user_type'], ['SuperAdmin', 'Admin'])) {
                _alert(Lang::T('You do not have permission to access this page'), 'danger', "dashboard");
            }
            $d = ORM::for_table('tbl_voucher')->where_equal('status', '1')->findMany();
            if ($d) {
                $jml = 0;
                foreach ($d as $v) {
                    if (!ORM::for_table('tbl_user_recharges')->where_equal("method", 'Voucher - ' . $v['code'])->findOne()) {
                        $v->delete();
                        $jml++;
                    }
                }
                r2(U . 'prepaid/voucher', 's', "$jml " . Lang::T('Data Deleted Successfully'));
            }
        case 'print-voucher':
            $from_id = _post('from_id');
            $planid = _post('planid');
            $pagebreak = _post('pagebreak');
            $limit = _post('limit');
            $vpl = _post('vpl');
            if (empty($vpl)) {
                $vpl = 3;
            }
            if ($pagebreak < 1) $pagebreak = 12;
    
            if ($limit < 1) $limit = $pagebreak * 2;
            if (empty($from_id)) {
                $from_id = 0;
            }
    
            if ($from_id > 0 && $planid > 0) {
                $v = ORM::for_table('tbl_plans')
                    ->left_outer_join('tbl_voucher', array('tbl_plans.id', '=', 'tbl_voucher.id_plan'))
                    ->where('tbl_voucher.status', '0')
                    ->where('tbl_plans.id', $planid)
                    ->where_gt('tbl_voucher.id', $from_id)
                    ->limit($limit);
                $vc = ORM::for_table('tbl_plans')
                    ->left_outer_join('tbl_voucher', array('tbl_plans.id', '=', 'tbl_voucher.id_plan'))
                    ->where('tbl_voucher.status', '0')
                    ->where('tbl_plans.id', $planid)
                    ->where_gt('tbl_voucher.id', $from_id);
            } else if ($from_id == 0 && $planid > 0) {
                $v = ORM::for_table('tbl_plans')
                    ->left_outer_join('tbl_voucher', array('tbl_plans.id', '=', 'tbl_voucher.id_plan'))
                    ->where('tbl_voucher.status', '0')
                    ->where('tbl_plans.id', $planid)
                    ->limit($limit);
                $vc = ORM::for_table('tbl_plans')
                    ->left_outer_join('tbl_voucher', array('tbl_plans.id', '=', 'tbl_voucher.id_plan'))
                    ->where('tbl_voucher.status', '0')
                    ->where('tbl_plans.id', $planid);
            } else if ($from_id > 0 && $planid == 0) {
                $v = ORM::for_table('tbl_plans')
                    ->left_outer_join('tbl_voucher', array('tbl_plans.id', '=', 'tbl_voucher.id_plan'))
                    ->where('tbl_voucher.status', '0')
                    ->where_gt('tbl_voucher.id', $from_id)
                    ->limit($limit);
                $vc = ORM::for_table('tbl_plans')
                    ->left_outer_join('tbl_voucher', array('tbl_plans.id', '=', 'tbl_voucher.id_plan'))
                    ->where('tbl_voucher.status', '0')
                    ->where_gt('tbl_voucher.id', $from_id);
            } else {
                $v = ORM::for_table('tbl_plans')
                    ->left_outer_join('tbl_voucher', array('tbl_plans.id', '=', 'tbl_voucher.id_plan'))
                    ->where('tbl_voucher.status', '0')
                    ->limit($limit);
                $vc = ORM::for_table('tbl_plans')
                    ->left_outer_join('tbl_voucher', array('tbl_plans.id', '=', 'tbl_voucher.id_plan'))
                    ->where('tbl_voucher.status', '0');
            }
            if (in_array($admin['user_type'], ['SuperAdmin', 'Admin'])) {
                $v = $v->find_many();
                $vc = $vc->count();
            } else {
                $sales = [];
                $sls = ORM::for_table('tbl_users')->select('id')->where('root', $admin['id'])->findArray();
                foreach ($sls as $s) {
                    $sales[] = $s['id'];
                }
                $sales[] = $admin['id'];
                $v = $v->where_in('generated_by', $sales)->find_many();
                $vc = $vc->where_in('generated_by', $sales)->count();
            }
            $template = file_get_contents("pages/Voucher.html");
            $template = str_replace('[[company_name]]', $config['CompanyName'], $template);
    
            $ui->assign('_title', Lang::T('Hotspot Voucher'));
            $ui->assign('from_id', $from_id);
            $ui->assign('vpl', $vpl);
            $ui->assign('pagebreak', $pagebreak);
    
            $plans = ORM::for_table('tbl_plans')->find_many();
            $ui->assign('plans', $plans);
            $ui->assign('limit', $limit);
            $ui->assign('planid', $planid);
    
            $voucher = [];
            $n = 1;
            foreach ($v as $vs) {
                $temp = $template;
                $temp = str_replace('[[qrcode]]', '<img src="qrcode/?data=' . $vs['code'] . '">', $temp);
                $temp = str_replace('[[price]]', Lang::moneyFormat($vs['price']), $temp);
                $temp = str_replace('[[voucher_code]]', $vs['code'], $temp);
                $temp = str_replace('[[plan]]', $vs['name_plan'], $temp);
                $temp = str_replace('[[counter]]', $n, $temp);
                $voucher[] = $temp;
                $n++;
            }
    
            $ui->assign('voucher', $voucher);
            $ui->assign('vc', $vc);
    
            //for counting pagebreak
            $ui->assign('jml', 0);
            run_hook('view_print_voucher'); #HOOK
            $ui->display('print-voucher.tpl');
            break;
        case 'voucher-post':
            if (!in_array($admin['user_type'], ['SuperAdmin', 'Admin', 'Agent', 'Sales'])) {
                _alert(Lang::T('You do not have permission to access this page'), 'danger', "dashboard");
            }
            $type = _post('type');
            $plan = _post('plan');
            $voucher_format = _post('voucher_format');
            $prefix = _post('prefix');
            $server = _post('server');
            $numbervoucher = _post('numbervoucher');
            $lengthcode = _post('lengthcode');
    
            $msg = '';
            if ($type == '' or $plan == '' or $server == '' or $numbervoucher == '' or $lengthcode == '') {
                $msg .= Lang::T('All field is required') . '<br>';
            }
            if (Validator::UnsignedNumber($numbervoucher) == false) {
                $msg .= 'The Number of Vouchers must be a number' . '<br>';
            }
            if (Validator::UnsignedNumber($lengthcode) == false) {
                $msg .= 'The Length Code must be a number' . '<br>';
            }
            if ($msg == '') {
                if (!empty($prefix)) {
                    $d = ORM::for_table('tbl_appconfig')->where('setting', 'voucher_prefix')->find_one();
                    if ($d) {
                        $d->value = $prefix;
                        $d->save();
                    } else {
                        $d = ORM::for_table('tbl_appconfig')->create();
                        $d->setting = 'voucher_prefix';
                        $d->value = $prefix;
                        $d->save();
                    }
                }
                run_hook('create_voucher'); #HOOK
                $vouchers = [];
                if($voucher_format == 'numbers'){
                    if (strlen($lengthcode)<6) {
                        $msg .= 'The Length Code must be a more than 6 for numbers' . '<br>';
                    }
                    $vouchers = generateUniqueNumericVouchers($numbervoucher, $lengthcode);
                }
                else {
                    for ($i = 0; $i < $numbervoucher; $i++) {
                        $code = strtoupper(substr(md5(time() . rand(10000, 99999)), 0, $lengthcode));
                        if ($voucher_format == 'low') {
                            $code = strtolower($code);
                        } else if ($voucher_format == 'rand') {
                            $code = Lang::randomUpLowCase($code);
                        }
                        $vouchers[] = $code;
    
                    }
                }
    
                foreach($vouchers as $code){
                    $d = ORM::for_table('tbl_voucher')->create();
                    $d->type = $type;
                    $d->routers = $server;
                    $d->id_plan = $plan;
                    $d->code = $prefix . $code;
                    $d->user = '0';
                    $d->status = '0';
                    $d->generated_by = $admin['id'];
                    $d->save();
                }
                if ($numbervoucher == 1) {
                    r2(U . 'prepaid/voucher-view/' . $d->id(), 's', Lang::T('Create Vouchers Successfully'));
                }
    
                r2(U . 'prepaid/voucher', 's', Lang::T('Create Vouchers Successfully'));
            } else {
                r2(U . 'prepaid/add-voucher/' . $id, 'e', $msg);
            }
            break;
    
        case 'voucher-view':
            $id = $routes[2];
            if (in_array($admin['user_type'], ['SuperAdmin', 'Admin'])) {
                $voucher = ORM::for_table('tbl_voucher')->find_one($id);
            } else {
                $sales = [];
                $sls = ORM::for_table('tbl_users')->select('id')->where('root', $admin['id'])->findArray();
                foreach ($sls as $s) {
                    $sales[] = $s['id'];
                }
                $sales[] = $admin['id'];
                $voucher = ORM::for_table('tbl_voucher')
                    ->find_one($id);
                if (!in_array($voucher['generated_by'], $sales)) {
                    r2(U . 'prepaid/voucher/', 'e', Lang::T('Voucher Not Found'));
                }
            }
            if (!$voucher) {
                r2(U . 'prepaid/voucher/', 'e', Lang::T('Voucher Not Found'));
            }
            $plan = ORM::for_table('tbl_plans')->find_one($voucher['id_plan']);
            if ($voucher && $plan) {
                $content = Lang::pad($config['CompanyName'], ' ', 2) . "\n";
                $content .= Lang::pad($config['address'], ' ', 2) . "\n";
                $content .= Lang::pad($config['phone'], ' ', 2) . "\n";
                $content .= Lang::pad("", '=') . "\n";
                $content .= Lang::pads('ID', $voucher['id'], ' ') . "\n";
                $content .= Lang::pads(Lang::T('Code'), $voucher['code'], ' ') . "\n";
                $content .= Lang::pads(Lang::T('Plan Name'), $plan['name_plan'], ' ') . "\n";
                $content .= Lang::pads(Lang::T('Type'), $voucher['type'], ' ') . "\n";
                $content .= Lang::pads(Lang::T('Plan Price'), Lang::moneyFormat($plan['price']), ' ') . "\n";
                $content .= Lang::pads(Lang::T('Sales'), $admin['fullname'] . ' #' . $admin['id'], ' ') . "\n";
                $content .= Lang::pad("", '=') . "\n";
                $content .= Lang::pad($config['note'], ' ', 2) . "\n";
                $ui->assign('print', $content);
                $config['printer_cols'] = 30;
                $content = Lang::pad($config['CompanyName'], ' ', 2) . "\n";
                $content .= Lang::pad($config['address'], ' ', 2) . "\n";
                $content .= Lang::pad($config['phone'], ' ', 2) . "\n";
                $content .= Lang::pad("", '=') . "\n";
                $content .= Lang::pads('ID', $voucher['id'], ' ') . "\n";
                $content .= Lang::pads(Lang::T('Code'), $voucher['code'], ' ') . "\n";
                $content .= Lang::pads(Lang::T('Plan Name'), $plan['name_plan'], ' ') . "\n";
                $content .= Lang::pads(Lang::T('Type'), $voucher['type'], ' ') . "\n";
                $content .= Lang::pads(Lang::T('Plan Price'), Lang::moneyFormat($plan['price']), ' ') . "\n";
                $content .= Lang::pads(Lang::T('Sales'), $admin['fullname'] . ' #' . $admin['id'], ' ') . "\n";
                $content .= Lang::pad("", '=') . "\n";
                $content .= Lang::pad($config['note'], ' ', 2) . "\n";
                $ui->assign('_title', Lang::T('View'));
                $ui->assign('whatsapp', urlencode("```$content```"));
                $ui->display('voucher-view.tpl');
            } else {
                r2(U . 'prepaid/voucher/', 'e', Lang::T('Voucher Not Found'));
            }
            break;
        case 'voucher-delete':
            if (!in_array($admin['user_type'], ['SuperAdmin', 'Admin'])) {
                _alert(Lang::T('You do not have permission to access this page'), 'danger', "dashboard");
            }
            $id  = $routes['2'];
            run_hook('delete_voucher'); #HOOK
            $d = ORM::for_table('tbl_voucher')->find_one($id);
            if ($d) {
                $d->delete();
                r2(U . 'prepaid/voucher', 's', Lang::T('Data Deleted Successfully'));
            }
            break;
    case 'refill':
        if (!in_array($admin['user_type'], ['SuperAdmin', 'Admin', 'Agent', 'Sales'])) {
            _alert(Lang::T('You do not have permission to access this page'), 'danger', "dashboard");
        }
        $ui->assign('xfooter', $select2_customer);
        $ui->assign('_title', Lang::T('Refill Account'));
        run_hook('view_refill'); #HOOK
        $ui->display('refill.tpl');

        break;

    case 'refill-post':
        if (!in_array($admin['user_type'], ['SuperAdmin', 'Admin', 'Agent', 'Sales'])) {
            _alert(Lang::T('You do not have permission to access this page'), 'danger', "dashboard");
        }        
        $code = _post('code');
        $user = ORM::for_table('tbl_customers')->where('id', _post('id_customer'))->find_one();
        $v1 = ORM::for_table('tbl_voucher')->where('code', $code)->where('status', 0)->find_one();

        run_hook('refill_customer'); #HOOK
        if ($v1) {
            if (Package::rechargeUser($user['id'], $v1['routers'], $v1['id_plan'], "Voucher", $code)) {
                $v1->status = "1";
                $v1->user = $user['username'];
                $v1->save();
                $in = ORM::for_table('tbl_transactions')->where('username', $user['username'])->order_by_desc('id')->find_one();
                Package::createInvoice($in);
                $ui->display('invoice.tpl');
            } else {
                r2(U . 'prepaid/refill', 'e', "Failed to refill account");
            }
        } else {
            r2(U . 'prepaid/refill', 'e', Lang::T('Voucher Not Valid'));
        }
        break;

    default:
        $ui->display('a404.tpl');
}
