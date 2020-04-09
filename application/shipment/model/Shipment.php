<?php

namespace app\shipment\model;

use think\Model;

class Shipment extends Model
{
    protected $pk = 'id'; // 设置默认主键
    protected $table = 'shipment'; // 设置默认表
    protected $autoWriteTimestamp = true; // 自动时间戳
}
