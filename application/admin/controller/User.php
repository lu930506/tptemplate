<?php
/**
 * Created by PhpStorm.
 * User: lujinlu
 * Date: 2019/7/10
 * Time: 18:05
 */
namespace app\index\controller;
use think\Controller;
use app\index\model\BaseUser;
use think\Config;
class User extends Controller{

    function index(){
        return $this->fetch();
    }
    function getUserList(){
        $user = new BaseUser();
        $result = $user->findAll();
        echo $result->nick_name;
        var_dump($result);
    }

    function addUser(){

        $data =[
            'nick_name'=>'00000000000000',
        ];
        $result = $this->validate($data,'BaseUser');

        if(true !== $result){
            // 验证失败 输出错误信息
           return $result;
        }
    }
}