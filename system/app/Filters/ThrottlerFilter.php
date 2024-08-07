<?php
namespace App\Filters;

use App\Models\SettingsModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Exception;

class ThrottlerFilter implements FilterInterface
{
    use ResponseTrait;
    public function before(RequestInterface $request, $arguments = null)
    {
        try {
            $throttler = Services::throttler();
            $ip = $request->getIPAddress();
            $settingsBase = new SettingsModel();
            $settings = $settingsBase->first()??[];
            if(!$settings['enable_api']){
                return Services::response()->setJSON(['error' => 'ApiRest is currently disabled.'])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            }
            if($settings['block_external_api']){
                if($ip != $settings['ip_allowed_api']??''){
                    return Services::response()->setJSON(['error' => 'Endpoint access from external domains is not allowed.'])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
                }
                if ($throttler->check(md5($ip), 60, MINUTE) === false)
                {
                    return Services::response()->setStatusCode(429);
                }
            }
        } catch (Exception $e) {
            return Services::response()->setJSON(['error' => $e->getMessage()])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}