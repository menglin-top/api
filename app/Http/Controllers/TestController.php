<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
class TestController extends Controller
{
    public function info(){
        echo "不愧是我";echo "<br>";
        echo Str::random(30);
    }
    public function login(){
        $name=request()->input("name");
        $email=request()->input("email");
        $response=[
            'name'=>$name,
            'email'=>$email
        ];
        return $response;
    }
}
