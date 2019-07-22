<?php
/**
 * Created by PhpStorm.
 * User: lujinlu
 * Date: 2019/7/16
 * Time: 21:09
 */
namespace app\common\model;
use think\Model;
use think\Db;
use app\common\Common;
class BaseAdmin extends Model{
    protected $pk = 'id';
    protected $table = 'base_admin';


    /**
     * @param $row array
     * 添加信息
     */
    function addInfo($row = array()){
        foreach($row as $key=>$value)
           $this->$key = $value;
        try{
           $result =  $this->save();
            if($result){
               return Common::show(0,'添加成功',$result);
            }else{
              return  Common::show(1,'添加失败',$result);
            }
        }catch (\Exception $e){

          return  Common::show(2,'数据库失败',$e);
        }
    }

    /**
     * @param null $condition
     * @param $row
     * 更新信息
     */
    function updateInfo($condition = null,$row = null){
        try{
           $result =  $this->where($condition)->update($row);
            if($result){
              return  Common::show(0,'更新成功',$result);
            }else{
              return  Common::show(1,'更新失败',$result);
            }
        }catch (\Exception $e){
           return Common::show(2,'数据库失败',$e);
        }
    }

    /**
     * @param null $condition
     * 删除信息
     */
    function deleteInfo($condition = null){
        try{
            $result =  $this->where($condition)->delete();
            if($result){
              return  Common::show(0,'删除成功',$result);
            }else{
              return  Common::show(1,'删除失败',$result);
            }
        }catch (\Exception $e){
           return Common::show(2,'数据库失败',$e);
        }
    }

    /**
     * @param null $condition
     * 查询单条信息
     */
    function findInfo($condition = null,$field = '',$order = ''){
        try{
            $result =  $this->where($condition)
                            ->field($field)
                            ->order($order)
                            ->find()
                            ->toArray();

            if($result){
              return  Common::show(0,'查询成功',$result);
            }else{
              return  Common::show(1,'查询失败',$result);
            }
        }catch (\Exception $e){
           return Common::show(2,'数据库失败',$e);
        }
    }

    /**
     * @param null $condition
     * 查询多条信息
     */
    function findAllInfo($condition = null,$field = null,$order = null){
        try{
            $result =  $this->where($condition)
                            ->field($field)
                            ->order($order)
                            ->select();
            if($result){
             return   Common::show(0,'查询成功',$result);
            }else{
              return  Common::show(1,'查询失败',$result);
            }
        }catch (\Exception $e){
          return  Common::show(2,'数据库失败',$e);
        }
    }

    /**
     * @param int $page
     * @param int $limit
     * @param $conditionList
     * 分页查询
     */
    function pagingInfo($page=1,$limit = 10,$conditionList = null){
        try{
            $whereString =  Common::getWhereString($conditionList);
            $result = Db::table($this->table)
                            ->where($whereString)
                            ->limit($limit)
                            ->page($page)
                            ->select();
            if($whereString){
                $countResult = $this->querySql("select count(id) as count from base_admin where $whereString");

            }else{
                $countResult = $this->querySql("select count(id) as count from base_admin");
            }


            if($result){
               return Common::show(0,'查询成功',array('data'=>$result,'count'=>$countResult['data'][0]['count']));
            }else{

                return Common::show(1,'查询失败',array('data'=>$result,'count'=>0));
            }
        }catch (\Exception $e){
            return Common::show(2,'数据库失败',$e);
        }
    }


    /**
     * @param null $condition
     * @param int $field
     * @param int $value
     * 字段自增
     */
    function setIncs($condition= null,$field,$value=1){
        try{
            $result = Db::table($this->table)->where($condition)->setInc($field,$value);
            if($result){
              return  Common::show(0,'修改成功',$result);
            }else{
              return  Common::show(1,'修改失败',$result);
            }
        }catch (\Exception $e){
           return Common::show(2,'数据库失败',$e);
        }
    }

    /**
     * @param null $condition
     * @param int $field
     * @param int $value
     * 字段自增
     */
    function setDecs($condition= null,$field,$value=1){
        try{
            $result = Db::table($this->table)->where($condition)->setDec($field,$value);

            if($result){
              return  Common::show(0,'修改成功',$result);
            }else{
              return  Common::show(1,'修改失败',$result);
            }
        }catch (\Exception $e){
          return  Common::show(2,'数据库失败',$e);
        }
    }


    /**
     * @param $sql
     * 原生查询
     */
    function querySql($sql){
        try{
            $result = Db::query($sql);
            if($result){
              return  Common::show(0,'查询成功',$result);
            }else{
              return  Common::show(1,'查询失败',$result);
            }
        }catch (\Exception $e){
          return  Common::show(2,'数据库失败',$e);
        }
    }

    /**
     * @param $sql
     * 原生执行
     */
    function excuteSql($sql){
        try{
            $result = Db::execute($sql);
            if($result){
             return Common::show(0,'操作成功',$result);
            }else{
             return Common::show(1,'操作失败',$result);
            }
        }catch (\Exception $e){
           return Common::show(2,'数据库失败',$e);
        }
    }
}