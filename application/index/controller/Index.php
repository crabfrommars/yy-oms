<?php
namespace app\index\controller;
use app\common\controller\Base;
use think\facade\Session;

class Index extends Base
{
    public function index()
    {
        if (Session::get('name')){
            return $this->view->fetch('/index');
        }else{
            return $this->view->fetch('/user/login');
        }
    }
}
