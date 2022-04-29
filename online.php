<?php

session_start();
// DISPLAY ALL ERRORS
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION["userId"])) {
    header("location: index.php");
}
$db = new mysqli("mysql-tppwa.alwaysdata.net:3306", "tppwa", "988uiND/.p3nhOPD.", "tppwa_chatcha");

// Resets online user list (inactive users for more than 180 sec are shown offline)
$refreshOnlineStatus = $db->query("UPDATE users SET userStatus='0' WHERE userDate < NOW() - INTERVAL 180 SECOND");

?>

<!DOCTYPE html>
<html lang="en" translate="no">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="chatcha.css">
    <link rel="icon" href="images/icon192.png">
    <link rel="apple-touch-icon" href="/images/icon192.png">
    <meta name="apple-mobile-web-app-status-bar" content="#00B3AF">
    <meta name="theme-color" content="#00B3AF">
    <meta http-equiv=”Pragma” content=”no-cache”>
    <meta http-equiv=”Expires” content=”-1″>
    <meta http-equiv=”CACHE-CONTROL” content=”NO-CACHE”>
    <title>Online</title>
    <script>
        c = 0;

        function show_details() {
            if (c == 0) {
                event.target.nextSibling.style.display = "block";
                c = 1;
            } else {
                event.target.nextSibling.style.display = "none";
                c = 0;
            }

        }
    </script>
</head>

<body class="colorgrey_online">
    <p class="online_wrapper_title">Online :</p>
    <div class="online">
        <?php
        $onlineQuery = $db->query("SELECT * FROM users WHERE userStatus='1'");
        if ($onlineQuery->num_rows) {
            while ($row = $onlineQuery->fetch_object()) {
                $onlineList[] = $row;
            }
            foreach ($onlineList as $value) {
                echo "<div><div class='online_line' onclick='show_details()'><img src='images/" . $value->userType . ".png'><p>$value->userLogin</p></div>";
                echo "<div class='details'><p>Type : $value->userType</p><p>Meows : $value->userCount</p><p>Last : $value->userDate</p></div></div>";
            }
        }
        ?>
    </div>

</body>

</html>