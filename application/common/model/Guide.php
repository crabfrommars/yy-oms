<?php


namespace app\common\model;
use think\Model;

class Guide extends Model
{
    protected $connection='wx';
    protected $table='guides';
    protected $pk='id';
}