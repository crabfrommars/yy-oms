<?php


namespace app\wxpay\controller;
use app\common\controller\Base;
use think\facade\Request;

class WeChat extends Base
{
    private $appid='wxb4e734264e6e7991';  // 小程序appid
    private $appsecret='c1e74bb9770d3f8387969673af540419';  // 小程序密钥
    private $url='';  // 微信回调地址
    private $machId='1541493881';  // 微信商户号


    public function login()
    {
        $code=Request::request('code');

        $this->url='https://api.weixin.qq.com/sns/jscode2session?appid='.$this->appid.'&secret='.$this->appsecret.'&js_code='.$code.'&grant_type=authorization_code';
        $res=file_get_contents($this->url);
        return json_encode($res);
    }
}