<?php

namespace app\shipment\controller;

use app\common\controller\Base;
use app\shipment\model\Shipment;
use think\facade\Request;

class Index extends Base
{
    public function createOne()
    {
        // $data = Request::request();
        $data = [
            'model' => 'YKZ7280JA',
            'consignee' => '美国纽约曼哈顿大街',
            'serial' => 'C015050001'
        ];
        $ship = Shipment::create($data);
        return $ship;
    }

    public function UpdateOne()
    {
        $key = Request::request('key');
        $value = Request::request('value');
        $newData = json_decode(Request::request('data'), true);
        $ship = Shipment::where($key, $value) -> update($newData);
        return $ship;
    }

    public function getOne()
    {
        $key = Request::request('key');
        $value = Request::request('value');
        $ship = Shipment::where($key, $value)->find();
        if($ship){
            $res = ['code' => 0, 'data' => $ship];
        }else{
            $res = ['code' => 1, 'errMsg' => '不存在该产品'];
        }
        return json($res);
    }
}
