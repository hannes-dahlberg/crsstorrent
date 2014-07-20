<?php
function pre($object){
    return '<pre>'. print_r($object, true). '</pre>';
}

function short_string($string, $length, $suffix = '...'){
    if (strlen($string) <= $length)
        return $string;

    $pos = strpos(substr($string, $length), ' ');
    if ($pos <= 5){
        $pos = $length + $pos;
    }else{
        $pos = $length;
    }

    return substr($string, 0, $pos). $suffix;
}

function config_load(){
    global $server_root;

    $file_content = file($server_root. 'configs/config.inc');

    $configs = array();
    foreach($file_content as $row){
        $configs[substr($row, 0, strpos($row, '='))] = trim(substr($row, (strpos($row, '=') + 1)));
    }

    return $configs;
}

function config_save($configs){
    global $server_root;

    $file_content = '';
    foreach($configs as $key => $value){
        $file_content .= $key. '='. $value. "\n";
    }
    $file_content = substr($file_content, 0, -1);

    file_put_contents($server_root. 'configs/config.inc', $file_content);
}

function set_notification($type, $header, $content){
    $_SESSION['notification']['type'] = $type;
    $_SESSION['notification']['header'] = $header;
    $_SESSION['notification']['content'] = $content;
}

function set_log($message){
    global $server_root;
    $new_row = '';
    if (file_exists($server_root. 'temp/log'))
        $new_row = "\n";
    file_put_contents($server_root. 'temp/log', ($new_row. date('Y-m-d H:i:s'). ' - '. $message), FILE_APPEND);
}

function load_rss($rss_feed, $force = false){
    global $server_root;

    $filename = $server_root. 'temp/feeds/'. md5($rss_feed);
    if (!file_exists($filename) || (file_exists($filename) && (filemtime($filename) + (60 * 10)) < time()) || $force){
        file_put_contents($filename, file_get_contents($rss_feed));
    }
    return simplexml_load_file($filename, null, LIBXML_NOCDATA);
}

function feed_categories($rss_feed){
    $xml = load_rss($rss_feed);

    $categories = array();
    foreach($xml->channel->item as  $item){
        $category = (string)$item->category;
        if (!isset($categories[$category])){
            $categories[$category] = $category;
        }
    }
    return $categories;
}

function feed_rules($rss_feed, $title_rule, $link_rule, $category_rule, $force = false){
    $xml = load_rss($rss_feed, $force);

    $matches = array();
    foreach($xml->channel->item as  $item){
        if ((empty($title_rule) || preg_match($title_rule, (string)$item->title)) && (empty($link_rule) || preg_match($link_rule, (string)$item->link)) && (empty($category_rule) || preg_match($category_rule, (string)$item->category))){
            $matches[] = $item;
        }
    }

    return $matches;
}