<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/2
 * Time: 9:07
 */

namespace app\common\model;
use think\Model;
use app\common\model\Role;

class Progress extends Model
{
    protected $pk='id';
    protected $table='progress';

//    public function roles()
//    {
//        return $this->hasOne('role');
//    }

    public function getRoleAttr($value)
    {
        $role=[
            1=>'超级管理员',
            2=>'管理员',
            3=>'研发主管',
            4=>'研发经理',
            5=>'研发专员',
            6=>'研发助理',
            7=>'市场主管',
            8=>'市场经理',
            9=>'市场专员',
            10=>'市场助理',
            11=>'销售主管',
            12=>'销售经理',
            13=>'销售专员',
            14=>'销售助理',
            15=>'生产主管',
            16=>'生产经理',
            17=>'生产专员',
            18=>'生产助理',
            19=>'仓管专员',
            999=>''
        ];

//        $role=[];
//        $res=Role::all();
//        foreach ($res as $item) {
//            $role[$item->id]=$item->name;
//        }

        return $role[$value];
    }
}