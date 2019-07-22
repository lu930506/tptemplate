<?php
namespace app\admin\controller;

use \think\Db;
use think\Request;
use app\common\Common;
use app\common\model\BaseRole;
use app\common\model\BaseAuth;
use app\common\model\BaseRoleAuth;

class Role extends BaseController
{
    private $model;
    function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new BaseRole();
    }

    function index(){
      return $this->template();
    }


    /**
     * 分页查询数据
     */
    function data(){
        $result = $this->model->findAllInfo();
        return  $result;
    }

    /**
     * 新建角色
     */
    function add(){
        if($this->request->isPost()){//插入数据

            $name= $this->request->param('name');
            $auth_ids = $this->request->param('permissions');
            $auth_ids = explode(',',$auth_ids);

           $result =  $this->model->addInfo(array('name'=>$name));//添加角色
           if($result['code'] == 0){//添加角色权限
               $roleAuthModel = new BaseRoleAuth();
               foreach($auth_ids as $item){
                   $roleAuthModel->addInfo(array('role_id'=>$result['data'],'auth_id'=>$item));
                   unset($roleAuthModel->id);
               }

            }
            return $result;
        }else{//渲染添加页面

            $authModel = new BaseAuth();
            $auth =  $result = $authModel->findAllInfo();
            $auth = $this->getTree($auth['data']);
            return $this->template('',['authList'=>$auth]);
        }
    }

    /**
     *编辑角色
     */
    function edit(){
        $id =$this->request->param('id');
        if($this->request->isPost()){//插入数据
            $name= $this->request->param('name');
            $auth_ids = $this->request->param('permissions');
            $auth_ids = explode(',',$auth_ids);

            Db::startTrans(); //启动事务
            try{
                $this->model->updateInfo(array('id'=>$id),array('name'=>$name));//更改角色


                $roleAuthModel = new BaseRoleAuth();
                $roleAuthModel->deleteInfo(array('role_id'=>$id));
                foreach($auth_ids as $item){
                    $roleAuthModel->addInfo(array('role_id'=>$id,'auth_id'=>$item));
                    unset($roleAuthModel->id);
                }
                Db::commit(); //提交事务
                return Common::show(0,'更新成功');
            }catch (\PDOException $e){
                Db::rollback(); //回滚事务
                return Common::show(1,'更新失败');
            }

        }else{//渲染添加页面
            $result = $this->model->findInfo(array('id'=>$id));

            $roleAuthModel = new BaseRoleAuth();
            $sql = "SELECT group_concat(auth_id) as auth_ids FROM `base_role_auth` group by role_id HAVING role_id = {$id}";
            $auth_ids = $roleAuthModel->querySql($sql);

            $authModel = new BaseAuth();
            $auth = $authModel->findAllInfo();
            $auth = $this->getTree($auth['data']);
            return $this->template('',['data'=>$result['data'],'authList'=>$auth,'permissions'=>$auth_ids['data'][0]['auth_ids']]);
        }
    }


    /**
     *  删除
     */
    function delete(){
        $id = $this->request->param('id');
        Db::startTrans(); //启动事务
        try {
            $this->model->deleteInfo(array('id' => $id));

            $roleAuthModel = new BaseRoleAuth();
            $roleAuthModel->deleteInfo(array('role_id'=>$id));

            Db::commit(); //提交事务
            return Common::show(0,'删除成功');
        }catch (\Exception $e){
            Db::rollback(); //回滚事务
            return Common::show(1,'删除失败');
        }
        return $result;
    }


}