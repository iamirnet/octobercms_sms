<?php namespace iAmirNet\SMS\Components;

use Auth;
use Illuminate\Support\Facades\Redirect;
use October\Rain\Support\Facades\Flash;
use Validator;
use ValidationException;
use ApplicationException;
use Cms\Classes\ComponentBase;
use Azarinweb\User\Models\User as UserModel;

class Authentication extends ComponentBase
{
    public $user;
    public $result;

    public function componentDetails()
    {
        return [
            'name'        => 'iamirnet.sms::lang.components.auth.title',
            'description' => 'iamirnet.sms::lang.components.auth.desc',
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        if ($user = Auth::getUser()) {
            return redirect()->to('/');
        }
    }

    public function init()
    {

    }

    public function onSendCode()
    {
        $rules = [
            'receiver' => 'required',
        ];
        $validation = Validator::make(post(), $rules);
        if ($validation->fails())
            throw new ValidationException($validation);

        $auth = new \iAmirNet\SMS\Classes\Authentication();
        $result = $auth->_send(post('receiver'));
        $this->result = $result;
        if ($result['status'])
            Flash::success($result['msg']);
        else
            throw new ValidationException(['mobile' => $result['msg']]);
    }

    public function onVerify()
    {
        $rules = [
            'code'     => 'required',
            'receiver'     => 'required',
            'hash'     => 'required',
        ];
        $validation = Validator::make(post(), $rules);
        if ($validation->fails())
            throw new ValidationException($validation);
        $auth = new \iAmirNet\SMS\Classes\Authentication();
        $result = $auth->_check(post('receiver'), post('code'), post('hash'));
        $this->result = $result;
        if ($result['status']){
            Flash::success($result['msg']);
            \Azarinweb\User\Facades\Auth::loginUsingId($result['user']->id);
            return redirect()->to('/');
        } else
            throw new ValidationException(['code' => $result['msg']]);

    }
}
