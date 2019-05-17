<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/6
 * Time: 9:36
 */

namespace app\index\controller;
use app\common\controller\Base;
use app\common\model\Order as orderModel;
use app\common\model\Role;
use app\common\model\Timeline;
use app\common\model\Progress;
use app\common\model\Options;
use app\common\model\User as userModel;
use app\index\controller\User;
use think\facade\Request;
use think\facade\Session;
use think\route\Rule;

class Order extends Base
{
    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 返回订单table的数据
     */
    public function order()
    {
        $list=orderModel::all();
        $count=count($list);

        //获取每页显示条数
        $limit=Request::get('limit');

        //获取当前页数
        $page=Request::get('page');

        //获取搜索关键字
        if (Request::request('id')){
            $id=Request::request('id');
            $list=orderModel::page($page,$limit)->where('id',$id)->select();
            $count=count($list);
            foreach ($list as $item){
                $progress=Progress::where('value',$item['progress'])->find();
                $item['current_role']=$progress['role'];
                $item['current_content']=$progress['content'];
            }
            $result=["code"=>0,"msg"=>"成功","count"=>$count,"data"=>$list];
        }else{
            //分页获取数据
            $list=orderModel::page($page,$limit)->order('update_time','desc')->select();
            foreach ($list as $item){
                $progress=Progress::where('value',$item['progress'])->find();
                $item['current_role']=$progress['role'];
                $item['current_content']=$progress['content'];
            }
            $result=["code"=>0,"msg"=>"成功","count"=>$count,"data"=>$list];
        }
        return json($result);

    }

    /**
     * 返回需评审的关联订单
     */
    public function getOrders()
    {
//        $list=orderModel::all();
//        $count=count($list);
//
//
//        $limit=Request::request('limit');
//        $page=Request::request('page');
//
//        $list=orderModel::page($page,$limit)->select();
//
//        $res=['code'=>0,'msg'=>'成功','count'=>$count,'data'=>$list];
//
//        return $res;

        $id=Request::request('id');
        $order=orderModel::get($id);
        if ($order){
            if ($order->review_id !== null){
                $res=[
                    'code'=>1
                    , 'msg'=>'该订单已关联评审单，请勿重复操作'
                    , 'order'=>null
                ];
            }else{
                $res=[
                    'code'=>0
                    , 'msg'=>'操作成功'
                    , 'order'=>$order
                ];
            }
        }else{
            $res=[
                'code'=>2
                , 'msg'=>'不存在该订单，请检查'
                , 'order'=>null
            ];
        }

        return $res;
    }

    /**
     * @return string
     * @throws \Exception
     * 渲染订单详情页面
     */
    public function listForm()
    {
        $id=Request::request('id');
        $order=orderModel::get($id);
        $this->assign('order',$order);
        return $this->view->fetch('/app/workorder/listform');
    }

    public function getOrderData()
    {
        $id=Request::request('id');
        $order=orderModel::where('id',$id)->find();
        $options=$this->getOptions();
        $res=[
            'order'=>$order,
            'options'=>$options
        ];
        return $res;
    }

    /**
     * @return array
     * 更新order表数据
     */
    public function update()
    {
        $data=Request::request();
        if (orderModel::update($data)){
            return ['status'=>1,'message'=>'数据更新成功'];
        }else{
            return ['status'=>0,'message'=>'更新失败'];
        }
    }

    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 更新进度
     */
    public function updateP()
    {
        $data=Request::request();
        $query1=[
            'id'=>$data['id'],
            'progress'=>$data['progress']
        ];

        $progress=Progress::where('value',$data['progress'])->find();
        $query2=[
            'order_id'=>$data['id'],
            'action'=>'流转至：'.$progress['value']." | ".$progress['content']." | ".$progress['role'],
            'content'=>$data['content'],
            'personnel'=>Session::get('name')
        ];

        //更新订单表的进度值，并且向时间线表中插入新记录
        if (orderModel::update($query1) && Timeline::create($query2)){
            $res=['code'=>0,'msg'=>'操作成功'];
        }else{
            $res=['code'=>1,'msg'=>'操作失败'];
        }

        return $res;

    }

