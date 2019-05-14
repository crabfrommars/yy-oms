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
use think\facade\Request;

class Index extends Base
{
    public function getInfo()
    {
        $id=Request::request('id');
        $res=Controller::get($id);
        return $res;
    }
}