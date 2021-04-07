<?php


namespace iAmirNet\SMS\Classes\Senders;


use Azarinweb\Minimall\Models\Notification;


class MailSender
{
    public $enabledNotifications = [];

    public function __construct()
    {
        $this->enabledNotifications = Notification::getEnabled();
    }

    public static function send($code, $data, $email) {
        return (new self())->_send($code, $data, $email);
    }

    public function _send($code, $data, $email)
    {
        \Mail::send($code, $data, function ($message) use ($email) {$message->to($email);});
        return true;
    }

    protected function template($code)
    {
        return $this->enabledNotifications->get($code);
    }
}
