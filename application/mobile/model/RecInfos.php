<?php

namespace app\mobile\model;
use think\Model;

class RecInfos extends Model
{
    protected $connection='other1';
    protected $pk='id'; //设置默认主键
    protected $table='receiving_address'; //设置默认表
}