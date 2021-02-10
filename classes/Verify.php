<?php

namespace iAmirNet\SMS\Classes;

use Azarinweb\User\Models\User;

class Verify
{
    public $sender = null;
    public $user = null;
    public $verify = null;
    public $verified = null;
    public $code = null;
    public $v_mobile = null;
    public $v_num = null;

    public function __construct($user)
    {
        $this->sender = Kavenegar::class;
        if ($user){
            $this->user = $user;
            $this->verify = $user->mobile_verify_time;
            $this->verified = $user->mobile_verified_time;
            $this->code = $user->mobile_verify_code;
            $this->v_mobile = $user->mobile_verified_num;
            $this->v_num = $user->mobile_verify_count;
        }
    }

    public static function call($user, $mobile) {
        return (new self($user))->send($mobile);
    }

    public static function handel($user, $code) {
        return (new self($user))->check($code);
    }

    public function send($mobile)
    {
        if ($mobile) {
            if ($mobile == $this->v_mobile)
                $error = 'شماره موبایل متفاوت باید وارد کنید.';
            else if (User::where('mobile_verified_num', $mobile)->first())
                $error = 'شماره قبلا برای کاربر دیگر ثبت و تایید شده است.';
            elseif ($this->verified && (int) $this->verified + 3600 > time()) {
                $error = 'بین هر تغییر شماره موبایل و تایید آن حداقل یک ساعت صبر کنید و شکیبا باشید.';
            } elseif ($this->v_num && $this->v_num < 3 && ((int) $this->verify + 60 > time())) {
                $error = 'بین هر ارسال حداقل یک دقیقه صبر کنید و شکیبا باشید.';
            } elseif ($this->v_num && $this->v_num < 3 && ((int) $this->verify + 600 > time())) {
                $error = 'شما سه بار کد را فرستادید و تا ده دقیقه دیگر باید صبر کنید.';
            } else {
                $code = rand(123456, 655357);
                $send = $this->sendCode($mobile, $code);
                if ($send) {
                    $this->verify = time();
                    $this->v_num = $this->v_num >= 3 ? 0 : $this->v_num + 1;
                    $this->code = $code;
                    $this->user->update([
                        "mobile" => $mobile,
                        "mobile_verify_time" => $this->verify,
                        "mobile_verified_time" => null,
                        "mobile_verify_code" => $this->code,
                        "mobile_verify_count" => $this->v_num,
                    ]);
                    $success = 'کد با موفقیت ارسال شد.';
                } else
                    $error = 'کد ارسال نشد.';
            }
        }else
            $error = 'شماره موبایل وارد نشده است.';
        return array('status' => isset($success), 'msg' => isset($success) ? $success : $error);
    }

    public function check($code)
    {
        $mobile = $this->user->mobile;
        if ($mobile && $code && !$this->verified) {
            if ($this->verify + 600 < time()) {
                $this->user->update([
                    "mobile_verify_time" => 0,
                    "mobile_verify_code" => null,
                    "mobile_verify_count" => 0,
                ]);
                $error = 'متاسفانه زمان کد منقضی شده، لطفا مجدد کد را به همراه خود ارسال کنید.';
            } else {
                $this->user->update([
                    "mobile_verify_time" => null,
                    "mobile_verified_time" => time(),
                    "mobile_verified_num" => $mobile,
                    "mobile_verify_code" => null,
                    "mobile_verify_count" => null,
                ]);
                $success = 'شماره موبایل شما تایید شد.';
            }
        } else
            $error = 'کد تایید وارد شده اشتباه است.';
        return array('status' => isset($success) ? true : false, 'msg' => isset($success) ? $success : $error);
    }

    public function sendCode($mobile, $code) {
        return $this->sender::sendSMS('کد تایید شما: '.$code,$mobile);
    }
}
