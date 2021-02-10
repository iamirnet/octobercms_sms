<?php


namespace iAmirNet\SMS\Classes;


use Azarinweb\Minimall\Models\User;

class Notifications
{
    public static function sendForOrder($order) {
        $user = User::findOrFail($order->customer->user_id);
        return Kavenegar::sendSMS("پرداخت شما به شماره فاکتور {$order->id} با موفقیت پرداخت شد.", $user->mobile);
    }
}