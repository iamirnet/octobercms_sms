<?php


namespace iAmirNet\SMS\Classes;


class Telegram
{
    public $token = '';
    public $chatId = "";

    public static function sendSMS($messgae) {
        return (new self())->sendMSG($messgae);
    }

    public function sendMSG($messgae) {
        return $this->send('sendMessage', [
            'chat_id' => $this->chatId,
            'text' => $messgae,
            'parse_mode' => "html"
        ]);
    }

    public function send($method, $datas = [])
    {
        $url = "https://api.telegram.org/bot" . $this->token . "/" . $method;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
        $res = curl_exec($ch);
        if (curl_error($ch)) {
            return false;
        } else {
            return true;
        }
    }
}