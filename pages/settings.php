<?php
    if (isset($_POST['username'])){
        $password = crypt($_POST['password'], base64_encode($_POST['password']));
        $htpasswd = $_POST['username']. ':'. $password;

        file_put_contents('configs/.htpasswd', $htpasswd);
        $configs['torrent_folder'] = $_POST['torrent_folder'];

        config_save($configs);

        header('location: ?page='. $page);
        exit();
    }
?>
<h1>Settings</h1>
<div class="settings">
    <form action="" method="post">
        <h2>Login credentials</h2>
        <p>
            <label for="username">
                Username:
            </label>
            <input id="username" type="text" name="username" value="<?=$configs['username']?>" />
        </p>
        <p>
            <label for="password">
                Password:
            </label>
            <input id="password" type="text" name="password" />
        </p>
        <p class="devider"></p>
        <h2>Download</h2>
        <p>
            <label for="torrent_folder">
                Torrent folder:
            </label>
            <input id="torrent_folder" type="text" name="torrent_folder" value="<?=$configs['torrent_folder']?>" />
        </p>
        <p>
            <input type="submit" value="Save" />
        </p>
    </form>
</div>
