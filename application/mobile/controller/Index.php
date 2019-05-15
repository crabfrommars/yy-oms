<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/6
 * Time: 11:30
 */

namespace app\mobile\controller;
use app\common\controller\Base;
use app\common\model\Controller;
use app\common\model\Order;
use think\Db;
use think\facade\Request;

class Index extends Base
{
    public function getOrderInfo()
    {
        $id=Request::request('id');
        $query=Order::get($id);
        if ($query){
            $res=['code'=>0,'msg'=>'查询成功','order'=>$query];
        }else{
            $res=['code'=>1,'msg'=>'未找到该订单','order'=>null];
        }
        return json($res);
    }

    public function getProductInfo()
    {
        $productSn=Request::request('product_sn');
        $productRecord=Db::connect('other1')->table('product_record');
        $query=$productRecord->where('product_sn',$productSn)->find();
        if ($query){
            $res=['code'=>0,'msg'=>'查询成功','product'=>$query];
        }else{
            $res=['code'=>1,'msg'=>'未找到该产品','product'=>null];
        }
        return json($res);
    }
}