<?php
namespace app\admin\controller;

use think\Request;
use app\common\model\BaseAuth;
use app\common\Common;

class Auth extends BaseController
{
    private $model;
    function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new BaseAuth();
    }

    function index(){
      return $this->template();
    }


    /**
     *  c查找所有权限
     */
    function data(){
       $result = $this->model->findAllInfo();
       $result['data'] = $this->resort($result['data']);
       return  $result;
    }

    /**
     * 新增权限
     */
    function add(){
        if($this->request->isPost()){//插入数据
            $row = $this->request->param();
            $result =  $this->model->addInfo($row);
            return $result;
        }else{//渲染添加页面
            $auth =  $result = $this->model->findAllInfo();
            return $this->template('',['authList'=>$auth['data']]);
        }
    }

    /**
     * 数据更改
     */
    function edit(){

        $id =$this->request->param('id');
        if($this->request->isPost()){//数据更新
            $row = Common::getParamList($this->request,array('name','pid','icon','path','level'));
            $result = $this->model ->updateInfo(array('id'=>$id),$row);
            return $result;
        }else{//渲染编辑页面
            $auth =  $result = $this->model->findAllInfo();
            $result = $this->model->findInfo(array('id'=>$id));

            return $this->template('',['data'=>$result['data'],'authList'=>$auth['data']]);
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



}