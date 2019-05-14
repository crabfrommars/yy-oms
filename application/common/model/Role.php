<?php

namespace app\common\model;
use think\Model;


class Role extends Model
{
    protected $pk='id'; //设置默认主键
    protected $table='role'; //设置默认表

    public function rights()
    {
        return $this->belongsToMany('right','role_right','right_id','role_id');
    }

    public function user()
    {
        return $this->belongsToMany('user','user_role','user_id','role_id');
    }
}