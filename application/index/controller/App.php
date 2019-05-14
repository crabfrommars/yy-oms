<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/1
 * Time: 10:17
 */

namespace app\index\controller;
use app\common\controller\Base;

class App extends Base
{
    public function workorder()
    {
        return $this->view->fetch('/app/workorder/list');
    }
}