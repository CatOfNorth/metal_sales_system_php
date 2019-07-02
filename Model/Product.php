<?php
namespace Model;
require_once './Model/Discount.php';
/**
 * 商品类
 * Class Product
 * @package Model
 */
class Product{

    /**
     * 所有商品
     * @var array
     */
    const PRODUCT = [
        '001001'=> [
            'name'          => '世园会五十国钱币册',
            'no'            => '001001',
            'unit'          => '册',
            'price'         => 998.00,
            'discountType'  => 0,
            'fullCutCoupon' => 0
        ],
        '001002'=>[
            'name'          => '2019北京世园会纪念银章大全40g',
            'no'            => '001002',
            'unit'          => '盒',
            'price'         => 1380.00,
            'discountType'  => 0.9,
            'fullCutCoupon' => 0
        ],
        '003001'=>[
            'name'          => '招财进宝',
            'no'            => '003001',
            'unit'          => '条',
            'price'         => 1580.00,
            'discountType'  => 0.95,
            'fullCutCoupon' => 0

        ],
        '003002'=>[
            'name'          => '水晶之恋',
            'no'            => '003002',
            'unit'          => '条',
            'price'         => 980.00,
            'discountType'  => 0,
            'fullCutCoupon' => 5

        ],
        '002002'=>[
            'name'          => '中国经典钱币套装',
            'no'            => '002002',
            'unit'          => '套',
            'price'         => 998.00,
            'discountType'  => 0,
            'fullCutCoupon' => 2

        ],
        '002001'=>[
            'name'          => '守扩之羽比翼双飞4.8g',
            'no'            => '002001',
            'unit'          => '条',
            'price'         => 1080.00,
            'discountType'  => 0.95,
            'fullCutCoupon' => 5

        ],
        '002003'=>[
            'name'          => '中国银象棋12g',
            'no'            => '002003',
            'unit'          => '套',
            'price'         => 698.00,
            'discountType'  => 0.9,
            'fullCutCoupon' => 1

        ],
    ];

    /**
     * 获取当前商品
     * @param $product_id
     * @return mixed|null
     */
    public static function getProduct($product_id){
        if(!array_key_exists($product_id,self::PRODUCT)){
            return null;
        }
        return self::PRODUCT[$product_id];
    }

    public static function getProductDiscount($product_id){
        $product = self::getProduct($product_id);
        if(empty($product)){
            return null;
        }
        $discount = Discount::DISCOUNT;
        switch($product['discountType']){
            
        }

    }


}