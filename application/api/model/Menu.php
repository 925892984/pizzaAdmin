<?php


namespace app\api\model;


use think\Model;

class Menu extends Model
{
    //关联分类尺寸售价表
    public function classify()
    {
        return $this->hasMany('menu_classify','menu_id','id');
    }

    //添加品种
    public function addMenu($data){
            $result = $this->allowField(true) -> save($data);
            if($result) {
                return 1;
            } else {
                return '注册失败!';
            }
    }



}