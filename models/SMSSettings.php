<?php


namespace iAmirNet\SMS\Models;

use Model;

class SMSSettings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];
    public $settingsCode = 'iamirnet_services_settings';
    public $settingsFields = '$/iamirnet/sms/models/settings/fields_sms.yaml';
}