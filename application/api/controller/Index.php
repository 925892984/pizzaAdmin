<?php
namespace app\api\controller;
use think\Controller;
use think\Db;
use think\exception\Handle;


class Index extends Controller
{
    //测试数据库是否连接成功
    public function index()
    {
        echo '连接成功';
        //exit();
        $num = Db::table('wp_test')->where('id',1)->find();
        dump($num);
    }

    //用户数据接口  获取所有用户数据
    public function users(){
        $num = Db::table('wp_user')->select();
        return json($num);
    }
    //获取单个数据
    public function user(){
        $data = json_decode(file_get_contents("php://input"), true);
        $num = Db::table('wp_user')->find($data);
        return json($num);
    }
    //更新个人信息
    public function updataUser(){
        $data = json_decode(file_get_contents("php://input"), true);
        $result = Db::table('wp_user')->update($data);
        $msg_success = array('code' => 200,'msg' => "更新成功！");
        $msg_fail = array('code' => 100,'msg' => "更新失败！");
        header('Content-Type:application/json');//加上这行,前端那边就不需要var result = $.parseJSON(data);
        if ($result) {
            echo json_encode($msg_success,JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($msg_fail,JSON_UNESCAPED_UNICODE);
        }
    }

    //注册
    public function register(){
        //接受数据
        $data = json_decode(file_get_contents("php://input"), true);
        $result = model('User')->register($data);
        $msg_success = array('code' => 200,'msg' => "注册成功！");
        $msg_fail = array('code' => 100,'msg' => "注册失败！");
        header('Content-Type:application/json');//加上这行,前端那边就不需要var result = $.parseJSON(data);
        if ($result == 1) {
            mailto($data['email'],'注册账户成功！','注册账户成功!');
            echo json_encode($msg_success,JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($msg_fail,JSON_UNESCAPED_UNICODE);
        }
    }
    //登陆
    public  function login(){
        //接受数据
        $data = json_decode(file_get_contents("php://input"), true);
        $result = model('User')->login($data);
        $data= Db::table('wp_user')->where('email',$data['email'])->find();
        $msg_success = array('code' => 200,'msg' => "登陆成功！",'data' => $data);
        $msg_fail = array('code' => 100,'msg' => "登陆失败！");
        header('Content-Type:application/json');//加上这行,前端那边就不需要var result = $.parseJSON(data);
        if ($result == 1) {
            echo json_encode($msg_success,JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($msg_fail,JSON_UNESCAPED_UNICODE);
        }
    }

    //忘记密码
    public function forget(){
        $data = json_decode(file_get_contents("php://input"), true);
        $id= Db::table('wp_user')->where('email',$data['email'])->value('id');
        $msg_success = array('code' => 200,'id' => $id);
        $msg_fail = array('code' => 100);
        header('Content-Type:application/json');//加上这行,前端那边就不需要var result = $.parseJSON(data);

        //手机验证码
        $code = mt_rand(1000,9999);
        session('code',$code);
        $msg = mailto($data['email'],'重置密码验证码','你的密码验证码是:'.$code);
        if (!$id){
            echo json_encode($msg_fail,JSON_UNESCAPED_UNICODE);
        }else if(!$msg){
            echo json_encode(array('msg' => '验证码发送失败！'),JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($msg_success,JSON_UNESCAPED_UNICODE);
        }
    }

    //校验验证码
    public function reset(){
        $data = json_decode(file_get_contents("php://input"), true);
        $msg_success = array('code' => 200);
        $msg_fail = array('code' => 100);
        header('Content-Type:application/json');//加上这行,前端那边就不需要var result = $.parseJSON(data);
        if (session('code') == intval($data['code'])){  //判断验证码是否正确  $data['code'] != session('code')
            echo json_encode($msg_success,JSON_UNESCAPED_UNICODE);
        } else{
            echo json_encode($msg_fail,JSON_UNESCAPED_UNICODE);
        }
    }
    //更新密码
    public function resetPassword(){
        $data = json_decode(file_get_contents("php://input"), true);
        $result = model('User')->resetPassword($data);
        $msg_success = array('code' => 200,'msg' => "重置密码成功！");
        $msg_fail = array('code' => 100,'msg' => "重置密码失败！");
        header('Content-Type:application/json');//加上这行,前端那边就不需要var result = $.parseJSON(data);
        if ($result == 1) {
            echo json_encode($msg_success,JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($msg_fail,JSON_UNESCAPED_UNICODE);
        }
    }

}
