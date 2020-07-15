<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function token(){
        $appid="wx8ca8cb8ce820d272";
        $secret="97698e5e537e0dabf5e331a0d523d6d2";
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
        $content=file_get_contents($url);
        echo $content;
    }
}
