<?php
function pre($object){
    return '<pre>'. print_r($object, true). '</pre>';
}

function config_load(){
    $file_content = file('configs/config.inc');

    $configs = array();
    foreach($file_content as $row){
        $configs[substr($row, 0, strpos($row, '='))] = trim(substr($row, (strpos($row, '=') + 1)));
    }

    return $configs;
}

function config_save($configs){
    $file_content = '';
    foreach($configs as $key => $value){
        $file_content .= $key. '='. $value. "\n";
    }
    $file_content = substr($file_content, 0, -1);

    file_put_contents('configs/config.inc', $file_content);
}