<?php
require_once('/usr/local/cpanel/php/WHM.php');
WHM::header('Maldet GUI', 1, 1);

function open_file_per_line($file) {
    $handle = fopen($file, "r");
    if ($handle) {
        $lines = array();
        while (($line = fgets($handle)) !== false) {
            $lines[] = trim($line);
        }
        return $lines;
        fclose($handle);
    } else {
        return false;
    }
}

function all_cpanel_users() {
    $users = array();
    $userdomains = open_file_per_line('/etc/userdomains');
    foreach ($userdomains as $line) {
        $explode = explode(':', $line);
        $users[trim($explode[1])] = trim($explode[1]);
    }
    return $users;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Maldet GUI</title>
    </head>
    <body>
        <h1>Maldet WHM</h1>
        <textarea style="width: 100%; min-height: 200px; margin-bottom: 20px;">
            <?php
            if (isset($_POST['scan_user'])) {
                $user = $_POST['scan_user'];
                $background = $_POST['background'] == '1' ? ' -b ' : '';
                $all_cpanel_users = all_cpanel_users();
                if (isset($all_cpanel_users[$user]) AND file_exists('/home/' . $all_cpanel_users[$user])) {
                    echo shell_exec('maldet ' . $background . ' -a /home/' . $all_cpanel_users[$user]);
                }
            }
            if (isset($_POST['scanall'])) {
                $background = $_POST['background'] == '1' ? ' -b ' : '';
                echo shell_exec('maldet ' . $background . ' -a /home/');
            }
            if (isset($_POST['scanid'])) {
                $id = str_replace('.', '', str_replace('-', '', $_POST['scanid']));
                if (is_numeric($id)) {
                    echo shell_exec('maldet -e ' . $id);
                }else{
                    echo 'Invalid Scan ID ' . $id;
                }
            }
            ?>
        </textarea>
        <hr>
        <form action="" method="post">
            <p>Scan User</p>
            <select name="scan_user">
                <?php
                foreach (all_cpanel_users() as $user) {
                    ?>
                    <option value="<?= $user ?>"><?= $user ?></option>
                    <?php
                }
                ?>
            </select>
            <br>
            <input type="checkbox" name="background" value="1">Run in Background?
            <br>
            <input type="submit" name="scan" value="Scan User">
        </form>
        <hr>
        <form action="" method="post">
            <p>Scan ALL Users</p>
            <input type="checkbox" name="background" value="1">Run in Background?
            <br>
            <input type="submit" name="scanall" value="Scan ALL Users">
        </form>
        <hr>
        <hr>
        <form action="" method="post">
            <p>View the Scan Report by ID</p>
            <input type="text" name="scanid" value="">
            <br>
            <input type="submit" name="scanreportid" value="View the Scan Report">
        </form>
        <hr>
    </body>
</html>

<?php
WHM::footer();
?>