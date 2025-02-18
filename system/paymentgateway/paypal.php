<?php


/**
 
 *
 **/


function paypal_validate_config()
{
    global $config;
    if (empty($config['paypal_client_id']) || empty($config['paypal_secret_key'])) {
        sendTelegram("PayPal payment gateway not configured");
        r2(U . 'order/package', 'w', "Admin has not yet setup Paypal payment gateway, please tell admin");
    }
}

function paypal_show_config()
{
    global $ui;
    $ui->assign('_title', 'Paypal - Payment Gateway');
    $ui->assign('currency', json_decode(file_get_contents('system/paymentgateway/paypal_currency.json'), true));
    $ui->display('paypal.tpl');
}


function paypal_save_config()
{
    global $admin, $_L;
    $paypal_client_id = _post('paypal_client_id');
    $paypal_secret_key = _post('paypal_secret_key');
    $paypal_currency = _post('paypal_currency');
    $d = ORM::for_table('tbl_appconfig')->where('setting', 'paypal_secret_key')->find_one();
    if ($d) {
        $d->value = $paypal_secret_key;
        $d->save();
    } else {
        $d = ORM::for_table('tbl_appconfig')->create();
        $d->setting = 'paypal_secret_key';
        $d->value = $paypal_secret_key;
        $d->save();
    }
    $d = ORM::for_table('tbl_appconfig')->where('setting', 'paypal_client_id')->find_one();
    if ($d) {
        $d->value = $paypal_client_id;
        $d->save();
    } else {
        $d = ORM::for_table('tbl_appconfig')->create();
        $d->setting = 'paypal_client_id';
        $d->value = $paypal_client_id;
        $d->save();
    }
    $d = ORM::for_table('tbl_appconfig')->where('setting', 'paypal_currency')->find_one();
    if ($d) {
        $d->value = $paypal_currency;
        $d->save();
    } else {
        $d = ORM::for_table('tbl_appconfig')->create();
        $d->setting = 'paypal_currency';
        $d->value = $paypal_currency;
        $d->save();
    }
    _log('[' . $admin['username'] . ']: Paypal ' . Lang::T('Settings Saved Successfully'), 'Admin', $admin['id']);

    r2(U . 'paymentgateway/paypal', 's', Lang::T('Settings Saved Successfully'));
}

function paypal_create_transaction($trx, $user)
{
    global $config;
    $json = [
        'intent' => 'CAPTURE',
        'purchase_units' => [
            [
                'amount' => [
                    'currency_code' => $config['paypal_currency'],
                    'value' => strval($trx['price'])
                ]
            ]
        ],
        "application_context" => [
            "return_url" => U . "order/view/" . $trx['id'] . '/check',
            "cancel_url" => U . "order/view/" . $trx['id'],
        ]
    ];

    $result = json_decode(
        Http::postJsonData(
            paypal_get_server() . 'checkout/orders',
            $json,
            [
                'Prefer: return=minimal',
                'PayPal-Request-Id: paypal_' . $trx['id'],
                'Authorization: Bearer ' . paypalGetAccessToken()
            ]
        ),
        true
    );
    if (!$result['id']) {
        sendTelegram("paypal_create_transaction FAILED: \n\n" . json_encode($result, JSON_PRETTY_PRINT));
        r2(U . 'order/package', 'e', "Failed to create Paypal transaction.");
    }
    $urlPayment = "";
    foreach ($result['links'] as $link) {
        if ($link['rel'] == 'approve') {
            $urlPayment = $link['href'];
            break;
        }
    }
    $d = ORM::for_table('tbl_payment_gateway')
        ->where('username', $user['username'])
        ->where('status', 1)
        ->find_one();
    $d->gateway_trx_id = $result['id'];
    $d->pg_url_payment = $urlPayment;
    $d->pg_request = json_encode($result);
    $d->expired_date = date('Y-m-d H:i:s', strtotime("+ 6 HOUR"));
    $d->save();
    header('Location: ' . $urlPayment);
    exit();
}

/*
*/

function paypal_payment_notification()
{
    // Not yet implemented
    die('OK');
}

function paypal_get_status($trx, $user)
{
    $capture = [];
    if (empty($trx->pg_paid_response)) {
        $capture = paypal_capture_transaction($trx['gateway_trx_id']);
    } else {
        $capture = json_decode($trx->pg_paid_response, true)['paypal_capture'];
        if (empty($capture)) {
            $capture = paypal_capture_transaction($trx['gateway_trx_id']);
        }
    }
    $result = json_decode(Http::getData(paypal_get_server() . 'checkout/orders/' . $trx['gateway_trx_id'], ['Authorization: Bearer ' . paypalGetAccessToken()]), true);
    if (in_array($result['status'], ['APPROVED', 'COMPLETED']) && $trx['status'] != 2) {
        if ($capture['status'] == 'COMPLETED' || ($capture['name'] == 'UNPROCESSABLE_ENTITY' && $capture['details'][0]['issue'] == 'ORDER_ALREADY_CAPTURED')) {
            if (!Package::rechargeUser($user['id'], $trx['routers'], $trx['plan_id'], $trx['gateway'], 'Paypal')) {
                r2(U . "order/view/" . $trx['id'], 'd', "Failed to activate your Package, try again later.");
            }
            $result['paypal_capture'] = json_encode($capture);
            $trx->pg_paid_response = json_encode($result);
            $trx->payment_method = 'PAYPAL';
            $trx->payment_channel = 'paypal';
            $trx->paid_date = date('Y-m-d H:i:s', strtotime($result['updated']));
            $trx->status = 2;
            $trx->save();
            r2(U . "order/view/" . $trx['id'], 's', "Transaction has been paid.");
        } else {
            r2(U . "order/view/" . $trx['id'], 'e', "Transaction Success, but not yet captured.");
        }
    } else if ($result['status'] == 'VOIDED') {
        $trx->pg_paid_response = json_encode($result);
        $trx->status = 3;
        $trx->save();
        r2(U . "order/view/" . $trx['id'], 'd', "Transaction expired.");
    } else {
        sendTelegram("xendit_get_status: unknown result\n\n" . json_encode($result, JSON_PRETTY_PRINT));
        r2(U . "order/view/" . $trx['id'], 'w', "Transaction status :" . $result['status']);
    }
}

function paypal_capture_transaction($trx_id)
{
    return json_decode(
        Http::postJsonData(
            paypal_get_server() . 'checkout/orders/' . $trx_id . '/capture',
            [],
            [
                'PayPal-Partner-Attribution-Id: &lt;BN-Code&gt;',
                'Authorization: Bearer ' . paypalGetAccessToken()
            ]
        ),
        true
    );
}

function paypalGetAccessToken()
{
    global $config;
    $result = Http::postData(str_replace('v2', 'v1', paypal_get_server()) . 'oauth2/token', [
        "grant_type" => "client_credentials"
    ], [], $config['paypal_client_id'] . ":" . $config['paypal_secret_key']);
    $json = json_decode($result, true);
    return $json['access_token'];
}


function paypal_get_server()
{
    global $_app_stage;
    if ($_app_stage == 'Live') {
        return 'https://api-m.paypal.com/v2/';
    } else {
        return 'https://api-m.sandbox.paypal.com/v2/';
    }
}
