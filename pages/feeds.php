<?php
/*
https://www.torrentbytes.net/rss.php?passkey=a45328fcc1932ba531191269443e80a7&username=harvey88&41&40&43&42&1&33&19&48&4&22&38&5&6&47&23&32&20&25&30&12&37&28&34&27&31&44&45&46&26&limit=200&SSL=1&direct=1
http://rss.torrentleech.org/4cc235c2b5b6c5746466
*/
if (isset($_POST['feed_url'])){
    $rss = load_rss($_POST['feed_url']);
    $categories = feed_categories($_POST['feed_url']);
    $feeds[] = [
        'url' => $_POST['feed_url'],
        'name' => (string)$rss->channel->title,
        'categories' => $categories
    ];

    file_put_contents('configs/feeds.inc', serialize($feeds));

    set_notification('notice', 'Feed added', 'The new feed was added');
    set_log('Added feed "'. (string)$rss->channel->title. '" ('. $_POST['feed_url']. ')');

    header('location: ?page='. $page);
    exit;
}
if (isset($_GET['delete'])){

    //Remove any rss file stored
    @unlink('temp/feeds/'. md5($feeds[intval($_GET['delete'])]['url']));

    $log_message = 'Deleted feed "'. $feeds[intval($_GET['delete'])]['title']. '" ('. $feeds[intval($_GET['delete'])]['url']. ')';

    //Remove the rss from feed array
    unset($feeds[intval($_GET['delete'])]);

    //Save feed to file
    file_put_contents('configs/feeds.inc', serialize($feeds));

    set_notification('notice', 'Feed deleted', 'The feed was deleted');
    set_log($log_message);

    header('location: ?page='. $page);
    exit;
}
?>
<h1>Feeds</h1>
<div class="feeds">
    <form action="" method="post">
        <p>
            <label for="feed_url">
                New Feed:
            </label>
            <input id="feed_url" type="text" name="feed_url" />
            <input type="submit" value="Add" />
        </p>
    </form>
    <table>
        <thead>
            <tr>
                <th>
                    Name
                </th>
                <th>
                    URL
                </th>
                <th>
                    Delete
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($feeds)){
                foreach($feeds as $key => $feed){
                    ?>
                    <tr>
                        <td>
                            <?=$feed['name']?>
                        </td>
                        <td>
                            <?=short_string($feed['url'], 50)?>
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
