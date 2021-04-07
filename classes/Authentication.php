<?php


namespace iAmirNet\SMS\Classes;



use Azarinweb\Minimall\Models\Customer;
use Azarinweb\User\Models\User;
use Carbon\Carbon;
use iAmirNet\SMS\Classes\Senders\MailSender;
use iAmirNet\SMS\Models\Bridge;
use Illuminate\Support\Facades\Hash;

class Authentication
{
    use Authentication\Call;

    public function _send($receiver) {
        $this->setReceiver($receiver);
        $this->setMethod(preg_match("/^09[0-9]{9}$/", $this->getReceiver()) ? 'mobile' : 'email');
        if (Bridge::where('method', $this->getMethod())->where('receiver', $this->getReceiver())->where('created_at', '>', Carbon::now()->subMinute())->first())
            return array('status' => false, 'msg' => trans('iamirnet.sms::lang.messages.code.sent_1m'));
        $this->setCode(rand(123456, 655357));;
        $send = $this->getMethod() == 'mobile' ? Notifications::VerifyCode($this->getReceiver(), $this->getCode()) : MailSender::send('iamir.sms::mail.auth.code', ['code' => $this->getCode()], $this->getReceiver());
        if ($send) {
            $this->setBridge();
            return array('status' => true, 'msg' => trans('iamirnet.sms::lang.messages.code.sent'), 'receiver' => $this->getReceiver(), 'hash' => $this->getHash());
        }else{
            $error = trans('iamirnet.sms::lang.messages.code.unsent');
        }
        return array('status' => false, 'msg' => $error);
    }

    public function _check($receiver, $code, $hash) {
        $this->setReceiver($receiver);
        $this->setMethod(preg_match("/^09[0-9]{9}$/", $this->getReceiver()) ? 'mobile' : 'email');
        $this->setCode($code);
        $this->setHash($hash);
        if ($this->getBridge()) {
            $user = User::where($this->getMethod(), $this->getBridge()->receiver)->first();
            $msg = trans('iamirnet.sms::lang.messages.auth.logged');
            if (!$user){
                $password = Hash::make($this->getReceiver() . time());
                $user = new User([$this->getMethod() => $this->getReceiver(), 'password' => $password, 'password_confirmation' => $password, 'is_activated' => 1]);
                $user->rules = [];
                $user->save(null, null);
                $customer = new Customer();
                $customer->rules = [];
                $customer->firstname = '';
                $customer->lastname = '';
                $customer->user_id = $user->id;
                $customer->is_guest = false;
                $customer->save();
                $user->is_activated=1;
                $user->save();
                $msg = trans('iamirnet.sms::lang.messages.auth.registered');
            }
            return array('status' => true, 'msg' => $msg, 'user' => $user);
        }else {
            $error = trans('iamirnet.sms::lang.messages.code.uncorrected');
        }
        return array('status' => false, 'msg' => $error);
    }

}
