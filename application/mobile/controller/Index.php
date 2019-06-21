<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/6
 * Time: 11:30
 */

namespace app\mobile\controller;
use app\common\controller\Base;
use app\common\model\Order;
use app\common\model\ProductRecord;
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
        $data=Request::request();
        $orderId=$data['orderId'];
        $productSn=$data['product_sn'];
        $productRecord=new ProductRecord();

        $proInfo=$productRecord->where('product_sn',$productSn)->find();
        $orderInfo=Order::where('id',$orderId)->find();

        $srcArr=['https://oms.yuyangking.com/static/instructions/1.png'];
        $imgSrc=$srcArr[0];
        if ($proInfo && $orderInfo){
            $orderInfo->vol1=$orderInfo->vol1.'V';
            $orderInfo->amp1=$orderInfo->amp1.'A';
            $orderInfo->undervoltage1=$orderInfo->undervoltage1.'V';
            $orderInfo->functions='功能1，功能2';
            $res=['code'=>0,'msg'=>'查询成功','proInfo'=>$proInfo,'orderInfo'=>$orderInfo,'imgSrc'=>$imgSrc,'srcArr'=>$srcArr];
        }else{
            $res=['code'=>1,'msg'=>'未找到该产品','proInfo'=>null,'orderInfo'=>null,'imgSrc'=>null,'srcArr'=>null];
        }
        return json($res);
    }
}