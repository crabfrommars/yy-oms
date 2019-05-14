<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/20
 * Time: 16:21
 */

namespace app\common\model;
use think\Model;

class Drawings extends Model
{
    protected $pk='id'; //设置默认主键
    protected $table='drawings'; //设置默认表
    protected $autoWriteTimestamp=true;
    protected $createTime='create_time';
    protected $updateTime='update_time';

    protected $type=[
        'create_time'=>'timestamp:y-m-d H:i',
        'update_time'=>'timestamp:y-m-d H:i',
    ];
}