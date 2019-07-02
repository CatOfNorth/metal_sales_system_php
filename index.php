<?php

    /**
     * php入口文件
     */
    date_default_timezone_set('UTC');
    require_once './Controlelrs/MetalController.php';
    $input_json = file_get_contents('./input.json');
    $metal = new \Controllers\MetalController();
    $info = $metal->order($input_json);


    //组装打印凭证
    $string = "方鼎银行贵金属购买凭证"." \n\n";

    $string .= "销售单号:".$info['member_message']['orderId']."\t 日期:".$info['member_message']['createTime']."\n";
    $string .= "客户卡号:".$info['member_message']['orderId']."\t 会员姓名:".$info['member_message']['memberName']."\t 客户等级:".$info['card_name']."\t 累计积分:".$info['member_message']['score']."\n\n";

    $string .= "商品及数量\t\t\t 单价 \t\t\t 金额\n";
    $string .= $info["product_message"];


    $string .= "合计：". $info["product_message_price"]."\n\n";

    $string .= "优惠清单：\t";
    $string .= $info["coupon_message"];

    $string .= "优惠合计：". $info["coupon_message_price"]."\n\n";
    $string .= "应收合计：". $info["score"]."\n";
    $string .= "收款：\n";


    $string .= " 余额支付：".$info["score"]."\n\n";
    $string .= " 客户等级与积分：\n";
    $string .= " 新增积分：".$info["score"]."\n";

        $string .= "恭喜您升级为".$info["card_name"]."客户！";


    file_put_contents("./result.txt",$string);


