<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use App\Models\SettingsModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['general','jwt'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        $session = \Config\Services::session();

        // Language Validate
        $language = \Config\Services::language();
        $language->setLocale($session->lang);

        // Set TimeZone
        if(empty($session->get('settings'))){
            $settingsModel = new SettingsModel();
            $settings = $settingsModel->select('default_timezone')->first()??[];
            date_default_timezone_set($settings['default_timezone']??'America/Sao_Paulo');
        }else{
            date_default_timezone_set($session->get('settings')['default_timezone']??'America/Sao_Paulo');
        }

        // Get notification
        if(!empty($session->get('token'))) {
            $notificationModel = new NotificationModel();
            $pulse = $notificationModel->where('user_recipient',$session->get('token'))->where('is_read',false)->countAllResults() ?? 0;
            $notification = $notificationModel->select('token,title,is_read,created_at')->where('user_recipient',$session->get('token'))->orderBy('created_at','desc')->findAll(5) ?? [];
            $session->set('notification', $notification);
            $session->set('pulse', $pulse);
        }else{
            $session->set('notification', []);
            $session->set('pulse', 0);
        };
    }
}
