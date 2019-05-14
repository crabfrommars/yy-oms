<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/1
 * Time: 14:03
 */

namespace app\index\controller;
use app\common\controller\Base;
use app\common\model\User as userModel;
use app\common\model\Role;
use think\facade\Request;
use think\facade\Session;

class User extends Base
{
    /**
     * @return string
     * @throws \Exception
     * 渲染登录页面
     */
    public function login()
    {
        return $this->view->fetch();
    }

    /**
     * @return array
     * 登出
     */
    public function logout()
    {
        Session::clear();
        return ['code'=>0,'msg'=>'已退出'];
    }

    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 登录校验
     */
    public function loginCheck()
    {
        $data=Request::request();
        $rule='app\common\validate\User';

        //验证登录数据
        $res=$this->validate($data,$rule);
        if (true!==$res){
            return ['code'=>-1,'msg'=>$res];
        }else{
            //查询后台数据库
            $result=userModel::where('id',$data['id'])
                ->where('password',md5($data['password']))
                ->find();

            if (null==$result) {
                return ['code' => 1, 'msg' => '邮箱或密码不正确，请检查'];
            } else {
                //将用户的数据写到session中
                $user=userModel::get($data['id']);
                $roles=$user->roles;
                $arr=[];
                foreach ($roles as $role){
                    array_push($arr,$role->name);
                }
                $myRoles=implode(' ',$arr);
                Session::set('id',$result->id);
                Session::set('name',$result->name);
                Session::set('roles',$myRoles);
                return ['code' => 0, 'msg' => '登录成功'];
            }
        }
    }

    /**
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 新增用户并赋予指定的角色(单)
     */
    public function insert()
    {
        $data=Request::request();
        $id=$data['id'];
        if (userModel::where('id',$id)->find()){
            $res=['code'=>1,'msg'=>'工号已存在，请检查'];
        }else{
            $data['password']=md5($data['password']);
            userModel::create($data);

            // 获取刚刚插入的用户实例
            $user=userModel::get($data['id']);

            // 获取要赋予的角色实例
            $role=Role::get($data['role']);

            // 为该用户新增目标角色
            $user->roles()->attach($role);
            $res=['code'=>0,'msg'=>'操作成功'];
        };

        return $res;
    }

    /**
     * @return array
     * @throws \think\Exception
     * @throws \think\Exception\DbException
     * 更新用户数据
     */
    public function update()
    {
        $data=Request::request();
        $data4up=Request::only(['id','name','remark']);
        $user=userModel::get($data['id']);
        userModel::update($data4up);

        $roleReq=$data['role'];
        $roleHas=[];

        $roles=$user->roles;
        foreach ($roles as $role){
            array_push($roleHas,strval($role->id));
        }

        // 获取需要新增的关联角色id数组
        $cos1=array_diff($roleReq,$roleHas);

        // 获取需要删除的关联角色id数组
        $cos2=array_diff($roleHas,$roleReq);


        if (count($cos1) > 0){
            foreach ($cos1 as $key){
                $roleToAdd=Role::get($key);
                $user->roles()->attach($roleToAdd);
            }
        }

        if (count($cos2) > 0){
            foreach ($cos2 as $key){
                $roleToDel=Role::get($key);
                $user->roles()->detach($roleToDel);
            }
        }

        $res=['code'=>0,'msg'=>'操作成功'];

        return $res;
    }

    /**
     * @return string
     * @throws \Exception
     * 渲染个人信息页面
     */
    public function info()
    {
//        return $this->view->fetch('/set/user/info');
        return $this->view->fetch('/user/building');
    }

    /**
     * @return string
     * @throws \Exception
     * 渲染创建用户页面
     */
    public function create(User $user)
    {
        $res=$user->haveRight('create_user');
        if ($res){
            return $this->view->fetch('/user/create');
        }else{
            return $this->view->fetch('/user/noright');
        }
    }

    /**
     * @return userModel|null
     * @throws \think\Exception\DbException
     * 获取用户信息
     */
    public function getUser()
    {
        $id=Request::request('id');
        $user=userModel::get($id);
        $roles=$user->roles;
        return $user;
    }

    /**
     * @return Role[]|false
     * @throws \think\Exception\DbException
     * 获取角色列表
     */
    public function getRoles()
    {
        // 获取所有角色数据
        $roles=Role::all();
        return $roles;
    }

    /**
     * @return string
     * @throws \Exception
     * 渲染用户管理页面
     */
    public function manage(User $user)
    {
        if ($user->haveRight('edit_user')){
            return $this->view->fetch();
        }else{
            return $this->view->fetch('/user/noright');
        }
    }

    /**
     * @return string
     * @throws \Exception
     * 渲染编辑用户页面
     */
    public function edit()
    {
        $id=Request::request('id');
        $roles=$this->getRoles();
        $this->assign('id',$id);
        $this->assign('roles',$roles);
        return $this->view->fetch();
    }

    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 返回用户列表数据
     */
    public function getUsers()
    {
        $list=userModel::all();
        $count=count($list);

        // 获取每页显示条数
        $limit=Request::request('limit');

        // 获取当前页数
        $page=Request::request('page');

        //分页获取数据
        $list=userModel::page($page, $limit)->order('id','asc')->select();

        //获取用户的所有角色
        foreach ($list as $key=>$item){
            $user=userModel::get($item->id);
            $rolesArr=[];
            $roles=$user->roles;
            foreach ($roles as $role){
                array_push($rolesArr,$role->name);
            }
            $item['role']=implode(',',$rolesArr);
        }

        $result=[
            'code'=>0,
            'msg'=>'成功',
            'count'=>$count,
            'data'=>$list
        ];

        return json($result);

    }

    /**
     * @return bool
     * @throws \think\Exception\DbException
     * 判断是否包含所请求的权限
     */
    public function haveRight($reqRight)
    {
        //定义权限数组
        $rightArr=[];

        //获取当前会话中的用户id
        $userId=Session::get('id');

        //获取id对应的用户实例
        $user=userModel::get($userId);

        //获取用户对应的所有角色
        $roles=$user->roles;

        //遍历所有角色，并遍历每个角色对应的所有权限
        foreach ($roles as $role) {

            $roler=Role::get($role->id);
            $rights=$roler->rights;
            foreach ($rights as $right){
                array_push($rightArr,$right->name);
            }

        }
        $res=in_array($reqRight,$rightArr);
        return $res;
    }


    public function test()
    {

    }

}
