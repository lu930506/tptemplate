<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\facade\Config;
use think\facade\Session;
use app\common\model\BaseAuth;
use app\common\model\BaseAdmin;
use app\common\model\BaseRoleAuth;

class BaseController extends Controller{
    protected $request;
    protected $assign = array();


    function __construct(Request $request){

        $this->request = $request;
        $prefix = Config::get('session.prefix');
        $user = Session::get($prefix.'user');
       if($user['id']){
           if($user['id'] == 1){
               $auth = BaseAuth::select()->toArray();
           }else{
                //查询管理员信息
               $adminModel = new BaseAdmin();
               $userResult = $adminModel->findInfo(array('id'=>$user['id']));
               $role_id = $userResult['data']['role_id'];
                //查询管理员权限ids
               $roleAuthModel = new BaseRoleAuth();
               $authIdsResult = $roleAuthModel->querySql("SELECT group_concat(auth_id) as auth_ids FROM `base_role_auth` group by role_id HAVING role_id = {$role_id}");
               $auth_ids = $authIdsResult['data'][0]['auth_ids'];
               //查找管理员权限
               $where[] = array('id','in',$auth_ids);
               $auth = BaseAuth::where($where)->select()->toArray();
               //验证权限
               $currentPath = $this->request->path();
               $pathResult = BaseAuth::where($where)->column('path');
               $path = implode(',',$pathResult);
               if(stripos($path, $currentPath) === false){
                    $this->error('无权限访问');
               }

           }


           $this->assign = array('adminName'=>$user['name'],'path'=>$this->request->path(),'menuList'=> $this->getTree($auth, 0));
       }else{
           $this->redirect('Login/index');
       }

    }

    /**
     * 查询所有权限
     */
    function getTree($data, $pId=0)
    {
        $tree = [];
        foreach($data as $k => $v)
        {
            if($v['pid'] == $pId)
            {
                $v['son'] = $this->getTree($data, $v['id']);
                $tree[] = $v;
                unset($data[$k]);
            }
        }
        return $tree;
    }


    /**
     * @param $data
     * @param $pId
     * @return array
     */
    public function resort($data,$parentid=0,$level=0)
    {
        static $ret=array();
        foreach ($data as $k => $v)
        {
            if($v['pid']==$parentid)
            {
                $v['level']=$level;
                if($v['level'] == 1){
                    $v['name'] = '|-'.$v['name'];
                }else if($v['level'] == 2){
                    $v['name'] = '| |-'.$v['name'];
                }
                $ret[]=$v;
                $this->resort($data,$v['id'],$level+1);
            }
        }

        return $ret;
    }



    /**
     * 页面渲染
     */
    function template($path='',$array=array()){
        return view($path, array_merge($this->assign, $array));
    }






}