<?php


namespace app\api\model;
use think\Db;

use think\Model;

class MenuClassify extends Model
{
    public function addClassift($data){
        $num = 0;
        foreach ($data as $key => $value){
//            $result = $this->allowField(true) -> save($value);   //为什么不行？
            $result = Db::name('menu_classify')->insert($value);
            if ($result){
                $num++;
            }
        }
        if($num == count($data)){
            return 1;
        }else{
            return '添加失败';
        }
    }
}