<?php

    /**
     * php入口文件
     */
    date_default_timezone_set('UTC');
    require_once './Controlelrs/MetalController.php';
    $input_json = file_get_contents('./input.json');
    $metal = new \Controllers\MetalController();
    $member_info = $metal->order($input_json);
echo "<pre>";
    var_dump($member_info);


