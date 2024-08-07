<?php

namespace App\Controllers;

use App\Libraries\PasswordHash;
use App\Models\SettingsModel;
use App\Models\UserModel;
use App\Models\UserOauthModel;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Validation\Exceptions\ValidationException;
use Config\Services;

class Api extends ResourceController
{
    private $user_model;
    private $oauth_model;
    private $settings_model;
    private $data_format;

    function __construct()
    {
        $this->user_model = new UserModel();
        $this->oauth_model = new UserOauthModel();
        $this->settings_model = new SettingsModel();
        $this->data_format = getenv('api.return')??'json';
    }

    public function index()
    {
        return $this->response->setJSON([
            'message' => 'Welcome!'
        ]);
    }

    public function status()
    {
        return $this->response->setJSON([
            'status' => true,
            'message' => 'The system is running!'
        ]);
    }

    public function signIn()
    {
        $rules = [
            'email' => 'required|valid_email|validateAuthPermission[email]',
            'password' => 'required|validateAuthPassword[email, password]'
        ];
        $errors = [
            'email' => [
                'required'    => 'The email field is required.',
                'valid_email' => 'Invalid email.',
                'validateAuthPermission' => 'This user {value} does not have access permission.'
            ],
            'password' => [
                'required'             => 'The password field is required.',
                'validateAuthPassword' => 'Invalid password.'
            ]
        ];
        $input = $this->baseRequest($this->request);
        $input = json_decode(json_encode($input),true);
        if (!$this->baseValidateRequest($input, $rules, $errors)) {
            return $this->baseResponse($this->validator->getErrors(),ResponseInterface::HTTP_BAD_REQUEST);
        }
        return $this->generateCredential($input['email']);
    }

    private function generateCredential(string $email, int $responseCode = ResponseInterface::HTTP_OK){
        try {
            helper('jwt');
            return $this->baseResponse([
                'access_token' => jwtSignature($email)
            ]);
        } catch (\Exception $exception) {
            return $this->baseResponse(['error' => $exception->getMessage()], $responseCode);
        }
    }

    private function baseResponse(array $responseBody, int $code = ResponseInterface::HTTP_OK)
    {
        if($this->data_format == 'json'){
            return $this->response->setStatusCode($code)->setJSON($responseBody)??'';
        }else{
            return $this->response->setStatusCode($code)->setXML($responseBody)??'';
        }
    }

    private function baseRequest(IncomingRequest $request){
        return $request->getVar()??[];
    }

    private function baseValidateRequest(array $input, array $rules, array $messages = []) {
        $this->validator = Services::Validation()->setRules($rules);
        if (is_string($rules)) {
            $validation = config('Validation');
            if (!isset($validation->$rules)) {
                throw ValidationException::forRuleNotFound($rules);
            }
            if (!$messages) {
                $errorName = $rules . '_errors';
                $messages = $validation->$errorName ?? [];
            }
            $rules = $validation->$rules;
        }
        return $this->validator->setRules($rules, $messages)->run($input);
    }

