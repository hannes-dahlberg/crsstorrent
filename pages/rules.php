<?php
$rule_name = '';
$rule_feed = '';
$rule_title = '';
$rule_link = '';
$rule_category = '';
$rule_time = '';
$rule_start = time();
$rule_active = '';

$rule_submit = 'Add';

if (isset($_GET['edit'])){
    $rule_name = $rules[intval($_GET['edit'])]['name'];
    $rule_feed = $rules[intval($_GET['edit'])]['feed_url'];
    $rule_title = $rules[intval($_GET['edit'])]['title'];
    $rule_link = $rules[intval($_GET['edit'])]['link'];
    $rule_category = $rules[intval($_GET['edit'])]['category'];
    $rule_time = $rules[intval($_GET['edit'])]['time'];
    $rule_start = $rules[intval($_GET['edit'])]['start'];
    $rule_active = $rules[intval($_GET['edit'])]['active'];

    $rule_submit = 'Save';
}

if (isset($_POST['rule_name'])){
    $rss = load_rss($_POST['rule_feed']);
    $content = [
        'name' => $_POST['rule_name'],
        'feed_url' => $_POST['rule_feed'],
        'feed_name' => (string)$rss->channel->title,
        'title' => $_POST['rule_title'],
        'link' => $_POST['rule_link'],
        'category' => $_POST['rule_category'],
        'time' => $_POST['rule_time'],
        'start' => strtotime($_POST['rule_start']),
        'active' => $_POST['rule_active'],
        'latest' => strtotime($_POST['rule_start']),
    ];
    if (isset($_GET['edit']) && isset($rules[intval($_POST['edit'])])){
        $rules[intval($_GET['edit'])] = $content;
    }else{
        $rules[] = $content;
    }

    file_put_contents('configs/rules.inc', serialize($rules));

    if (isset($_GET['edit']) && isset($rules[intval($_GET['edit'])])){
        set_notification('notice', 'Rule saved', 'The rule was saves');
        set_log('Updated rule "'. $content['name']. '"');
    }else{
        set_notification('notice', 'Rule added', 'The new rule was added');
        set_log('Added rule "'. $content['name']. '"');
    }

    header('location: ?page='. $page);
    exit;
}
if (isset($_GET['delete'])){

    unset($rules[intval($_GET['delete'])]);

    $log_message = 'Deleted rule "'. $rules[intval($_GET['delete'])]['name']. '"';

    file_put_contents('configs/rules.inc', serialize($rules));

    set_notification('notice', 'Rule deleted', 'The rule was deleted');
    set_log($log_message);

    header('location: ?page='. $page);
    exit;
}
?>
<h1>Rules</h1>
<div class="rules">
    <form action="" method="post">
        <h2>New rule</h2>
        <p>
            <label for="rule_name">
                Name:
            </label>
            <input id="rule_name" type="text" name="rule_name" value="<?=$rule_name?>" />
        </p>
        <p>
            <label for="rule_feed">
                Feed:
            </label>
            <select id="rule_feed" name="rule_feed">
                <?php
                foreach($feeds as $value){
                    ?>
                    <option<?=($rule_feed==$value['url'] ? ' selected="selected"' : null)?> value="<?=$value['url']?>"><?=$value['name']?></option>
                    <?php
                }
                ?>
            </select>
        </p>
        <p>
            <label for="rule_title">
                Title rule:
            </label>
            <input id="rule_title" type="text" name="rule_title" value="<?=$rule_title?>" />
        </p>
        <p>
            <label for="rule_link">
                Link rule:
            </label>
            <input id="rule_link" type="text" name="rule_link" value="<?=$rule_link?>" />
        </p>
        <p>
            <label for="rule_category">
                Category rule:
            </label>
            <input id="rule_category" type="text" name="rule_category" value="<?=$rule_category?>" />
        </p>
        <div id="test_rule_result">
                <input id="test_rule_button" type="button" value="Test rules" />
                <div class="content">
                    <i>Click "Test rules" to test rules</i>
                </div>
        </div>
        <p>
            <label for="rule_time">
                Frequency:
            </label>
            <select id="rule_time" name="rule_time">
                <?php
                foreach($rule_times as $key => $value){
                    $selected = '';
                    if ((empty($rule_time) && $key==(60*10)) || $rule_time==$key)
                        $selected = ' selected="selected"';
                    ?>
                    <option<?=$selected?> value="<?=$key?>"><?=$value?></option>
                    <?php
                }
                ?>
            </select>
        </p>
        <p>
            <label for="rule_start">
                Start time:
            </label>
            <input id="rule_start" type="text" name="rule_start" value="<?=date('Y-m-d H:i', $rule_start)?>" />
            <script>
                $('#rule_start').datetimepicker({
                    dateFormat: 'yy-mm-dd',
                    timeFormat: 'HH:mm'
                });
            </script>
        </p>
        <p>
            <label>
                Active:
            </label>
            <input<?=($rule_active=='1' ? ' checked="checked"' : null)?> id="rule_active" type="checkbox" name="rule_active" value="1" />
            <label for="rule_active">Make rule active</label>
        </p>
        <p>
            <input type="submit" value="<?=$rule_submit?>" />
        </p>
    </form>
    <table>
        <thead>
        <tr>
            <th>
                Name
            </th>
            <th>
                Feed
            </th>
            <th>
                Frequency
            </th>
            <th>
                Start time
            </th>
            <th>
                Active
            </th>
            <th>
                Edit
            </th>
            <th>
                Delete
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($rules)){
            foreach($rules as $key => $rule){
                ?>
                <tr>
                    <td>
                        <?=$rule['name']?>
                    </td>
                    <td>
                        <span title="<?=$rule['feed_url']?>"><?=$rule['feed_name']?></span>
                    </td>
                    <td>
                        <?=$rule_times[$rule['time']]?>
                    </td>
                    <td>
                        <?=date('Y-m-d H:i:s', $rule['start'])?>
                    </td>
                    <td>
                        <?=$rule['active']?>
                    </td>
                    <td>
                        <a href="?page=<?=$page?>&amp;edit=<?=$key?>">Edit</a>
                    </td>
                    <td>
                        <a href="?page=<?=$page?>&amp;delete=<?=$key?>">Delete</a>
                    </td>
                </tr>
            <?php
            }
        }
        ?>
        </tbody>
    </table>
</div>
<?php
/*[0] => SimpleXMLElement Object
(
    [title] => The Footy Show NRL 2014 07 17 PDTV x264-RTA
    [pubDate] => Fri, 18 Jul 2014 12:04:03 +0000
    [category] => Episodes
    [guid] => http://www.torrentleech.org/torrent/529948
    [comments] => http://www.torrentleech.org/torrent/529948#comments
    [link] => http://www.torrentleech.org/rss/download/529948/4cc235c2b5b6c5746466/The.Footy.Show.NRL.2014.07.17.PDTV.x264-RTA.torrent
    [description] => Category: Episodes - Seeders: 9 - Leechers: 0
)

[0] => SimpleXMLElement Object
(
    [title] => VA-Berlin Minimal Underground Vol. 29-WEB-2014-VOiCE
    [description] => Music/MP3
    [pubDate] => Fri, 18 Jul 2014 13:09:37 +0100
    [category] => Music/MP3
    [guid] => https://www.torrentbytes.net/details.php?id=633645
    [link] => https://www.torrentbytes.net/download.php?id=633645&SSL=1
)*/