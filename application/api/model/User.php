<?php


namespace app\api\model;

use think\Model;
use traits\model\SoftDelete;

class User extends Model
{
    //软删除
    use SoftDelete;

    //登陆
    public function login($data){
        $validate = new \app\common\validate\User();
        $result	= $validate->scene('sceneLogin')->check($data);
        if (!$result){
            return $validate->getError();
        }
        $result = $this->where($data)->find();
        if($result){
//            检查账户是否可用,status为1可用，
            if($result['status'] != 1) {
                return '此账户被禁用';
            }
//            登陆成功后保存状态
            $sessionData = [
                'id' =>$result['id'],
                'nickname'=>$result['nickname']
            ];
            session('admin',$sessionData);
//            1表示有这个用户，用户名和密码正确
            return 1;
        }else{
            return '用户名或密码错误！';
        }
    }

    //注册
    public  function register($data){
        $validate = new \app\common\validate\User();
        $result	= $validate->scene('sceneRegister')->check($data);
        if (!$result) {
            return $validate->getError();
        }
        $result = $this->allowField(true) -> save($data);
        if($result) {
            return 1;
        } else {
            return '注册失败!';
        }
    }


    //重置密码
    public function resetPassword($data)
    {
        {
            $validata = new \app\common\validate\User();
            if (!$validata->scene('$sceneReset')->check($data)) {
                $validata->getError();
            }
            $adminInfo = $this->where('email', $data['email'])->find();
            $adminInfo->password = $data['password'];
            $adminInfo->conPassword = $data['conPassword'];
            $result = $adminInfo->save();
            if ($result) {
                $content = '恭喜您，密码重置成功!<br>用户名:' . $adminInfo['username'] . '<br>.新密码:'
                    . $data['password'];
                mailto($data['email'], '密码重置成功！', $content);
                return 1;
            } else {
                return '密码重置失败！';
            }
        }
    }



}