<?php


namespace app\api\controller;


use think\Controller;
use think\Db;

class Commodity extends Controller
{
    //菜单
    public function menu(){
        $data = model('Menu')->with('classify')->select();
        return json($data);
    }

    //添加品种
    public function addMenu(){
        $data = json_decode(file_get_contents("php://input"), true);
        $result = model('Menu')->addMenu($data);
        $id= Db::table('wp_menu')->where('name',$data['name'])->value('id');
        $msg_success = array('code' => 200,'msg' => "添加成功！",'id' => $id);
        $msg_fail = array('code' => 100,'msg' => "添加失败！");
        if ($result == 1){
            echo json_encode($msg_success,JSON_UNESCAPED_UNICODE);
        }else{
            echo json_encode($msg_fail,JSON_UNESCAPED_UNICODE);
        }

    }

    //添加品种分类
    public function addClassify(){
        $data = json_decode(file_get_contents("php://input"), true);
        $result = model('menu_classify')->addClassift($data['classify']);
        $msg_success = array('code' => 200,'msg' => "添加成功！");
        $msg_fail = array('code' => 100,'msg' => "添加失败！");
        if ($result == 1){
            echo json_encode($msg_success,JSON_UNESCAPED_UNICODE);
        }else{
            echo json_encode($msg_fail,JSON_UNESCAPED_UNICODE);
        }
    }


    //通过id获取品种和品种分类信息
    public function menuMsg(){
        $data = json_decode(file_get_contents("php://input"), true);
        $msg = model('Menu')->with('classify')->select($data);
        $msg_success = array('code' => 200,'msg' => "添加成功！",'data'=>$msg);
        $msg_fail = array('code' => 100,'msg' => "添加失败！");
        if ($msg){
            echo json_encode($msg_success,JSON_UNESCAPED_UNICODE);
        }else{
            echo json_encode($msg_fail,JSON_UNESCAPED_UNICODE);
        }
    }

    //删除品种
    public function deleteMenu(){
        $data = json_decode(file_get_contents("php://input"), true);
        $result = Db::table('wp_menu')->delete($data);
        $delete = Db::table('wp_menu_classify')->where('menu_id',$data['id'])->delete();
        $msg_success = array('code' => 200,'msg' => "删除成功！");
        $msg_fail = array('code' => 100,'msg' => "删除失败！");
        if ($result && $delete){
            echo json_encode($msg_success,JSON_UNESCAPED_UNICODE);
        }else{
            echo json_encode($msg_fail,JSON_UNESCAPED_UNICODE);
        }
    }
}