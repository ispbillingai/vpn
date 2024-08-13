<?php

/**
 *  PHP Mikrotik Billing (https://freeispradius.com/)
 *  by https://t.me/freeispradius
 **/

function executeCommandOnVPS($command) {
    $connection = ssh2_connect('your-vps-ip', 22);

    if (!$connection) {
        throw new Exception('Could not connect to the VPS.');
    }

    // Authenticate using username and password (or use a private key)
    if (!ssh2_auth_password($connection, 'your-vps-username', 'your-vps-password')) {
        throw new Exception('Failed to authenticate with the VPS.');
    }

    // Execute the command
    $stream = ssh2_exec($connection, $command);

    if (!$stream) {
        throw new Exception('Failed to execute the command.');
    }

    // Collect the command's output (optional)
    stream_set_blocking($stream, true);
    $output = stream_get_contents($stream);

    // Close the stream and connection
    fclose($stream);
    ssh2_disconnect($connection);

    return $output;
}

_auth();
$action = $routes['1'];
$user = User::_info();
$ui->assign('_user', $user);

switch ($action) {
    case 'remote-access':
        $user_id = $user['id'];
        
        // Fetch all VPNs associated with the user
        $vpns = ORM::for_table('tbl_vpn')
            ->where('user_id', $user_id)
            ->find_many();
        
        if ($vpns) {
            $ui->assign('vpns', $vpns);
            $ui->assign('_system_menu', 'remote-access');
            $ui->assign('_title', Lang::T('Remote Access'));
            run_hook('customer_view_remote_access'); #HOOK
            $ui->display('vpn-remoteAccess.tpl');
        } else {
            r2(U . 'vpn/list-vpns', 'e', Lang::T('No VPN accounts found.'));
        }
        break;

    case 'create-vpn':
        $ui->assign('_system_menu', 'create-vpn');
        $ui->assign('_title', Lang::T('Create VPN'));
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle VPN creation
            $vpn_name = _post('vpn_name');
            $vpn_user = _post('vpn_user');
            $vpn_pass = _post('vpn_pass');

            $msg = '';
            if (Validator::Length($vpn_name, 30, 2) == false) {
                $msg .= 'VPN Name should be between 3 to 30 characters' . '<br>';
            }
            if ($vpn_user == '' || $vpn_pass == '') {
                $msg .= Lang::T('All fields are required') . '<br>';
            }

            if ($msg == '') {
                // Save VPN details to the database
                $b = ORM::for_table('tbl_vpn')->create();
                $b->vpn_name = $vpn_name;  // Save the router name for reference
                $b->vpn_user = $vpn_user;
                $b->vpn_pass = $vpn_pass;
                $b->user_id = $user['id'];  // Associate with the current user
                $b->save();

                // Execute the command on the VPS
                $command = "/path/to/your/script.sh {$vpn_user} {$vpn_pass}";
                try {
                    $output = executeCommandOnVPS($command);
                    error_log("Command output: " . $output);
                    r2(U . 'vpn/list-vpns', 's', Lang::T('VPN Created Successfully and configured on VPS.'));
                } catch (Exception $e) {
                    r2(U . 'vpn/create-vpn', 'e', 'Error configuring VPN on VPS: ' . $e->getMessage());
                }
            } else {
                r2(U . 'vpn/create-vpn', 'e', $msg);
            }
        } else {
            $ui->display('vpn-createVpn.tpl');
        }
        break;

    case 'list-vpns':
        $ui->assign('_system_menu', 'list-vpns');
        $ui->assign('_title', Lang::T('List VPNs'));

        $paginator = Paginator::build(ORM::for_table('tbl_vpn'), ['user_id' => $user['id']]);
        $d = ORM::for_table('tbl_vpn')
            ->where('user_id', $user['id'])
            ->order_by_desc('id')
            ->offset($paginator['startpoint'])->limit($paginator['limit'])
            ->find_many();

        $ui->assign('paginator', $paginator);
        $ui->assign('d', $d);
        run_hook('customer_view_list_vpns'); #HOOK
        $ui->display('vpn-listVpns.tpl');
        break;

    case 'generate-config':
        $vpn_id = _get('id');
        error_log("VPN ID received: " . $vpn_id);

        if (!$vpn_id) {
            error_log("Error: No VPN ID provided.");
            r2(U . 'vpn/list-vpns', 'e', Lang::T('No VPN ID provided.'));
            break;
        }

        $vpn = ORM::for_table('tbl_vpn')->find_one($vpn_id);

        if (!$vpn) {
            error_log("Error: VPN not found for ID " . $vpn_id);
            r2(U . 'vpn/list-vpns', 'e', Lang::T('Invalid VPN account.'));
            break;
        }

        error_log("VPN found: " . print_r($vpn->as_array(), true));

        $routeros_version = _get('version'); // 6 or 7
        error_log("RouterOS version received: " . $routeros_version);

        if ($routeros_version == '6') {
            $config = "/interface ovpn-client add connect-to=mikrotik.freeispradius.com name=freeispradiusremoted user={$vpn->vpn_user} password={$vpn->vpn_pass} profile=default-encryption comment=freeispradiuswinbox cipher=aes256 auth=sha1";
            error_log("Generated config for RouterOS 6: " . $config);
        } elseif ($routeros_version == '7') {
            $config = "/interface ovpn-client add connect-to=mikrotik.freeispradius.com name=freeispradiusremoted user={$vpn->vpn_user} password={$vpn->vpn_pass} profile=default-encryption comment=freeispradiuswinbox cipher=aes256 auth=sha256";
            error_log("Generated config for RouterOS 7: " . $config);
        } else {
            error_log("Error: Invalid RouterOS version specified: " . $routeros_version);
            r2(U . 'vpn/list-vpns', 'e', Lang::T('Invalid RouterOS version specified.'));
            break;
        }

        $ui->assign('config', $config);
        $ui->display('vpn-config.tpl');

        break;

    default:
        r2(U . 'vpn/list-vpns', 's', '');
}
