<?php

namespace App\Validation;

use App\Libraries\PasswordHash;
use App\Models\SettingsModel;
use App\Models\UserModel;
use Exception;

class ApiAuthRules
{
    public function validateAuthPassword(string $str, string $fields, array $data): bool
    {
        try {
            $user_model = new UserModel();
            $obj = $user_model->where('email',$data['email'])->first();
            $phpass = new PasswordHash(8, true);
            return $phpass->CheckPassword($data['password']??'', $obj['password']);
        } catch (Exception $e) {
            return false;
        }
    }

    public function validateAuthPermission(string $str, string $fields, array $data): bool
    {
        try {
            $user_model = new UserModel();
            $settings_model = new SettingsModel();
            $settings = $settings_model->first()??[];
            $obj = $user_model->where('email',$data['email'])->first();
            return $obj['email'] != null ? true : false;
        } catch (Exception $e) {
            return false;
        }
    }
}