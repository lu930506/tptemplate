<?php
/**
 * Created by PhpStorm.
 * User: lujinlu
 * Date: 2019/7/20
 * Time: 10:16
 */
namespace app\admin\controller;

use app\admin\controller\BaseController;
class Base extends BaseController{
    function index(){
        return $this->template();
    }
}
