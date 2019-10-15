<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class Index extends  Controller
{
    public function index()
    {

        $num = Db::table('wp_test')->where('id',1)->find();
        return json_encode($num);
    }
}
