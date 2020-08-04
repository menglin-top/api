<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get("/api/info","TestController@info");
Route::post("/api/login","TestController@login");
//解密
Route::any("/api/decrypt","Api\TestController@decrypt");//对称解密
Route::any("/api/un_decrypt","Api\TestController@un_decrypt");//非对称解密
Route::any("/api/sign","Api\TestController@sign");//接收签名
Route::any("/api/open_sign","Api\TestController@open_sign");//公钥解密签名
Route::any("/api/sign_decrypt","Api\TestController@sign_decrypt");//非对称解密+签名

//h5商城 --- 逻辑
Route::any("/index/login","Index\AdminController@login");//逻辑登陆
Route::any("/index/reg","Index\AdminController@reg");//逻辑注册
Route::any("/index/user","Index\AdminController@user");//逻辑注册

Route::any("/goods/product","Goods\IndexController@product");//商品详情
Route::any("/goods/cart","Goods\IndexController@cart");//添加到购物车

