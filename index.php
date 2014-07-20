<?php
session_start();

include_once('config.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>cronRSS Torrent</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css" />
        <link rel="stylesheet" href="//cdn.jsdelivr.net/jquery.ui.timepicker.addon/1.4.5/jquery-ui-timepicker-addon.min.css" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>
        <script src="//cdn.jsdelivr.net/jquery.ui.timepicker.addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script>
        <script src="script.js"></script>
    </head>
    <body>
        <?php
        if (isset($_SESSION['notification'])){
            ?>
            <div id="notification" class="notification <?=$_SESSION['notification']['type']?>">
                <h4><?=$_SESSION['notification']['header']?></h4>
                <p>
                    <?=$_SESSION['notification']['content']?>
                </p>
                <a id="notification_close" href="">Close</a>
            </div>
            <?php
            unset($_SESSION['notification']);
        }
        ?>
        <div id="container">
            <div id="header">
                <p class="title">cRSS-Torrent</p>
            </div>
            <div id="menu">
                <ul>
                    <?php
                    foreach($menu as $menu_item){
                        ?>
                        <li<?=($menu_item['URL']==$page ? ' class="selected"' : '')?>>
                            <a href="?page=<?=$menu_item['URL']?>" title="<?=$menu_item['TITLE']?>"><?=$menu_item['NAME']?></a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <div id="main">
                <?php
                include_once('pages/'. $page. '.php');
                ?>
            </div>
            <div id="footer">

            </div>
        </div>
    </body>
</html>