<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/31
 * Time: 14:57
 */

namespace app\common\model;
use think\Model;

class Order extends Model
{
    protected $pk='id'; //设置默认主键
    protected $table='order'; //设置默认表
    protected $autoWriteTimestamp=true;
    protected $createTime='create_time';
    protected $updateTime='update_time';

    protected $type=[
        'create_time'=>'timestamp:y-m-d H:i',
        'update_time'=>'timestamp:y-m-d H:i',
    ];

    public function getCurrentChargeAttr($value)
    {
        $current_charge=[
            '1001'=>'项小成'
            , '1003'=>'莫刚强'
            , '1063'=>'解宜江'
        ];
        return $current_charge[$value];
    }
}