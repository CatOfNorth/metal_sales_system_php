<?php
namespace Controllers;
use Model\CouCoupon;
use Model\Discount;
use Model\Member;
use Model\MemberGrade;
use Model\Product;

require_once './Model/Member.php';
require_once './Model/CouCoupon.php';
require_once './Model/MemberGrade.php';
require_once './Model/Product.php';
/**
 * Created by PhpStorm.
 * User: dell1
 * Date: 2019/7/2
 * Time: 19:04
 */

class MetalController
{
    public function order($info){
        $info = json_decode($info,true);
        //获取当前用户信息
        if(!isset($info['memberId'])){
            return '请输入当前用户信息';
        }
        $member = Member::getMember($info['memberId']);
        //打印用户信息凭证
        $member_message = $this->memberMessage($member,$info);
        //处理商品相关信息
        if(!isset($info['items'])){
            return '请选择相应商品';
        }
        //打印商品信息
        $product_message = '';
        $product_message_price = 0;
        foreach($info['items'] as $item){
            $res_product_message = $this->productMessage($item['product'],$item['amount']);
            if(!empty($res_product_message)){
                $product_message .= $res_product_message['str'].'\r\n';
                $product_message_price += $res_product_message['amount'];
            }
        }


        //判断九折券
        $discount_cards = 0;
        if(isset($info['discountCards'])){
            $discount_cards = $this->discountCoupon($info['discountCards']);
        }

        //满减逻辑处理
        $coupon_message = '';
        $coupon_message_price = 0;
        foreach($info['items'] as $item){
            $product_info = $this->getGoodsDiscount($item['product'],$item['amount'],$discount_cards);
            $coupon_price = 0;
            if(!empty($product_info)){
                if($product_info['discount_fee'] != 0){
                    $coupon_price += $product_info['discount_fee'];
                }
                if($product_info['discount_card'] != 0){
                    $coupon_price += $product_info['discount_card'];
                }
                if($coupon_price > 0){
                    $coupon_message .= '('.$product_info.')'.$product_info['product_name'].': -'.$coupon_price.'\r\n';
                    $coupon_message_price += $coupon_price;
                }
            }

        }

        //处理积分逻辑
        $money = $product_message_price - $coupon_message_price;//应收合计
        $score = $money*$this->scoreMessage($member);  //新增积分
        //累计积分
        $member_message['score'] = $member_message['score'] + $score;
        //判断当前用户积分所处的用户等级
        $card_name = $this->getMemberScore($member_message['score']);

        return [
            'member_message'        => $member_message,
            'product_message'       => $product_message,
            'product_message_price' => $product_message_price,
            'coupon_message'        => $coupon_message,
            'coupon_message_price'  => $coupon_message_price,
            'score'                 => $score,
            'card_name'             => $card_name,
        ];

    }

    /**
     * 根据当前积分获取用户级别
     * @param $score
     * @return string
     */
    public function getMemberScore($score){
        $grade = MemberGrade::GRADE;
        $card_name = '';
        foreach($grade as $val){
            if(!empty( $score['sectionTop'])){
                if($score >= $val['sectionBot'] && $score < $score['sectionTop']){
                    $card_name = $val['name'];
                }
            }else{
                if($score >= $val['sectionBot']){
                    $card_name = $val['name'];
                }
            }
            return $card_name;

        }
    }

    /**
     * 获取当前用户积分比率
     * @param $member
     * @return mixed
     */
    public function scoreMessage($member){
        $member_grade = MemberGrade::GRADE;
        return $member_grade[$member['type']]['integralMult'];
    }

    /**
     * 打印商品信息
     * @param $product_id
     * @param $amount
     * @return array|string
     */
    public function productMessage($product_id,$amount){
        $str = '';
        $product = Product::getProduct($product_id);
        if(empty($product)){
            return '';
        }
        $total_price = $amount * $product['price'];
        $str .= '('.$product['no'].')'.$product['name'].'*'.$amount.', '.$product['price'].', '.$total_price;
        return [
            'str'    => $str,
            'amount' => $total_price
        ];
    }

    /**
     * 查询当前打折券，打折比例
     * @param $discountCards
     * @return string
     */
    public function discountCoupon($discountCards){
        $cards = Discount::DISCOUNT;
        if(array_key_exists($discountCards,$cards)){
            return $cards[$discountCards]['count'];
        }
        return '';
    }

    /**
     * 用户信息凭证
     * @param $member
     * @param $info
     * @return mixed
     */
    public function memberMessage($member,$info){
        $member_message['orderId']       = $info['orderId'];
        $member_message['createTime']    = $info['createTime'];
        $member_message['memberId']      = $info['memberId'];
        $member_message['memberName']    = $member['name'];
        $member_message['type']          = $member['type_name'];
        $member_message['score']         = 0;
        return $member_message;
    }

    /**
     * 获取当前商品信息
     */
    public function getGoodsDiscount($product_id,$amount,$discount_cards){

        $product = Product::getProduct($product_id);
        if(empty($product)){
            return '';
        }

        $full_discount_fee   = 0;
        $result = [
            'discount_fee'  => 0, //满减折扣价
            'discount_card' => 0,         //九折券折扣价格
            'product_id'    => $product['no'],
            'product_name'  => $product['name']
        ];
        //满四送一
        $number_discount_fee_four = 0;
        if($amount>3 && $product['fullCutCoupon'] == 1){
            $number_discount_fee_four = $product['price']*($amount-1);
        }
        //满三一件半价
        $number_discount_fee_three = 0;
        if($amount>=3 && $product['fullCutCoupon'] == 3){
            $number_discount_fee_three = $product['price']*($amount-1)+$product['price']/2;
        }
        //获取满减优惠力度比较大的一个金额
        if($number_discount_fee_four > $number_discount_fee_three){
            $number_discount_fee = $number_discount_fee_four;
        }else{
            $number_discount_fee = $number_discount_fee_three;
        }
        //参与满减活动
        if($number = $result['fee']/3000){
            $full_discount_fee = CouCoupon::COUPON['3000'];
        }elseif($number = $result['fee']/2000){
            $full_discount_fee = CouCoupon::COUPON['2000'];
        }elseif($number = $result['fee']/1000){
            $full_discount_fee = CouCoupon::COUPON['1000'];
        }

        //判断当前商品开门红活动优惠力度最大的一种
        if($full_discount_fee > $number_discount_fee){
            $result['discount_fee'] = $full_discount_fee;
        }else{
            $result['discount_fee'] = $number_discount_fee;
        }

        //判断当前商品是否适用于九折券,算出打折金额
        if($product['discountType'] == $discount_cards){
            $result['discount_card'] = $amount*$product['price']*(1-$discount_cards);
        }

        return $result;
    }


}