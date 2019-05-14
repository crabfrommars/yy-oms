<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/31
 * Time: 17:18
 */

namespace app\index\controller;
use app\common\controller\Base;

class Home extends Base
{
    public function console()
    {
        return $this->view->fetch();
    }

    public function homepage1()
    {
        return$this->view->fetch();
    }
}