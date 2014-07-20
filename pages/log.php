<h1>Log</h1>
<div class="log">
    <?php
    $log = @file($server_root. 'temp/log');
    $log = array_reverse($log);
    if (!empty($log)){
        foreach($log as $row){
            ?>
            <p>
                <?=$row?>
            </p>
            <?php
        }
    }else{
        ?>
        <i>The log is empty</i>
        <?php
    }
    ?>
</div>