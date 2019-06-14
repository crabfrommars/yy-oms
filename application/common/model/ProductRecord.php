<?php


namespace app\common\model;
use think\Model;

class ProductRecord extends Model
{
    protected $connection='other1';
    protected $table='product_record';
    protected $pk='ID';
}