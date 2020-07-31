<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;
use App\Model\Token;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;

class AdminController extends Controller
{
    //登陆
    public function login(){
        $username = request()->post("username");
        $pwd = request()->post("pwd");
        $user=User::where(["username"=>$username])->first();
        if($user){
            $pwd=password_verify($pwd,$user->pwd);
            if($pwd){
                $token=Str::random(32);
                $token=sha1($token);
                $data=[
                    "token"=>$token,
                    "uid"=>$user->user_id
                ];
                Token::create($data);
                $response=[
                    "errno"=>"0",
                    "msg"=>"登陆成功",
                    "data"=>[
                        "token"=>$token,
                        "uid"=>$user->user_id
                    ]
                ];

            }else{
                $response=[
                    "errno"=>"40001",
                    "msg"=>"密码有误,请重新输入密码",
                ];
            }
            return $response;
        }else{
            $response=[
                "errno"=>"40002",
                "msg"=>"请输入正确的用户名",
            ];
            return $response;
        }
    }
    //注册
    public function reg(){
        $username = request()->get("username");
        if(empty($username)){
            $response=[
                "errno"=>"40003",
                "msg"=>"用户名不能为空",
            ];
            return $response;
        }
        $email = request()->get("email");
        $pwd = request()->get("pwd");
        if(empty($pwd)){
            $response=[
                "errno"=>"40003",
                "msg"=>"密码不能为空",
            ];
            return $response;
        }
        $pwd2 = password_hash($pwd, PASSWORD_DEFAULT);
        $data=[
            "username"=>$username,
            "email"=>$email,
            "pwd"=>$pwd2,
        ];
        User::create($data);
        $response=[
            "error"=>0,
            "msg"=>"注册成功"
        ];
        return $response;
    }
    public function user(){
        $token=request()->get("token");
        echo $token;
    }
}
