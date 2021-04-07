<?php


namespace iAmirNet\SMS\Classes;


class Notifications
{
    public static function OrderPaid($order) {
        $data = [
            'order' => $order->id,
        ];
        return Sender::send('order_paid', $data, $order->customer->user_id);
    }

    public static function OrderSent($order) {
        $data = [
            'link' => $order->tracking_url,
            'code' => $order->tracking_number,
        ];
        return Sender::send('order_sent', $data, $order->customer->user_id);
    }

    public static function VerifyCode($mobile, $code) {
        return Sender::send('verify', ['code' => (string) $code, 'name' => (string) $mobile], $mobile, true);
    }

    public static function Welcome($mobile, $name = '') {
        return Sender::send('welcome', ['name' => $name], $mobile, true);
    }
}
