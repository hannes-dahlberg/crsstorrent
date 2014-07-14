<?php
session_start();

include_once('config.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>cronRSS Torrent</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    <body>
        <div id="container">
            <div id="header">

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