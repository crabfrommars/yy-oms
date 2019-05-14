<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/28
 * Time: 14:45
 */

namespace app\common\model;
use think\Model;

class Timeline extends Model
{
    protected $pk='id'; //设置默认主键
    protected $table='timeline'; //设置默认表
    protected $autoWriteTimestamp=true;
    protected $createTime='create_time';
    protected $updateTime='update_time';

    protected $type=[
        'create_time'=>'timestamp:Y年n月j日 H:i',
        'update_time'=>'timestamp:y-m-d H:i',
    ];
}