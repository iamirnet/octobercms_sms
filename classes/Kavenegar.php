<?php

namespace iAmirNet\SMS\Classes;

use iAmirNet\SMS\Models\SMSSettings;
use GuzzleHttp\Client;

class Kavenegar
{

    public $api_token = null;
    public $from_number = null;
    public $url = "https://api.kavenegar.com/v1/";
    public $footer = null;

    public function __construct()
    {
        $this->api_token = SMSSettings::get('kevenegar_api_token');
        $this->url .= $this->api_token . "/";
        $this->from_number = (string) SMSSettings::get('kevenegar_from_number');
        $this->footer = (string) SMSSettings::get('kavenegar_footer');
    }

    public function send($message, $mobile)
    {
        if ($this->footer)
            $message .= "\n" . $this->footer;
        $http = $this->http("sms/send.json",[
            'receptor' => $mobile,
            'message' => $message,
            'sender' => $this->from_number,
        ]);
        return true;
    }

    public static function sendSMS($message, $mobile)
    {
        return (new self())->send(...func_get_args());
    }

    public function http($url, $data) {
        $headers       = array(
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded',
            'charset: utf-8'
        );
        $fields_string = "";
        if (!is_null($data)) {
            $fields_string = http_build_query($data);
        }
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $this->url . $url);
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $fields_string);

        $response     = curl_exec($handle);
        $code         = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        $content_type = curl_getinfo($handle, CURLINFO_CONTENT_TYPE);
        $curl_errno   = curl_errno($handle);
        $curl_error   = curl_error($handle);
        if ($curl_errno) {
            throw new HttpException($curl_error, $curl_errno);
        }
        $json_response = json_decode($response);
        if ($code != 200 && is_null($json_response)) {
            throw new HttpException("Request have errors", $code);
        } else {
            $json_return = $json_response->return;
            if ($json_return->status != 200) {
                throw new ApiException($json_return->message, $json_return->status);
            }
            return $json_response->entries;
        }

    }
}