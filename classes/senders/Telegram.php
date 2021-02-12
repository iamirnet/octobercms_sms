<?php


namespace iAmirNet\SMS\Classes\Senders;


use iAmirNet\SMS\Models\SMSGatewaySettings;

class Telegram extends \iAmirNet\SMS\Gateways\Telegram
{
    public static $use_pattern = false;
    public $footer = null;
    public function __construct(array $options = [])
    {
        $this->footer = (string) SMSGatewaySettings::get('telegram_footer');
        parent::__construct([
            'key' => SMSGatewaySettings::get('telegram_api_token'),
            'sender' => SMSGatewaySettings::get('telegram_from_number'),
        ]);
    }


    public static function sendSMS($receiver, $message) {
        return (new self([]))->sendMSG($receiver, $message);
    }

    public function sendMSG($receiver, $message) {
        if ($this->footer)
            $message .= "\n" . $this->footer;
        return $this->send('sendMessage', [
            'chat_id' => $this->chatId,
            'text' => $message,
            'parse_mode' => "html"
        ]);
    }
}