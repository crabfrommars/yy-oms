<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/31
 * Time: 14:57
 */

namespace app\common\model;
use think\Model;
use think\model\concern\SoftDelete;

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

    use SoftDelete;
    protected $deleteTime='delete_time';

    // 关联评审单模型
    public function review()
    {
        return $this->hasOne('Reviews','order_id','id');
    }
}