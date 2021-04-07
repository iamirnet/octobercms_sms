<?php


namespace iAmirNet\SMS\Models;

use Model;

class SMSGatewaySettings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];
    public $settingsCode = 'iamirnet_services_settings';
    public $settingsFields = '$/iamirnet/sms/models/settings/fields_gateway.yaml';


    public function getFieldConfig()
    {
        $config = parent::getFieldConfig();
        $gateway = self::get('sms_gateway') ? : 'cuphost';
        $config->fields = array_merge($config->fields, $this->makeConfig("$/iamirnet/sms/models/settings/fields_$gateway.yaml")->fields);
        return $config;
    }
}
