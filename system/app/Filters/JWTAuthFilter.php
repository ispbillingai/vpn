<?php
namespace App\Filters;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Exception;

class JWTAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        try {
            helper('jwt');
            $user = jwtValidateRequest(jwtRequest($request->getServer('HTTP_AUTHORIZATION')));
            $permission = jwtApiPermission($user['group']);
            $segment = $request->uri->getSegment(2);
            $method = $request->getMethod();
            $allow = false;
            foreach($permission as $item){
                if($item[1] == $segment && $item[2] == $method){
                    $allow = $item[4];
                    break;
                }
            } 
            if($allow){
                return $request;
            }else{
                return Services::response()->setJSON(['error' => 'Does not have access permission.'])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            }
        } catch (Exception $e) {
            return Services::response()->setJSON(['error' => $e->getMessage()])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}