<?php

    /**
     * php入口文件
     */
    require_once './Controlelrs/MetalController.php';
    $input_json = file_get_contents('./input.json');
    $metal = new \Controllers\MetalController();
    $metal->order($input_json);


