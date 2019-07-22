<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\facade\Config;
use think\facade\Session;
use app\common\model\BaseAdmin;

class Login extends Controller{
    protected $request;

    function __construct(Request $request){
        $this->request = $request;

    }

    //登录
    public function login(){

        if($this->request->isGet()){
            return view('common/login');
        }else{

            $userInfo = BaseAdmin::where(['account'=>$this->request->param('account'),'password'=>md5($this->request->param('password'))])->find();
            if(!empty($userInfo)){
                $user           = [
                    'id'       => $userInfo['id'],
                    'name'  => $userInfo['name'],
                    'account'  => $userInfo['account'],
                    'time'      => time(),
                    'role_id'      => $userInfo['role_id'],
                ];
                $prefix = Config::get('session.prefix');
                Session::set($prefix.'user',$user);
//                BaseAdmin::where(['id'=>$userInfo['id']])->update(['last_login_ip'=>$this->request->ip(),'last_login_time'=>date("Y-m-d H:i:s",time())]);
                return ['code' => 0];

            }else{
                return ['code' => 1];
            }
        }
    }
    /**
     * 退出视图
     */
    public function logout()
    {

        $prefix = Config::get('session.prefix');
        Session::delete($prefix.'user');
        $this->redirect('login/login');
    }



}