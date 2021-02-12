<?php

namespace iAmirNet\SMS\Classes\Senders;

use iAmirNet\SMS\Models\SMSGatewaySettings;

class Kavenegar extends \iAmirNet\SMS\Gateways\Kavenegar
{
    public static $use_pattern = false;

    public function __construct(array $options = [])
    {
        parent::__construct([
            'key' => SMSGatewaySettings::get('kavenegar_api_token'),
            'sender' => SMSGatewaySettings::get('kavenegar_from_number'),
            'footer' => SMSGatewaySettings::get('kavenegar_footer'),
        ]);
    }

    public static function sendSMS($receiver, $message)
    {
        return (new self([]))->send(...func_get_args());
    }
}