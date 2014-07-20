<?php
session_start();

include_once('../config.php');

$matches = array();
if (isset($_GET['feed']) && isset($_GET['rule_title']) && isset($_GET['rule_link']) && isset($_GET['rule_category'])){
    $matches = feed_rules($_GET['feed'], $_GET['rule_title'], $_GET['rule_link'], $_GET['rule_category']);
}
if (!empty($matches)){
    ?>
    <table>
        <thead>
            <tr>
                <th>
                    Title
                </th>
                <th>
                    Link
                </th>
                <th>
                    Category
                </th>
            </tr>
        </thead>
        <?php
        foreach($matches as $match){
            ?>
            <tbody>
                <tr>
                    <td>
                        <?=$match->title?>
                    </td>
                    <td>
                        <?=$match->link?>
                    </td>
                    <td>
                        <?=$match->category?>
                    </td>
                </tr>
            </tbody>
            <?php
        }
        ?>
    </table>
    <?php
}else{
    ?>
    <i>No files where found with this regex</i>
    <?php
}
?>