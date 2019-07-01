<?php


namespace app\common\model;
use think\Model;


class Instructions extends Model
{
    protected $table='instructions';
    protected $pk='id';
    protected $autoWriteTimestamp=true;
    protected $createTime='create_time';
    protected $updateTime='update_time';

    protected $type=[
        'create_time'=>'timestamp:y-m-d H:i',
        'update_time'=>'timestamp:y-m-d H:i',
    ];
}