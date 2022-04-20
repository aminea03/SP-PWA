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
?>
<!DOCTYPE html>
<html lang="en" class="chat_background_color">

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
    <title>Chat</title>
</head>

<body class="colorgrey_chat">
    <div class="chat_content">
        <?php
        $chatQuery = $db->query("SELECT * FROM messages LEFT JOIN users ON messages.userId=users.userId");
        if ($chatQuery->num_rows) {
            while ($row = $chatQuery->fetch_object()) {
                $allMessages[] = $row;
            }
            foreach ($allMessages as $key => $value) {
                if ($key > array_key_last($allMessages) - 30) {
                    if ($key === array_key_last($allMessages)) {
                        echo "<div id='end' class='chatpwrapper'><p class='chatp1'>$value->userLogin</p><p class='chatp2'>$value->messageDate : </p><p> $value->messageContent</p></div>";
                    } else {
                        echo "<div id='' class='chatpwrapper'><p class='chatp1'>$value->userLogin</p><p class='chatp2'>$value->messageDate : </p><p> $value->messageContent</p></div>";
                    }
                }
            }
        }
        ?>
    </div>
</body>


</html>