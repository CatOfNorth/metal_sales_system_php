<?php
namespace Model;
/**
 * Created by PhpStorm.
 * User: dell1
 * Date: 2019/7/2
 * Time: 18:53
 */
class CouCoupon{

    /**
     * 开门红活动优惠新
     * @var array
     */
    const COUPON = [
        '1' => [
            'type'          =>'01',
            'fullAmount'    =>'3000',
            'cutAmount'     =>'350',
            'price_type'    =>1
        ],
        '2' => [
            'type'          =>'01',
            'fullAmount'    =>'2000',
            'cutAmount'     =>'30',
            'price_type'    =>1
        ],
        '3' => [
            'type'          =>'01',
            'fullAmount'    =>'1000',
            'cutAmount'     =>'10',
            'price_type'    =>1
        ],
        '4' => [
            'type'          =>'02',
            'fullCount'     =>'3',
            'discount'      =>'1',
            'price_type'    =>0.5
        ],
        '5' => [
            'type'          =>'03',
            'fullCount'     =>'4',
            'discount'      =>'1',
            'price_type'    =>1
        ]
    ];

}