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
use app\common\model\Instructions;
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


        $srcArr=[];
        if ($proInfo && $orderInfo){

            // 根据订单信息中的说明书编号，找到对应的图片文件路径放入数组
            if ($orderInfo->instruction_num != '' && $orderInfo->instruction_num != 0){
                $instructionNumArr=explode(',',$orderInfo->instruction_num);
                foreach ($instructionNumArr as $value){
                    $instruction=Instructions::get($value);
                    array_push($srcArr,'https://oms.yuyangking.com'.$instruction->address);
                }
            }else{
                array_push($srcArr,'https://oms.yuyangking.com/static/notFound.png');
            }

            $funcArr=[];
            $order=new \app\index\controller\Order();
            $normalFuncAll=$order->getOptions()['normal_func'];
            $specialFuncAll=$order->getOptions()['special_func'];
            $normalFuncArr=explode(',',$orderInfo->normal_func);
            $specialFuncArr=explode(',',$orderInfo->special_func);
            foreach ($normalFuncArr as $value){
                foreach ($normalFuncAll as $item){
                    if ($value == $item['value']){
                        array_push($funcArr,$item['text']);
                    }
                }
            }
            if ($orderInfo->func_cruise != '无'){
                array_push($funcArr,$orderInfo->func_cruise);
            }
            if ($orderInfo->func_soft_hard != '无'){
                array_push($funcArr,$orderInfo->func_soft_hard);
            }
            if ($orderInfo->func_gear != '无'){
                array_push($funcArr,$orderInfo->func_gear);
            }
            foreach ($specialFuncArr as $value){
                foreach ($specialFuncAll as $item){
                    if ($value == $item['value']){
                        array_push($funcArr,$item['text']);
                    }
                }
            }

            $orderInfo->vol1=$orderInfo->vol1.'V';
            $orderInfo->amp1=$orderInfo->amp1.'A';
            $orderInfo->undervoltage1=$orderInfo->undervoltage1.'V';
            $orderInfo->functions=implode(',',$funcArr);
            $res=['code'=>0,'msg'=>'查询成功','proInfo'=>$proInfo,'orderInfo'=>$orderInfo,'imgSrc'=>$srcArr[0],'srcArr'=>$srcArr];
        }else{
            $res=['code'=>1,'msg'=>'未找到该产品','proInfo'=>null,'orderInfo'=>null,'imgSrc'=>null,'srcArr'=>null];
        }
        return json($res);
    }

    public function test()
    {

    }
}