    public function user($method = null, $key = null)
    {
        switch ($method):
            /**
             * Return all users.
             */
            case 'all':
                try {
                    $data = $this->user_model->select('token,first_name,last_name,date_birth,email,mobile,picture,language,address,address,state,country,zip_code,status,created_at,updated_at')->findAll()??[];
                    return $this->setResponseFormat($this->data_format)->respond($data);
                } catch (\Exception $exception) {
                    return $this->setResponseFormat($this->data_format)->respond([
                        'error' => true,
                        'message' => $exception->getMessage()
                    ]);
                }
            /**
             * Return user for token id.
             */
            case 'id':
                try {
                    $data = $this->user_model->select('token,first_name,last_name,date_birth,email,mobile,picture,language,address,address,state,country,zip_code,status,created_at,updated_at')->where('token',$key)->first()??[];
                    return $this->setResponseFormat($this->data_format)->respond($data);
                } catch (\Exception $exception) {
                    return $this->setResponseFormat($this->data_format)->respond([
                        'error' => true,
                        'message' => $exception->getMessage()
                    ]);
                }
            /**
             * Return add user.
             */
            case 'add':
                try {
                    $body = $this->request->getVar() == [] ? (array) $this->request->getJSON() : $this->request->getVar();
                    if(empty($body["first_name"]??"")){
                        return $this->setResponseFormat($this->data_format)->respond([
                            'error' => true,
                            'message' => 'The first name parameter is null or empty.'
                        ]);
                    }
                    if(empty($body["last_name"]??"")){
                        return $this->setResponseFormat($this->data_format)->respond([
                            'error' => true,
                            'message' => 'The last name parameter is null or empty.'
                        ]);
                    }
                    if(empty($body["email"]??"")){
                        return $this->setResponseFormat($this->data_format)->respond([
                            'error' => true,
                            'message' => 'The email parameter is null or empty.'
                        ]);
                    }else{
                        $validate = $this->user_model->where('email',$body["email"]??"")->countAllResults();
                        if($validate > 0){
                            return $this->setResponseFormat($this->data_format)->respond([
                                'error' => true,
                                'message' => 'Email already registered!'
                            ]);
                        }
                    }
                    if(empty($body["password"]??"")){
                        return $this->setResponseFormat($this->data_format)->respond([
                            'error' => true,
                            'message' => 'The password parameter is null or empty.'
                        ]);
                    }else{
                        if(strlen($body["password"]??"") < 8){
                            return $this->setResponseFormat($this->data_format)->respond([
                                'error' => true,
                                'message' => 'Password must be at least 8 characters long.'
                            ]);
                        }
                    }
                    $settings = $this->settings_model->first()??[];
                    $phpass = new PasswordHash(8, true);
                    $token = md5(uniqid(rand(), true));
                    $this->user_model->save([
                        'group' => $settings['default_role'],
                        'first_name' => $body['first_name'],
                        'last_name' => $body['last_name'],
                        'mobile' => '',
                        'picture' => '/assets/img/default-user.png',
                        'email' => $body['email'],
                        'password' => $phpass->HashPassword($body['password']),
                        'last_access' => date('Y-m-d h:i:s'),
                        'last_ip' => '::1',
                        'language' => $settings['default_language'],
                        'token' => $token,
                        'status' => true
                    ]);
                    $data = $this->user_model->select('token,first_name,last_name,date_birth,email,mobile,picture,language,address,address,state,country,zip_code,status,created_at,updated_at')->where('token',$token)->first()??[];
                    return $this->setResponseFormat($this->data_format)->respond([
                        'error' => false,
                        'message' => 'Added successfully!',
                        'data' => $data??[]
                    ]);
                } catch (\Exception $exception) {
                    return $this->setResponseFormat($this->data_format)->respond([
                        'error' => true,
                        'message' => $exception->getMessage()
                    ]);
                }
            /**
             * Return edit user.
             */
            case 'edit':
                try {
                    $data = $this->user_model->where('token',$key)->first()??[];
                    if($data == []){
                        return $this->setResponseFormat($this->data_format)->respond([
                            'error' => true,
                            'message' => 'User not found!'
                        ]);
                    }
                    $body = $this->request->getVar() == [] ? (array) $this->request->getJSON() : $this->request->getVar();
                    $this->user_model->save([
                        'id_user' => $data['id_user'],
                        'first_name' => empty($body["first_name"]??"")?$data['first_name']:$body["first_name"]??"",
                        'last_name' => empty($body["last_name"]??"")?$data['last_name']:$body["last_name"]??"",
                        'date_birth' => empty($body["date_birth"]??"")?$data['date_birth']:$body["date_birth"]??"",
                        'address' => empty($body["address"]??"")?$data['address']:$body["address"]??"",
                        'city' => empty($body["city"]??"")?$data['city']:$body["city"]??"",
                        'state' => empty($body["state"]??"")?$data['state']:$body["state"]??"",
                        'country' => empty($body["country"]??"")?$data['country']:$body["country"]??"",
                        'zip_code' => empty($body["zip_code"]??"")?$data['zip_code']:$body["zip_code"]??"",
                        'mobile' => empty($body["mobile"]??"")?$data['mobile']:$body["mobile"]??"",
                        'status' => empty($body["status"]??"")?$data['status']:$body["status"]??""
                    ]);
                    $data = $this->user_model->select('token,first_name,last_name,date_birth,email,mobile,picture,language,address,address,state,country,zip_code,status,created_at,updated_at')->where('token',$key)->first()??[];
                    return $this->setResponseFormat($this->data_format)->respond([
                        'error' => false,
                        'message' => 'Successfully Edited!',
                        'data' => $data??[]
                    ]);
                } catch (\Exception $exception) {
                    return $this->setResponseFormat($this->data_format)->respond([
                        'error' => true,
                        'message' => $exception->getMessage()
                    ]);
                }
            /**
             * Return delete user.
             */
            case 'delete':
                try {
                    $this->user_model->where('token', $key)->delete();
                    $this->oauth_model->where('user', $key)->delete();
                    return $this->setResponseFormat($this->data_format)->respond([
                        'error' => false,
                        'message' => 'Successfully deleted!'
                    ]);
                } catch (\Exception $exception) {
                    return $this->setResponseFormat($this->data_format)->respond([
                        'error' => true,
                        'message' => $exception->getMessage()
                    ]);
                }
            /**
             * Return Default.
             */
            default:
                return $this->setResponseFormat($this->data_format)->respond([
                    'error' => true,
                    'message' => 'Method call is invalid.'
                ]);
        endswitch;
    }
}
