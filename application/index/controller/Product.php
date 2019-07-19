<?php


namespace app\index\controller;

use app\common\controller\Base;
use think\facade\Request;
use app\common\model\ProductRecord;
use app\common\model\Order;

class Product extends Base
{
    public function createLst()
    {
        $user=new User();
        if ($user->haveRight('create_pro_lst')){
            $data = Request::request();
            $serialStart1 = $data['serial_start'];
            $serialEnd1=$data['serial_end'];
            $num1 = $data['num1'];
            $serialStart2 = $data['serial_start2'];
            $serialEnd2=$data['serial_end2'];
            $num2 = $data['num2'];
            $serialStart3 = $data['serial_start3'];
            $serialEnd3=$data['serial_end3'];
            $num3 = $data['num3'];


            $toInsert1 = [];
            $toInsert2 = [];
            $toInsert3 = [];
            $productSn1='';
            $productSn2='';
            $productSn3='';
            $myText1 = substr($serialStart1, 0, 6);
            $myText2 = substr($serialStart2, 0, 6);
            $myText3 = substr($serialStart3, 0, 6);

            for ($i = 0; $i < $num1; $i++) {
                // 根据循环重组单个序列号
                $productSn1 = $myText1 . $this->zeroFill((string)($i + 1));
                $item = [
                    'order_sn' => $data['order_sn']
                    , 'T6_sn' => $data['T6_sn']
                    , 'product_sn' => $productSn1
                    , 'type' => $data['type']
                    , 'type_code' => $data['type_code']
                    , 'T6_code' => $data['T6_code']
                    , 'order_customer' => $data['order_customer']
                    , 'order_sales' => $data['order_sales']
                ];
                // 单次循环把条目放入要批量插入的数组中
                array_push($toInsert1, $item);
            }
            for ($i = 0; $i < $num2; $i++) {
                // 根据循环重组单个序列号
                $productSn2 = $myText2 . $this->zeroFill((string)($i + 1));
                $item = [
                    'order_sn' => $data['order_sn']
                    , 'T6_sn' => $data['T6_sn']
                    , 'product_sn' => $productSn2
                    , 'type' => $data['type']
                    , 'type_code' => $data['type_code']
                    , 'T6_code' => $data['T6_code']
                    , 'order_customer' => $data['order_customer']
                    , 'order_sales' => $data['order_sales']
                ];
                // 单次循环把条目放入要批量插入的数组中
                array_push($toInsert2, $item);
            }
            for ($i = 0; $i < $num3; $i++) {
                // 根据循环重组单个序列号
                $productSn3 = $myText3 . $this->zeroFill((string)($i + 1));
                $item = [
                    'order_sn' => $data['order_sn']
                    , 'T6_sn' => $data['T6_sn']
                    , 'product_sn' => $productSn3
                    , 'type' => $data['type']
                    , 'type_code' => $data['type_code']
                    , 'T6_code' => $data['T6_code']
                    , 'order_customer' => $data['order_customer']
                    , 'order_sales' => $data['order_sales']
                ];
                // 单次循环把条目放入要批量插入的数组中
                array_push($toInsert3, $item);
            }

            if ($productSn1 != $serialEnd1 || $productSn2 != $serialEnd2 || $productSn3 != $serialEnd3){
                $res=['code'=>2,'msg'=>'序列号或数量有误，请检查'];
            }else{
                // 连接目标数据库的数据表
                $proRec = new ProductRecord;

                // 批量插入
                if ($proRec->saveAll($toInsert1) && $proRec->saveAll($toInsert2) && $proRec->saveAll($toInsert3)) {
                    Order::update([
                        'id'=>$data['order_sn']
                        , 'serial_start'=>$serialStart1
                        , 'serial_end'=>$serialEnd1
                        , 'serial_start2'=>$serialStart2
                        , 'serial_end2'=>$serialEnd2
                        , 'serial_start3'=>$serialStart3
                        , 'serial_end3'=>$serialEnd3
                        , 'factory'=>$data['factory']
                        , 'factory2'=>$data['factory2']
                        , 'factory3'=>$data['factory3']
                        , 'num1'=>$num1
                        , 'num2'=>$num2
                        , 'num3'=>$num3
                        , 'is_pro_lst'=>1
                    ]);
                    $res = ['code' => 0, 'msg' => '操作成功'];
                } else {
                    $res = ['code' => 1, 'msg' => '操作失败'];
                };
            }
        }else{
            $res=['code'=>3,'msg'=>'你没有相应的权限'];
        }


        return $res;
    }

    public function zeroFill($str)
    {
        $bit = 4;
        $strLen = strlen($str);
        $zero = '';
        for ($i = $strLen; $i < $bit; $i++) {
            $zero .= '0';
        }
        $res = $zero . $str;

        return $res;
    }
}