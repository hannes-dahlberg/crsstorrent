<?php
date_default_timezone_set('Europe/Stockholm');

$server_address = 'http://hannes.drmard.com/crsstorrent/';
$server_root = $_SERVER['DOCUMENT_ROOT']. '/crsstorrent/';

include_once('functions.php');

$configs = config_load();

$menu = array(
    array('NAME' => 'RSS-feeds', 'URL' => 'feeds', 'TITLE' => 'Manage your RSS-feeds'),
    array('NAME' => 'Rules', 'URL' => 'rules', 'TITLE' => 'Rules for downloading torrent files from your feeds'),
    array('NAME' => 'Settings', 'URL' => 'settings', 'TITLE' => 'Settings for cronRSS Torrent'),
    array('NAME' => 'Log', 'URL' => 'log', 'TITLE' => 'log of all that has happened')
);

$rule_times = array(
    (60) => 'Every minute',
    (60*5) => 'Every 5 minute',
    (60*10) => 'Every 10 minute',
    (60*15) => 'Every 15 minute',
    (60*20) => 'Every 20 minute',
    (60*30) => 'Every 30 minute',
    (60*45) => 'Every 45 minute',
    (60*60) => 'Every hour'
);

$page = $menu[0]['URL'];
if (isset($_GET['page'])){
    foreach($menu as $menu_item){
        if ($menu_item['URL']===$_GET['page']){
            $page = $menu_item['URL'];
            break;
        }
    }
}

if (file_exists('configs/feeds.inc'));
    $feeds = @unserialize(file_get_contents('configs/feeds.inc'));
if (file_exists('configs/rules.inc'));
    $rules = @unserialize(file_get_contents('configs/rules.inc'));