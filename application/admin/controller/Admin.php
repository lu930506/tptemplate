<?php
namespace app\admin\controller;

use think\Request;
use app\common\Common;
use app\common\model\BaseAdmin;
use app\common\model\BaseRole;

class Admin extends BaseController
{
    private $model;
    function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new BaseAdmin();
    }

    function index(){
      return $this->template();
    }


    /**
     * 分页查询数据
     */
    function data(){
       $page      =  $this->request->param('page');
       $limit = $this->request->param('limit');
       $search = $this->request->param('search') ?? array();
       $result = $this->model->pagingInfo($page,$limit,$search);

       return  array(
           'code'=>$result['code'],
           'msg'=>$result['msg'],
           'data'=>$result['data']['data'],
           'count'=>$result['data']['count']
       );
    }


    /**
     * 数据新增
     */
    function add(){
        if($this->request->isPost()){//插入数据

           $row = $this->request->param();

            $validate = new \app\admin\validate\BaseAdmin;
            if (!$validate->check($row)) {
                return Common::show(1,$validate->getError());
            }
            $row['password'] = md5($row['password']);
           $result =  $this->model->addInfo($row);
            return $result;
        }else{//渲染添加页面
            $roleModel = new BaseRole();
            $roleResult = $roleModel->findAllInfo();
            return $this->template('',['roleList'=>$roleResult['data']]);
        }
    }

    /**
     * 数据更改
     */
    function edit(){

        $id =$this->request->param('id');
        if($this->request->isPost()){//数据更新
            $row = Common::getParamList($this->request,array('account','email','role_id'));
            $result = $this->model ->updateInfo(array('id'=>$id),$row);
            return $result;
        }else{//渲染编辑页面
            $result = $this->model->findInfo(array('id'=>$id));

            $roleModel = new BaseRole();
            $roleResult = $roleModel->findAllInfo();
            return $this->template('edit',['data'=>$result['data'],'roleList'=>$roleResult['data']]);
        }
    }

    /**
     * 数据删除
     */
    function delete(){
        $id = $this->request->param('id');
        $result = $this->model->deleteInfo(array('id'=>$id));
        return $result;
    }

    /**
     * 更改状态
     */
    function status(){
        $id = $this->request->param('id');

        $result = $this->model ->excuteSql("UPDATE base_admin set status = abs(status-1) where id = {$id}");
        return $result;
    }
}