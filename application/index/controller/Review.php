<?php

namespace app\index\controller;
use app\common\controller\Base;
use app\common\model\Reviews;
use app\common\model\Order;
use think\facade\Request;

class Review extends Base
{
    public function ins()
    {
        $data=Request::request();
        if (Reviews::where('order_id',$data['order_id'])->find()){
            $res=['code'=>2,'msg'=>'该订单已关联评审单'];
        }else{
            $review=Reviews::create($data);
            if ($review){
                Order::update(['id'=>$data['order_id'],'review_id'=>$review->id]);
                $res=['code'=>0,'msg'=>'操作成功'];
            }else{
                $res=['code'=>1,'msg'=>'操作失败'];
            }
        }

        return $res;
    }

    public function del()
    {

    }

    public function edt()
    {
        $data=Request::request();
        $review=Reviews::get($data['id']);
        if ($review->status === 1){
            $sql=Reviews::update($data);
            if ($sql){
                $res=['code'=>0,'msg'=>'操作成功'];
            }else{
                $res=['code'=>1,'msg'=>'操作失败'];
            }
        }else{
            $res=['code'=>2,'msg'=>'已过审，无法更改'];
        }

        return $res;
    }

    public function sel()
    {
        $list=Reviews::all();
        $count=count($list);


        $limit=Request::request('limit');
        $page=Request::request('page');

        if (Request::request('id')){
            $id=Request::request('id');
            $list=Reviews::page($page,$limit)->where('id',$id)->select();
            $count=count($list);
        }else{
            $list=Reviews::page($page,$limit)->select();
        }

        $res=['code'=>0,'msg'=>'成功','count'=>$count,'data'=>$list];
        return $res;

    }

    public function pass()
    {
        $id=Request::request('id');
        $sql=Reviews::update(['id'=>$id,'status'=>0]);
        if ($sql){
            $res=['code'=>0,'msg'=>'操作成功'];
        }else{
            $res=['code'=>1,'msg'=>'操作失败'];
        }
        return $res;
    }

    public function renderIns()
    {
        $user=new User();
        $res=$user->haveRight('create_review');
        if ($res){
            return $this->view->fetch('/review/insert');
        }else{
            return $this->view->fetch('/user/noright');
        }
    }

    public function renderSel()
    {
        $user=new User();
        $res=$user->haveRight('check_reviews');
        if ($res){
            return $this->view->fetch('/review/list');
        }else{
            return $this->view->fetch('/user/noright');
        }
    }

    /**
     * @return string
     * @throws \think\Exception\DbException
     * 渲染评审单编辑页面
     */
    public function renderEdt()
    {
        $id=Request::request('id');
        $review=Reviews::get($id);
        $this->assign('review',$review);
        return $this->view->fetch('/review/edit');
    }

    public function renderAssociate()
    {
        return $this->view->fetch('/review/associate');
    }

    public function renderCheck()
    {
        $id=Request::request('id');
        $review=Reviews::get($id);
        $this->assign('review',$review);
        return $this->view->fetch('/review/check');
    }
}