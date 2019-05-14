<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/6
 * Time: 13:02
 */

namespace app\common\model;
use think\Model;

class Controller extends Model
{
    protected $pk='id'; //设置默认主键
    protected $table='controller'; //设置默认表
    protected $autoWriteTimestamp=true;
    protected $createTime='create_time';
    protected $updateTime='update_time';

    protected $type=[
        'create_time'=>'timestamp:y-m-d H:i',
        'update_time'=>'timestamp:y-m-d H:i',
    ];
}