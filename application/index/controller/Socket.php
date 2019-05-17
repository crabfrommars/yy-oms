<?php


namespace app\index\controller;
use app\common\controller\Base;
use think\facade\Session;
use think\facade\Request;
require_once '../GatewayClient/Gateway.php';
use GatewayClient\Gateway;

class Socket extends Base
{
    public function bind()
    {
        Gateway::$registerAddress='127.0.0.1:1238';

        $uid=Session::get('id');
        $client_id=Request::request('client_id');

        Gateway::bindUid($client_id,$uid);

    }

    public function sendMsg()
    {
        $message=json_encode('呵呵');
        Gateway::sendToUid(1063, $message);
    }

    public function test()
    {
        $message=json_encode(array(
            'type'=>'minus'
            , 'num'=>1
        ));
        Gateway::sendToUid(1063, $message);
    }
}