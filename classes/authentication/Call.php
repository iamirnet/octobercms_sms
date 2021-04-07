<?php

namespace iAmirNet\SMS\Classes\Authentication;

use Azarinweb\User\Models\User;
use iAmirNet\SMS\Models\Bridge;

trait Call
{
    public $user = null;
    public $method = null;
    public $receiver = null;
    public $code = null;
    public $hash = null;
    public $bridge = null;

    /**
     * @return null
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param null $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
    }

    /**
     * @return null
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param null $hash
     */
    public function setHash($hash): void
    {
        $this->hash = $hash;
    }

    /**
     * @return null
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param null $method
     */
    public function setMethod($method): void
    {
        $this->method = $method;
    }

    /**
     * @return null
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param null $receiver
     */
    public function setReceiver($receiver): void
    {
        $this->receiver = $receiver;
    }

    /**
     * @return null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getBridge() {
        if (!$this->bridge)
            $this->bridge = Bridge::where('hash', $this->getHash())->where('code', $this->code)->where('receiver', $this->receiver)->first();
        return $this->bridge;
    }

    public function setBridge() {
        $this->hash = md5(serialize([$this->getMethod(), $this->getCode(), $this->getReceiver(), time()]));
        $this->bridge = Bridge::create([
            'method' => $this->getMethod(),
            'code' => $this->getCode(),
            'receiver' => $this->getReceiver(),
            'hash' => $this->hash,
        ]);
        return $this->bridge;
    }
}
