<?php
namespace Model;
/**
 * 用户等级类
 * Class Product
 * @package Model
 */
class MemberGrade
{

    /**
     * 用户等级
     * @var array
     */
    const GRADE = [
        '1'=> [
            'name'         =>'普卡',
            'integralMult' =>'1',
            'sectionBot'   =>'0',
            'sectionTop'   =>'10000',
        ],
        '2'=> [
            'name'         =>'金卡',
            'integralMult' =>'1.5',
            'sectionBot'   =>'10000',
            'sectionTop'   =>'50000',
        ],
        '3'=> [
            'name'         =>'白金卡',
            'integralMult' =>'1.8',
            'sectionBot'   =>'50000',
            'sectionTop'   =>'100000',
        ],
        '4'=> [
            'name'         =>'钻石卡',
            'integralMult' =>'2',
            'sectionBot'   =>'100000',
            'sectionTop'   =>'null',
        ]
    ];
}