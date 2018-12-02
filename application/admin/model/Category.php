<?php

namespace app\admin\model;

use think\Model;

class Category extends Model
{
    /**
     * type=0 普通栏目，type=1 单网页 type=2全显示
     */
    public function cateTree($type,$order="catid asc"){
        if($type==1){
            $where = "type=1";
        } elseif($type==0){
            $where = "type=0";
        } elseif($type==2){
            $where = "1=1";
        }
        $cateres = $this->where($where)->order($order)->select();
        return $this->sort($cateres);
    }

    /**
     * @param $data
     * @param int $pid  父栏目ID
     * @param int $level 栏目级别
     */
    public function sort($data,$pid=0,$level=0){
        static $arr=array();
        foreach ($data as $k => $v){
            if($v['pid']==$pid){
                $v['level']=$level;
                $arr[]=$v;
                $this->sort($data,$v['catid'],$level+1);
            }
        }
        return $arr;
    }
}