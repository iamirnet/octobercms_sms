<?php


namespace iAmirNet\SMS\Classes;


use Azarinweb\Minimall\Models\User;
use iAmirNet\SMS\Models\SMSGatewaySettings;
use iAmirNet\SMS\Models\SMSSettings;

class Sender
{
    public static function get($method, $error = false)
    {
        if (SMSSettings::get("sms_option_$method") == 'inactive')
            if ($error) {
                throw new \InvalidArgumentException(trans('iamirnet.sms::lang.messages.inactive'));
            } else
                return false;
        switch (SMSGatewaySettings::get("sms_gateway")) {
            case "kavenegar":
                $class = [
                    'class' => new Senders\Kavenegar(),
                    'pattern' => false
                ];
                break;
            default:
                $class = [
                    'class' => new Senders\IPPanel(),
                    'pattern' => SMSGatewaySettings::get("cuphost_pattern_$method")
                ];
                break;
        }
        return (object) $class;
    }

    public static function send($method, $data, $user, $is_mobile = false) {
        if ($sender = self::get($method)){
            $user = $is_mobile ? $user : (is_int($user) ? User::findOrFail($user) : $user);
            $pattern = $sender->pattern ? : $data;
            $message = is_array($pattern) ? trans("iamirnet.sms::lang.patterns.$method") : $data;
            $result = $sender->class->sendByPattern($pattern, $is_mobile ? $user : $user->mobile, $message);
            return $result['status'];
        }
        return false;
    }
}
