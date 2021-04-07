<?php
namespace iAmirNet\SMS\Models;

use Model;


class Bridge extends Model
{
    public $timestamps = true;
    public $rules = [];
    public $table = 'i_amir_sms_bridges';

    public $fillable = ['method', 'code', 'receiver', 'hash'];
}
