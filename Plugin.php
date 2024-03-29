<?php namespace iAmirNet\SMS;

use Azarinweb\User\Models\User;
use System\Classes\PluginBase;

require_once "updates/user_add_verify_mobile_field.php";
require_once "updates/create_i_amir_sms_bridges.php";

class Plugin extends PluginBase
{
    /**
     * @var boolean Determine if this plugin should have elevated privileges.
     */
    public $elevated = true;

    public function pluginDetails()
    {
        return [
            'name'        => 'iamirnet.sms::lang.plugin.name',
            'description' => 'iamirnet.sms::lang.plugin.description',
            'author'      => 'iamirnet',
            'icon'        => 'icon-user',
            'homepage'    => 'https://iAmir.Net'
        ];
    }

    public function boot()
    {
        $this->extendModels();
        $this->extendControllers();
        (new \iAmirNet\SMS\Updates\CreateIAmirSmsBridges())->up();
        /*(new \iAmirNet\SMS\Updates\UserAddVerifyMobileField())->up();*/
        /*if (\iAmirNet\SMS\Classes\Sender::get('verify'))
            \App::after(function ($app) {
                $user =  \Auth::getUser();
                if ($user && (!$user->mobile || $user->mobile != $user->mobile_verified_num)) {
                    if (!ends_with(\Request::url(), ['/mobile', '/login'])){
                        header("Location: /mobile");
                        die();
                    }
                }
            });*/
    }

    public function register()
    {
        parent::register(); // TODO: Change the autogenerated stub
    }

    public function registerPermissions()
    {
        return [
            'iamirnet.sms.access_sms' => [
                'tab'   => 'iamirnet.sms::lang.plugin.tab',
                'label' => 'iamirnet.sms::lang.plugin.access_sms'
            ],
        ];
    }

    public function registerSettings()
    {
        return [
            'gateway_settings' => [
                'label'       => 'iamirnet.sms::lang.gateway.title',
                'description' => 'iamirnet.sms::lang.gateway.description',
                'category'    => 'iamirnet.minimall::lang.settings.sms.title',
                'icon'        => 'icon-cog',
                'class'       => \iAmirNet\SMS\Models\SMSGatewaySettings::class,
                'order'       => 800,
                'permissions' => ['iamirnet.sms.access_sms']
            ],
            'settings' => [
                'label'       => 'iamirnet.sms::lang.sms.title',
                'description' => 'iamirnet.sms::lang.sms.description',
                'category'    => 'iamirnet.minimall::lang.settings.sms.title',
                'icon'        => 'icon-cog',
                'class'       => \iAmirNet\SMS\Models\SMSSettings::class,
                'order'       => 800,
                'permissions' => ['iamirnet.sms.access_sms']
            ],
        ];
    }

    public function registerComponents()
    {
        return [
            \iAmirNet\SMS\Components\Verify::class  => 'verifyMobile',
            \iAmirNet\SMS\Components\Authentication::class  => 'iAuthentication',
        ];
    }

    protected function extendModels()
    {
        User::extend(function($model) {
            $model->addFillable(['mobile_verify_time','mobile_verified_time','mobile_verify_code','mobile_verified_num','mobile_verify_count']);
        });
    }

    protected function extendControllers()
    {

    }
}
