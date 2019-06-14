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
            $serialStart = $data['serial_start'];
            $serialEnd=$data['serial_end'];
            $num = $data['quantity'];

            $toInsert = [];
            $productSn='';
            $myText = substr($serialStart, 0, 6);
            for ($i = 0; $i < $num; $i++) {
                // 根据循环重组单个序列号
                $productSn = $myText . $this->zeroFill((string)($i + 1));
                $item = [
                    'order_sn' => $data['order_sn']
                    , 'T6_sn' => $data['T6_sn']
                    , 'product_sn' => $productSn
                    , 'type' => $data['type']
                    , 'type_code' => $data['type_code']
                    , 'T6_code' => $data['T6_code']
                    , 'order_customer' => $data['order_customer']
                    , 'order_sales' => $data['order_sales']
                ];
                // 单次循环把条目放入要批量插入的数组中
                array_push($toInsert, $item);
            }

            if ($productSn != $serialEnd){
                $res=['code'=>2,'msg'=>'序列号或数量有误，请检查'];
            }else{
                // 连接目标数据库的数据表
                $proRec = new ProductRecord;

                // 批量插入
                if ($proRec->saveAll($toInsert)) {
                    Order::update([
                        'id'=>$data['order_sn']
                        , 'serial_start'=>$serialStart
                        , 'serial_end'=>$serialEnd
                        , 'factory'=>$data['factory']
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