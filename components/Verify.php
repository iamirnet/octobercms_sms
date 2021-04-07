<?php namespace iAmirNet\SMS\Components;

use Auth;
use Illuminate\Support\Facades\Redirect;
use October\Rain\Support\Facades\Flash;
use Validator;
use ValidationException;
use ApplicationException;
use Cms\Classes\ComponentBase;
use Azarinweb\User\Models\User as UserModel;

class Verify extends ComponentBase
{
    public $user;

    public function componentDetails()
    {
        return [
            'name'        => 'iamirnet.sms::lang.components.verify.title',
            'description' => 'iamirnet.sms::lang.components.verify.desc',
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        if (!$user = Auth::getUser()) {
            return redirect()->to('/login');
        }
    }

    public function init()
    {
        if (!$user = Auth::getUser()) {
            return null;
        }

        if (!Auth::isImpersonator()) {
            $user->touchLastSeen();
        }
        $this->user = $user;
    }

    public function onSendCode()
    {
        $rules = [
            'mobile' => 'required'
        ];
        $validation = Validator::make(post(), $rules);
        if ($validation->fails())
            throw new ValidationException($validation);

        $verify = \iAmirNet\SMS\Classes\Verify::call($this->user, post('mobile'));
        if ($verify['status'])
            Flash::success($verify['msg']);
        else
            throw new ValidationException(['mobile' => $verify['msg']]);
    }

    public function onVerifyMobile()
    {
        $rules = [
            'code'     => 'required',
        ];
        $validation = Validator::make(post(), $rules);
        if ($validation->fails())
            throw new ValidationException($validation);

        $verify = \iAmirNet\SMS\Classes\Verify::handel($this->user, post('code'));
        if ($verify['status'])
            Flash::success($verify['msg']);
        else
            throw new ValidationException(['code' => $verify['msg']]);

    }
}
