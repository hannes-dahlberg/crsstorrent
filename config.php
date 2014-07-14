<?php
include_once('functions.php');

$configs = config_load();

$menu = array(
    array('NAME' => 'RSS-feeds', 'URL' => 'feeds', 'TITLE' => 'Manage your RSS-feeds'),
    array('NAME' => 'Rules', 'URL' => 'rules', 'TITLE' => 'Rules for downloading torrent files from your feeds'),
    array('NAME' => 'Settings', 'URL' => 'settings', 'TITLE' => 'Settings for cronRSS Torrent')
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