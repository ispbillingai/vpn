<?php
require_once 'config.php';
require_once 'vendor/autoload.php';
require_once 'system/orm.php';
require_once 'system/autoload/PEAR2/Autoload.php';
include "system/autoload/Hookers.php";

ORM::configure("mysql:host=$db_host;dbname=$db_name");
ORM::configure('username', $db_user);
ORM::configure('password', $db_password);
ORM::configure('return_result_sets', true);
ORM::configure('logging', true);

// Function to manage log file lines
function logToFile($filePath, $message, $maxLines = 5000) {
    $lines = file_exists($filePath) ? file($filePath, FILE_IGNORE_NEW_LINES) : [];
    $lines[] = '[' . date('Y-m-d H:i:s') . '] ' . $message;
    if (count($lines) > $maxLines) {
        $lines = array_slice($lines, count($lines) - $maxLines);
    }
    file_put_contents($filePath, implode(PHP_EOL, $lines) . PHP_EOL);
}

// Function to log payment gateway details
function logToPaymentGateway($username, $paymentMethod, $gateway, $planId, $routerId) {
    $Planname = ORM::for_table('tbl_plans')
        ->where('id', $planId)
        ->order_by_desc('id')
        ->find_one();
    $Findrouter = ORM::for_table('tbl_routers')
        ->where('id', $routerId)
        ->order_by_desc('id')
        ->find_one();
    $rname = $Findrouter->name;
    $price = $Planname->price;
    $Planname = $Planname->name_plan;

    $Checkorders = ORM::for_table('tbl_payment_gateway')
        ->where('username', $username)
        ->where('status', 1)
        ->order_by_desc('id')
        ->find_many();
    if ($Checkorders) {
        foreach ($Checkorders as $Dorder) {
            $Dorder->delete();
        }
    }

    $d = ORM::for_table('tbl_payment_gateway')->create();
    $d->username = $username;
    $d->gateway = $gateway;
    $d->plan_id = $planId;
    $d->plan_name = $Planname;
    $d->routers_id = $routerId;
    $d->routers = $rname;
    $d->price = $price;
    $d->payment_method = $paymentMethod;
    $d->payment_channel = $gateway;
    $d->created_date = date('Y-m-d H:i:s');
    $d->paid_date = date('Y-m-d H:i:s');
    $d->expired_date = date('Y-m-d H:i:s');
    $d->pg_url_payment = '';
    $d->status = 1;
    $d->save();
}

// Function to send data to add_stripe_user.php using cURL
function sendToAddStripeUser($data) {
    $url = 'https://aurius.freeispradius.com/add_stripe_user.php'; // Adjust the URL accordingly
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

// Read the raw JSON input
$rawInput = file_get_contents('php://input');

// Log the raw JSON input to the log file
$logFilePath = 'create_stripe_user.log';
logToFile($logFilePath, "Raw JSON input: $rawInput");

// Parse JSON input
$input = json_decode($rawInput, true);

// Extract data from JSON input
$phone = isset($input['phone_number']) ? $input['phone_number'] : '';
$planId = isset($input['plan_id']) ? $input['plan_id'] : '';
$routerId = isset($input['router_id']) ? $input['router_id'] : '';
$username = isset($input['username']) ? $input['username'] : $phone; // Use input username directly if provided
$fullName = isset($input['full_name']) ? $input['full_name'] : '';
$email = isset($input['email']) ? $input['email'] : '';
$address = isset($input['address']) ? $input['address'] : '';

// Log the extracted data to the error log
logToFile($logFilePath, "Received data: phone: $phone, planId: $planId, routerId: $routerId, username: $username, full_name: $fullName, email: $email, address: $address");

header('Content-Type: application/json'); // Ensure JSON content type header

if ($phone) { // Proceed if phone number is provided
    $Userexist = ORM::for_table('tbl_customers')->where('username', $username)->find_one();
    if ($Userexist) {
        // Update the router ID for the existing user
        $Userexist->router_id = $routerId;
        $Userexist->save();

        $success_message = 'User already exists and router ID updated';
        logToFile($logFilePath, "Success: $success_message");

        // Log payment gateway details
        logToPaymentGateway($username, 'Stripe Card', 'Stripe', $planId, $routerId);

        // Send data to add_stripe_user.php
        $addStripeResponse = sendToAddStripeUser($input);
        logToFile($logFilePath, "Sent to add_stripe_user.php: $addStripeResponse");

        echo json_encode(['status' => 'success', 'message' => 'Operation completed']);
        exit();
    }

    $defpass = '1234';

    $createUser = ORM::for_table('tbl_customers')->create();
    $createUser->username = $username; // Use input username directly
    $createUser->password = $defpass;
    $createUser->fullname = $fullName; // Use the full name from input
    $createUser->phonenumber = $phone;
    $createUser->pppoe_password = $defpass;
    $createUser->address = $address; // Use the address from input
    $createUser->email = $email; // Use the email from input
    $createUser->service_type = 'Hotspot';
    $createUser->router_id = $routerId;

    if ($createUser->save()) {
        $success_message = 'User created successfully';
        logToFile($logFilePath, "Success: $success_message");

        // Log payment gateway details
        logToPaymentGateway($username, 'Stripe Card', 'Stripe', $planId, $routerId);

        // Send data to add_stripe_user.php
        $addStripeResponse = sendToAddStripeUser($input);
        logToFile($logFilePath, "Sent to add_stripe_user.php: $addStripeResponse");

        echo json_encode(['status' => 'success', 'message' => 'Operation completed']);
        exit();
    } else {
        $error_message = 'There was a system error when registering user, please contact support';
        logToFile($logFilePath, "Error: $error_message");
        echo json_encode(['status' => 'error', 'message' => 'An error occurred']);
        exit();
    }
} else {
    $error_message = 'Phone number is required';
    logToFile($logFilePath, "Error: $error_message");
    echo json_encode(['status' => 'error', 'message' => 'Phone number is required']);
    exit();
}
?>
