<?php


namespace app\api\controller;

use think\Db;
use think\Controller;

class Leavemessage extends Controller
{
    //获取留言
    public function getmsglist(){
        $data = Db::table('wp_leave_message')->select();
        return json($data);
    }

    //获取指定留言
    public function getmsg(){
        $data = json_decode(file_get_contents("php://input"), true);
        $data = Db::table('wp_leave_message')->find($data);
        return json($data);
    }

    //添加留言
    public function addmsg(){
        $data = json_decode(file_get_contents("php://input"), true);
        $result = Db::table('wp_leave_message')->insert($data);
        $msg_success = array('code' => 200,'msg' => "添加成功！");
        $msg_fail = array('code' => 100,'msg' => "添加失败！");
        header('Content-Type:application/json');//加上这行,前端那边就不需要var result = $.parseJSON(data);
        if ($result) {
            echo json_encode($msg_success,JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($msg_fail,JSON_UNESCAPED_UNICODE);
        }
    }

}