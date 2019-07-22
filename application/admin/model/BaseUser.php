<?php
/**
 * Created by PhpStorm.
 * User: lujinlu
 * Date: 2019/7/10
 * Time: 18:02
 */
namespace app\index\model;
use think\Model;

class BaseUser extends  Model{
    protected $table = 'base_user';

    function findAll(){
        $result = $this->find();

        return $result;
    }
}