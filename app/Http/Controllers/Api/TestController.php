<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    //对称解密
    public function decrypt(){
        $enc_data = file_get_contents('php://input');
        $enc_data=base64_decode($enc_data);
        $key="1911api";
        $method="AES-256-CBC";
        $iv="aaaabbbbccccdddd";
        //解密
        $dec_data=openssl_decrypt($enc_data,$method,$key,OPENSSL_RAW_DATA,$iv);
        echo $dec_data;
    }
    //非对称解密
    public function un_decrypt(){
        $enc_data = file_get_contents('php://input');
        //解密
        $pri_key_count=file_get_contents(storage_path("keys/www.priv.key"));//获取私钥内容
        $pri_key=openssl_get_privatekey($pri_key_count);//获取私钥
        openssl_private_decrypt($enc_data,$dec_data,$pri_key);//私钥解密


        //加密返回数据
        $data="花里胡哨";
        $pub_key_count=file_get_contents(storage_path("keys/api.pub.key"));//获取api公钥内容
        $pub_key=openssl_get_publickey($pub_key_count);//获取api公钥
        openssl_public_encrypt($data,$enc_data2,$pub_key);//api公钥加密
        echo $enc_data2;
    }
    //接收签名
    public function sign(){
        $data=request()->get("data");
        $sign=request()->get("sign");
        $key="1911api";
        $sign_str=md5($key.$data);
        if($sign_str==$sign){
            echo "验签成功";
        }else{
            echo "验签失败";
        }
    }
    //验签
    public function open_sign(){
        $signtrue=request()->get("signtrue");
        $data=request()->get("data");
        //print_r($_GET);echo '<hr>';
        $signtrue2=base64_decode($signtrue);
        $pub_key_count=file_get_contents(storage_path("keys/api.pub.key"));
        //echo $pub_key_count; echo '<br />';
        $pub_key=openssl_get_publickey($pub_key_count);
        $status = openssl_verify($data,$signtrue2,$pub_key,OPENSSL_ALGO_SHA1);
        if($status){
            echo "验签成功";
        }else{
            echo "验签失败";
        }
    }
    //对称解密+签名
    public function sign_decrypt(){
        $data=request()->post("data");//签名内容
        $sign_enc_encrypt=request()->post("sign_enc_encrypt");//对称加密得数据
        $sign_enc_encrypt=base64_decode($sign_enc_encrypt);
        $sign_data=request()->post("sign_data");//签名
        //公钥验签
        $key="1911api";
        $pub_keys_count=file_get_contents(storage_path("keys/api.pub.key"));//获取公钥内容
        $pub_key=openssl_get_publickey($pub_keys_count);//获取公钥
        $signature=openssl_verify($data,$sign_data,$pub_key);
        //验签
        if($signature){
            echo "验签成功";echo "<hr>";
            //对称解密
            $method="AES-256-CBC";
            $iv="aaaabbbbccccdddd";
            $sign_dec_decrypt=openssl_decrypt($sign_enc_encrypt,$method,$key,OPENSSL_RAW_DATA,$iv);
            echo $sign_dec_decrypt;
        }else{
            echo "验签失败";
        }
    }
}
