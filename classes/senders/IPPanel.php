<?php

namespace iAmirNet\SMS\Classes\Senders;

use iAmirNet\SMS\Models\SMSGatewaySettings;
use iAmirNet\SMS\Traits\SetTextToPattern;

class IPPanel extends \iAmirNet\SMS\Gateways\IPPanel
{
    use SetTextToPattern;
    public static $use_pattern = true;

    public function __construct(array $options = [])
    {
        parent::__construct([
            'token' => SMSGatewaySettings::get('cuphost_api_token'),
            'sender' => SMSGatewaySettings::get('cuphost_from_number'),
            'sender_pattern' => SMSGatewaySettings::get('cuphost_from_number_pattern'),
            'footer' => SMSGatewaySettings::get('cuphost_footer'),
        ]);
    }

    public static function _sendSMSPattern($pattern, $receiver, $message, $sender = null)
    {
        return (new self([]))->sendByPattern(...func_get_args());
    }

    public static function _sendSMS($receiver, $message)
    {
        return (new self([]))->send(...func_get_args());
    }
}
