<?php

use App\Models\SettingsModel;
use App\Models\UserModel;
use Firebase\JWT\JWT;

/**
 * Receives JWT authentication header and returns a string.
 * @access public
 * @param string $authHeader
 * @return string
 */
if(!function_exists('jwtRequest')) {
    function jwtRequest($authHeader){
        if (is_null($authHeader)) {
            throw new Exception('Missing or invalid jwt access token.');
        }
        return explode(' ', $authHeader)[1];
    }
}

/**
 * Validates the token by decrypting and checking the database.
 * @access public
 * @param string $token
 * @return array
 */
if(!function_exists('jwtValidateRequest')) {
    function jwtValidateRequest(string $token)
    {
        $settingsBase = new SettingsModel();
        $settings = $settingsBase->first()??[];
        $decode = JWT::decode($token, $settings['jwt_private_key']??'', ['HS256']);
        $userModel = new UserModel();
        return $userModel->where('email', $decode->email)->first();
    }
}

/**
 * Validate user permissions.
 * @access public
 * @param string $group
 * @return array
 */
if(!function_exists('jwtApiPermission')) {
    function jwtApiPermission(string $group)
    {
        $settingsBase = new SettingsModel();
        $settings = $settingsBase->first()??[];
        return json_decode(str_replace('&quot;','"',$settings['group_api']),true)[$group];
    }
}

/**
 * Signs a new token.
 * @access public
 * @param string $email
 * @return string
 */
if(!function_exists('jwtSignature')) {
    function jwtSignature(string $email)
    {
        $settingsBase = new SettingsModel();
        $settings = $settingsBase->first()??[];
        $time = time();
        $expiration = $time + (intval($settings['jwt_token_lifetime']??0) * 60);
        $payload = [
            'email' => $email,
            'iat' => $time,
            'exp' => $expiration,
        ];
        return JWT::encode($payload, $settings['jwt_private_key']??'');
    }
}