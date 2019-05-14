<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/19
 * Time: 16:08
 */

namespace app\index\controller;
use app\common\controller\Base;
use app\common\model\Drawings;
use think\facade\Request;
use think\facade\Env;

class Drawing extends Base
{
    /**
     * @return array
     * @throws \think\Exception\DbException
     * 插入记录
     */
    public function insert()
    {
        $user=new User();
        $req=$user->haveRight('create_drawing');
        if ($req){
            $drawing=Drawings::create([
                'name'=>''
                ,'path'=>''
            ]);
            if (null!==$drawing){
                $res=[
                    'code'=>0
                    ,'msg'=>'操作成功，新建记录编号为：'.$drawing->id
                ];
            }else{
                $res=[
                    'code'=>1
                    ,'msg'=>'操作失败，请检查'
                ];
            }
        }else{
            $res=[
                'code'=>2,
                'msg'=>'你没有相应的权限'
            ];
        }

        return $res;
    }

    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 返回table数据
     */
    public function drawingList()
    {
        //获取表单内总数
        $list=Drawings::all();
        $count=count($list);

        //获取每页显示条数
        $limit=Request::get('limit');

        //获取当前页数
        $page=Request::get('page');

        //获取搜索关键字
        if (Request::request('id')){
            $id=Request::request('id');
            $list=Drawings::page($page,$limit)->where('id',$id)->select();
            $count=count($list);
            $result=["code"=>0,"msg"=>"成功","count"=>$count,"data"=>$list];
        }else{
            //分页获取数据
            $list=Drawings::page($page,$limit)->order('update_time','desc')->select();
            $result=["code"=>0,"msg"=>"成功","count"=>$count,"data"=>$list];
        }
        return json($result);
    }

    /**
     * @return \think\response\Json
     * 覆盖上传
     */
    public function cover()
    {
        //接收发送过来的文件
        $file=Request::file('file');

        //接收发送过来的数据
        $data=Request::request();

        //获取文件名，并进行转码，方可存储中文
        $name=iconv('utf-8','gbk',$file->getInfo()['name']);

        // 移动文件到框架应用根目录/public/uploads/ 目录下
        $info = $file->move('../public/uploads/',$name);

        //根据上述执行结果，将文件信息存入数据库，并返回相应参数给前端
        if($info){
            Drawings::update([
                'id'=>$data['id'],
                'name'=>$file->getInfo()['name'],
                'path'=>'/uploads/'.$file->getInfo()['name']
            ]);
            $res=[
                'code'=>0,
                'msg'=>'上传成功',
                //返回文件信息时，需再进行一次反向转码
                'data'=>[
                    'path'=>'/uploads/'.$file->getInfo()['name']
                ]
            ];
        }else{
            $res=[
                'code'=>1,
                'msg'=>'上传失败',
                'data'=>$file->getError()
            ];
        }
        return json($res);
    }

    /**
     * @return array
     * @throws \think\Exception\DbException
     * 定向删除文件
     */
    public function delFileOnly()
    {
        $data=Request::request();
        $path=iconv('utf-8','gbk',$data['path']);
        $id=$data['id'];
        $file=Env::get('root_path').'public'.$path;
        if (Drawings::get($id)){
            Drawings::update(['id'=>$id,'name'=>'','path'=>'']);
        }
        if (file_exists($file)){
            unlink($file);
            $res=[
              'code'=>0,
              'msg'=>'删除成功'
            ];
        }else{
            $res=[
              'code'=>1,
              'msg'=>'操作失败，请检查'
            ];
        }
        return $res;
    }

    public function delRecord()
    {
        $data=Request::request();
        $id=$data['id'];
        $res=[];
        if (""!==$data['path']){
            $path=iconv('utf-8','gbk',$data['path']);
            $file=Env::get('root_path').'public'.$path;

            //删除文件
            if (file_exists($file)){
                unlink($file);
            }
        }
        //删除记录
        if (Drawings::get($id)){
            $drawing=Drawings::get($id);
            $drawing->delete();
            $res=[
              'code'=>0,
              'msg'=>'成功删除'
            ];
        }
        return $res;
    }

    /**
     * @return string
     * @throws \Exception
     * 渲染图纸编辑弹窗
     */
    public function drawingedit()
    {
        $data=Request::request();
        $this->assign('data',$data);
        return $this->view->fetch('/order/drawingedit');
    }
}