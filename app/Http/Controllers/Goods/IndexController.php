<?php

namespace App\Http\Controllers\Goods;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Goods;
use App\Model\Cart;

class IndexController extends Controller
{
    public function product(){
        $goods_num=request()->post("goods_num");//商品数量
        $goods_price=request()->post("goods_price");//商品价格
        $goods_id=request()->post("goods_id");//商品id
        $num=$goods_num*$goods_price;//商品总价
        $data=[
            "sale_num"=>$goods_num,
            "total"=>$num
        ];
        $res=Goods::where("goods_id",$goods_id)->update($data);
        print_r($res);
    }
    //添加到购物车
    public function cart(){
        $goods_id=request()->get("goods_id");
        $goods_info=Goods::where("goods_id",$goods_id)->first();
        $shop_num=Cart::where("goods_id",$goods_id)->value("shop_num");
        if($shop_num){
            $data=[
                "shop_num"=>$shop_num+1,
            ];
            $res=Cart::where("goods_id",$goods_id)->update($data);
        }else{
            $data=[
                "goods_name"=>$goods_info["goods_name"],
                "goods_id"=>$goods_id,
                "goods_sn"=>$goods_info["goods_sn"],
                "goods_number"=>$goods_info["goods_number"],
                "shop_price"=>$goods_info["shop_price"],
                "cat_id"=>$goods_info["cat_id"],
            ];
            //print_r($goods_info);
            $res=Cart::create($data);
        }
        var_dump($res);
    }
}
