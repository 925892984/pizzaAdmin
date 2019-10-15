<?php


namespace app\common\validate;


use think\Validate;

class User extends Validate
{
    //通用验证
    protected $rule = [
        'username|管理员账户' => 'require',
        'password|账户密码' => 'require',
        'conPassword|确认密码'=>'require|confirm:password',
        'nickname|昵称' => 'require',
        'email|邮箱' => 'require|email',
        'code|重置密码' => 'require',
        'id|ID' => 'require'
    ];

    protected $scene = [
        //场景验证

        //    登陆验证场景
        'sceneLogin' => ['email','password'],
        //    注册场景验证
        'sceneRegister' => ['password','conPassword','email'],
        //重置密码
        'sceneReset' => ['password','conPassword'],

    ];
}