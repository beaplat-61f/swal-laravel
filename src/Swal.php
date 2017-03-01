<?php 
namespace Beaplat\Swal;

use Illuminate\Session\SessionManager;
use Illuminate\Config\Repository;

class Swal
{
    /**
     * @var SessionManager
     */
    protected $session;

    /**
     * @var Repository
     */
    protected $config;

    /**
     * @var array
     */
    protected $notifications = [];

    /**
     * Swal constructor.
     * @param SessionManager $session
     * @param Repository $config
     */
    public function __construct(SessionManager $session, Repository $config)
    {
        $this->session = $session;
        $this->config = $config;
    }

    public function render()
    {
        $notifications = $this->session->get('swal:notifications');
        if (!$notifications) {
            return '';
        }

        foreach ($notifications as $notification) {
            $config = $this->config->get('swal.options');
            $javascript = '';
            if ($config) {
                $javascript = "swal.setDefaults(". json_encode($config) ."); ";
            }
            $options = $notification['options'];
            $params = array_except($notification, 'options');

            // $text = str_replace("'", "\\'", $notification['message']);
            // $title = $notification['title'] ? str_replace("'", "\\'", $notification['title']) : null;
            if ($params) {
                $javascript .= "swal(". json_encode($params) .");";
            }

        }
        return view('SweetAlert::swal', compact('javascript'));
    }

    /**
     * Add notification
     * @param $type
     * @param $message
     * @param $title
     * @param array $options
     * @return bool
     */
    public function add($type, $title, $message = null, $options = [])
    {
        $types = ['info', 'warning', 'success', 'error', 'confirm', 'prompt'];
        if (!in_array($type, $types)) {
            return false;
        }

        $this->notifications[] = [
            'type' => $type,
            'title' => $title,
            'text' => $message,
            'options' => $options
        ];
        $this->session->flash('swal:notifications', $this->notifications);
    }

    /**
     * Add info notification
     * @param $message
     * @param null $title
     * @param array $options
     */
    public function info($title, $message = null, $options = [])
    {
        $this->add('info', $title, $message, $options);
    }

    /**
     * Add warning notification
     * @param $message
     * @param null $title
     * @param array $options
     */
    public function warning($title, $message = null, $options = [])
    {
        $this->add('warning', $title, $message, $options);
    }

    /**
     * Add success notification
     * @param $message
     * @param null $title
     * @param array $options
     */
    public function success($title, $message = null, $options = [])
    {
        $this->add('success', $title, $message, $options);
    }

    /**
     * Add error notification
     * @param $message
     * @param null $title
     * @param array $options
     */
    public function error($title, $message = null, $options = [])
    {
        $this->add('error', $title, $message, $options);
    }

    /**
     * Clear notifications
     */
    public function clear()
    {
        $this->notifications = [];
    }
}
