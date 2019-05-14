<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/21
 * Time: 9:11
 */

namespace app\common\validate;
use think\Validate;

class User extends Validate
{
    protected $rule=[
        'id|工号'=>[
            'require'=>'require',
            'length'=>'3,6',
            'chsAlphaNum'=>'chsAlphaNum',
        ],
        'password|密码'=>[
            'require'=>'require',
            'length'=>'6,20',
            'AlphaNum'=>'AlphaNum',
        ],
    ];
}