<?php


namespace app\common\model;
use think\Model;

class WxUser extends Model
{
    protected $connection='wx';
    protected $table='user';
    protected $pk='id';
}