<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/21
 * Time: 14:12
 */

namespace app\common\model;
use think\Model;

class User extends Model
{
    protected $pk='id'; //设置默认主键
    protected $table='user'; //设置默认表

    public function roles()
    {
        return $this->belongsToMany('role','user_role','role_id','user_id');
    }
}