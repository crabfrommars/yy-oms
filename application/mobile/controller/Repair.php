<?php

namespace app\mobile\controller;
use app\common\controller\Base;
use app\common\model\ProductRecord;
use app\mobile\model\RecInfos;
use think\facade\Request;

class Repair extends Base
{
    /**
     * 报修接口
     */
    public function repair()
    {
        $data=Request::request();
        $query=$this->verifyProId($data);
        if($query){
            $res=['code'=>0,'msg'=>'提交成功'];
        }else{
            $res=['code'=>1,'msg'=>'失败'];
        }
        return json($res);
    }

    /**
     * 移动端获取维修订单列表
     */
    public function repairList()
    {
        $data=Request::request();
        if($data){
            $res=[
                'code'=>0,
                'list'=>[
                    ['id'=>1,'name'=>'詹姆斯'],
                    ['id'=>2,'name'=>'安东尼'],
                    ['id'=>3,'name'=>'韦德']
                ]
            ];
        }else{
            $res=[
                'code'=>1,
                'msg'=>'失败'
            ];
        }

        return json($res);
    }

    /**
     * 移动端获取收件地址接口
     */
    public function getRecInfo()
    {
        $list=RecInfos::all();
        return $list;
    }

    /**
     * 渲染web端维修管理页面
     */
    public function repairRender()
    {
        return $this->view->fetch('/repair/home');
    }

    /**
     * web端获取维修订单数据接口
     */
    public function repairTable()
    {
        $data=[
            'code'=>0,
            'msg'=>'',
            'count'=>2,
            'data'=>[
                [
                    'id'=>1,
                    'uid'=>1,
                    'serial'=>'c015050001',
                    'guarantee'=>'2020-06-29',
                    'type'=>'YKZ120150FB-X',
                    'sendInfo'=>'',
                    'recInfo'=>''
                ]
                ,[
                    'id'=>2,
                    'uid'=>1,
                    'serial'=>'c015050002',
                    'guarantee'=>'2020-06-29',
                    'type'=>'YKZ120150FB-X',
                    'sendInfo'=>'',
                    'recInfo'=>''
                ]
            ]
        ];

        return json($data);
    }

    /**
     * 验证产品序列号
     */
    private function verifyProId($data)
    {
        if($data){
            return true;
        }else{
            return false;
        }
    }
}