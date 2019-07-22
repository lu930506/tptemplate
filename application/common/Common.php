<?php
namespace app\common;
class Common{

    /**
     * @param int $code
     * @param string $msg
     * @param array $data
     * 返回json数据
     */
   public static function show($code = 0,$msg = '',$data = array()){
        $arr = array('code' => $code, 'msg' => $msg, 'data' => $data);
        return $arr;
    }


    /**
     * @param $conditionList
     * @return string
     */
    public static function getWhereString($conditionList)
    {

        $whereString = '';
        if($conditionList){
            foreach ($conditionList as $condition){
                if('like' == $condition['type']){
                    $whereString .= "{$condition['name']} like '%{$condition['value']}%'";
                }else if('in' == $condition['type']){
                    $whereString .= "{$condition['name']} in ({$condition['value']})";
                }else{
                    $value = $condition['value'];
                    $whereString .= "{$condition['name']} {$condition['type']} {$value}";
                }
            }
        }

        return $whereString;
    }

    public static function getParamList($request,$keyList,$nullAllowed = true){
        foreach ($keyList as $key){
            if($nullAllowed){
                $paramList[$key] = $request->param($key);
            }else{
                if(null != $request->param($key) && '' != $request->param($key)){
                    $paramList[$key] = $request->param($key);
                }
            }
        }
        return $paramList;
    }
}