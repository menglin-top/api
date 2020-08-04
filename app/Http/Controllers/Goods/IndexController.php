<?php

namespace App\Http\Controllers\Goods;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Goods;
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
}