    /**
     * @return string
     * @throws \Exception
     * 渲染订单创建页面
     */
    public function create()
    {
        $user=new User();
        $res=$user->haveRight('create_order');
        if ($res){
            return $this->view->fetch('/order/create');
        }else{
            return $this->view->fetch('/user/noright');
        }

    }

    /**
     * @return array
     * 创建订单
     */
    public function insert()
    {
        $data=Request::request();
        $order=orderModel::create($data);
        if ($order){
            Timeline::create([
                'order_id'=>$order->id,
                'action'=>'创建订单',
                'content'=>'无',
                'personnel'=>Session::get('name')
            ]);
            return ['message'=>'创建成功，订单号为'.$order->id];
        }else{
            return ['message'=>'创建失败，请检查'];
        }
    }

    /**
     * @return string
     * @throws \Exception
     * 渲染图纸管理页面
     */
    public function drawing()
    {
      return $this->view->fetch('/order/drawing');
    }

    /**
     * @return string
     * @throws \Exception
     * 渲染流程操作页面
     */
    public function progressform()
    {
        $id=Request::request('id');
        $order=orderModel::where('id',$id)->find();
        $list=Progress::all();

        //获取订单当前进度值对应的进度实例
        $progress=Progress::where('value',$order['progress'])->find();

        //判断当前用户是否拥有流程控制权control_progress
//        $user=new User();
//        $have_right=$user->haveRight('control_progress');
//        if ($have_right){//若拥有该权限，则赋予所有流程的选择权
//            foreach ($list as $key=>$item){
//                $item['disabled']='';
//            }
//        }else{//若无该权限，再判断是否拥有退单权reverse_order
//            $have_right=$user->haveRight('reverse_order');
//            if ($have_right){//若拥有该权限，则赋予流转至id为1和4以及下一步的选择权
//                foreach ($list as $key=>$item){
//                    if ($item['id'] == 1 || $item['id'] == 4 || $item['id'] == $progress['id'] || $item['id'] == $progress['id']+1){
//                        $item['disabled']='';
//                    }else{
//                        $item['disabled']='disabled';
//                    }
//                }
//            }else{//若没有这两项权限，则仅赋予其流转到下一步的选择权
//                foreach ($list as $key=>$item){
//                    if ($item['id'] == $progress['id'] || $item['id'] == $progress['id']+1){
//                        $item['disabled']='';
//                    }else{
//                        $item['disabled']='disabled';
//                    }
//                }
//            }
//        }

        foreach ($list as $key=>$item){
            $item['disabled']='';
        }

        $this->assign('list',$list);
        $this->assign('order',$order);
        return $this->view->fetch('/order/progressform');
    }

    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 根据进度值，获取进度详情
     */
    public function getProDetail()
    {
        $value=Request::request('value');
        $progress=Progress::where('value',$value)->find();
        $res=[
            'value'=>$progress['value'],
            'content'=>$progress['content'],
            'role'=>$progress['role']
        ];
        return $res;
    }

    /**
     * @return array|null|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取指定id的order条目
     */
    public function getorder()
    {
        $id=Request::request('id');
        $res=orderModel::where('id',$id)->find();
        if (!$res){
            $res=['code'=>1,'msg'=>'不存在该订单'];
        }
        return $res;
    }

    /**
     * @return string
     * @throws \Exception
     * 渲染历史记录页面
     */
    public function history()
    {
        $id=Request::request('id');
        $res=Timeline::where('order_id',$id)->order('create_time','desc')->all();
        $this->assign('order_id',$id);
        $this->assign('list',$res);
        return $this->view->fetch('/order/history');
    }

    /**
     * @return string
     * @throws \Exception
     * 渲染高级操作页面
     */
    public function senior()
    {
        $id=Request::request('id');

        //获取id对应的order实例
        $order=orderModel::get($id);

        $this->assign('order',$order);
        return $this->view->fetch('/order/senior');
    }

