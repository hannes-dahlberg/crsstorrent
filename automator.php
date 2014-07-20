<?php
include_once('config.php');

set_log('Automator opened');

$updates = 0;
$total_torrent = 0;
foreach($rules as &$rule){
    if (($rule['latest'] + $rule['time']) <= time()){
        $torrents = feed_rules($rule['feed_url'], $rule['title'], $rule['link'], $rule['category'], true);
        foreach($torrents as $torrent){
            file_put_contents(($configs['torrent_folder']. str_replace('/', '', (string)$torrent->title)). '.torrent', file_get_contents((string)$torrent->link));
        }

        $rule['latest'] = time();
        $updates++;
        $total_torrent += count($torrents);

        set_log('Applied rule "'. $rule['name']. '" ('. $rule_times[$rule['time']]. ' from '. date('Y-m-d H:i'). ') and downloaded '. count($torrents). ' torrent files');
    }
}

if ($updates > 0){
    file_put_contents('configs/rules.inc', serialize($rules));
}
set_log('Automator closed with '. $updates. ' rule(s) applied and '. $total_torrent. ' torrent(s) downloaded');