<?php
namespace Model;
require_once './Model/MemberGrade.php';
/**
 * 用户类
 * Class Product
 * @package Model
 */
class Member{

    /**
     * 所有用户信息
     * @var array
     */
    const MEMBER = [
        '6236609999'    => [
            'name'      =>'马丁',
            'type'      =>'1',
            'type_name' =>'普卡',
            'score'     =>9860,
        ],
        '6630009999'    => [
            'name'      =>'王立',
            'type'      =>'2',
            'type_name' =>'金卡',
            'score'     =>48860
        ],
        '8230009999'=> [
            'name'      =>'李想',
            'type'      =>'3',
            'type_name' =>'白金卡',
            'score'     =>98860
        ],
        '9230009999'=> [
            'name'      =>'张三',
            'type'      =>'4',
            'type_name' =>'钻石卡',
            'score'     =>198860
        ]
    ];

    /**
     * 获取当前用户信息
     * @param $member_id
     * @return bool|mixed
     */
    public static function getMember($member_id){
        if(!array_key_exists($member_id,self::MEMBER)){
           return null;
        }
        return self::MEMBER[$member_id];
    }

    /**
     * 获取当前用户积分倍数
     * @param $member_id
     * @return null
     */
    public static function getMemberGrade($member_id){
        $member = self::getMember($member_id);
        if(empty($member)){
            return null;
        }
        $grade = MemberGrade::grade;
        return $grade[$member['type']];
    }




}