    /**
     * @return string
     * @throws \Exception
     * 渲染打印页
     */
    public function printPage($id)
    {
        // 获取订单数据
        $order=orderModel::get($id);

        // 将其中值与文本不符的条目改为文本
        // 水冷
        if ($order->is_water == 1){
            $order->is_water = '是';
        }elseif ($order->is_water == 2){
            $order->is_water = '否';
        }

        // 线束可拆装
        if ($order->is_wire == 1){
            $order->is_wire = '是';
        }elseif ($order->is_wire == 2){
            $order->is_wire = '否';
        }

        // 常规功能
        $normalFuncArr=explode(',',$order->normal_func);
        $normalFuncAll=$this->getOptions()['normal_func'];

        $newNormalFuc=[];
        foreach ($normalFuncArr as $value){
            foreach ($normalFuncAll as $item){
                if ($value == $item['value']){
                    array_push($newNormalFuc,$item['text']);
                }
            }
        }
        $order->normal_func=implode(',',$newNormalFuc);

        // 特殊功能
        $specialFuncArr=explode(',',$order->special_func);
        $specialFuncAll=$this->getOptions()['special_func'];

        $newSpecialFuc=[];
        foreach ($specialFuncArr as $value){
            foreach ($specialFuncAll as $item){
                if ($value == $item['value']){
                    array_push($newSpecialFuc,$item['text']);
                }
            }
        }
        $order->special_func=implode(',',$newSpecialFuc);

        // 线束
        $wiresArr=explode(',',$order->wires);
        $wiresAll=$this->getOptions()['wires'];

        $newWires=[];
        foreach ($wiresArr as $value){
            foreach ($wiresAll as $item){
                if ($value == $item['value']){
                    array_push($newWires,$item['text']);
                }
            }
        }
        $order->wires=implode(',',$newWires);

        // 将订单数据赋值给模板
        $this->assign('order',$order);

        // 输出模板
        return $this->view->fetch('/order/printPage');
    }


    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取所有订单中的选项条目
     */
    public function getOptions()
    {
        $shellType=Options::where('type','=','shell_type')->select();
        $shellColor=Options::where('type','=','shell_color')->select();
        $mos=Options::where('type','=','mos')->select();
        $board=Options::where('type','=','board')->select();
        $normalFunc=Options::where('type','=','normal_func')->select();
        $specialFunc=Options::where('type','=','special_func')->select();
        $wires=Options::where('type','=','wires')->select();

        $res=[
            'shell_type'=>$shellType,
            'shell_color'=>$shellColor,
            'mos'=>$mos,
            'board'=>$board,
            'normal_func'=>$normalFunc,
            'special_func'=>$specialFunc,
            'wires'=>$wires
        ];
        return $res;
    }

    /**
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 根据订单进度和当前用户信息判断是否可以编辑订单
     */
    public function canEdt()
    {
        $_user=new User();
        $res=false;
        if ($_user->haveRight('edit_order')){
            $res=true;
        }else{
            $_progress=Request::request('progress');
            $userId=Session::get('id');

            $progress=Progress::where('value','=',$_progress)->find();
            $user=userModel::get($userId);
            $roles=$user->roles;
            foreach ($roles as $role){
                if ($role->name == $progress->role){
                    $res=true;
                }
            }
        }

        return $res;
    }

    /**
     * @return array
     * @throws \think\Exception\DbException
     * 根据订单id判断是否可翻单
     */
    public function canRepeat()
    {
        $orderId=Request::request('id');
        $order=orderModel::get($orderId);
        if ($order){
            if ($order->is_mother === 1){
                $res=['code'=>0,'msg'=>'操作成功','order'=>$order];
            }elseif ($order->is_mother === 0){
                $res=['code'=>1,'msg'=>'该订单不是母单，不可翻单'];
            }else{
                $res=['code'=>2,'msg'=>'该订单存在错误，请联系管理员'];
            }
        }else{
            $res=['code'=>3,'msg'=>'不存在该订单'];
        }
        return $res;
    }

    /**
     * @return string
     * @throws \Exception
     * 渲染翻单页面
     */
    public function renderRepeat()
    {
        return $this->view->fetch('/order/repeat');
    }

    public function test()
    {
        $data=Request::request('num');
        Session::set('num',$data);
        $res=Session::get('num');
        return $res;
    }

}
