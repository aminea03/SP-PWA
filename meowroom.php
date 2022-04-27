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

if (isset($_POST["message"]) && $_POST["message"] != "") {
    $sendQuery = $db->query("INSERT INTO messages VALUES (NULL,'" . $_SESSION["userId"] . "',NOW(),'" . $_POST["message"] . "')");
    $_SESSION["userCount"] = $_SESSION["userCount"] + 1;
    $upgradeMeows = $db->query("UPDATE users SET userCount='" . $_SESSION["userCount"] . "', userDate=NOW(), userStatus='1' WHERE userId='" . $_SESSION["userId"] . "'");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="chatcha.css">
    <link rel="icon" href="images/icon192.png">
    <link rel="apple-touch-icon" href="/images/icon192.png">
    <meta name="apple-mobile-web-app-status-bar" content="#00B3AF">
    <meta name="theme-color" content="#00B3AF">
    <script src="chatcha.js"></script>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        setInterval(() => {
            document.getElementById("chatframe").contentWindow.location.reload();
        }, 5000);
        setInterval(() => {
            document.getElementById("online").contentWindow.location.reload();
        }, 10000);
    </script>

    <title>Meowroom</title>
</head>

<body class="meowroom">
    <header class="meow_header">
        <img class="logo" src="images/logo_chatcha.png" alt="logo chat">
        <div class="header_right">
            <img src="images/param.png" alt="Engrenage">
            <a id="disconnect" href="disconnect.php"><img src="images/disconnect.png" alt="Disconnect"></a>
        </div>
    </header>
    <main>
        <div class="center_wrapper">
            <div class="online_wrapper">
                <div class="offline_msg">
                    <img src="images/offline.svg" alt="Wifi">
                    <p>Network is offline.</p>
                    <p>Your messages will be sent when back online.</p>
                </div>
                <iframe src="online.php" id="online"></iframe>
            </div>
            <div class="chat_wrapper">
                <div class="chat">
                    <iframe src="chat.php#end" frameborder="0" id="chatframe">
                    </iframe>
                </div>
                <div class="typing_wrapper">
                    <form action="" method="POST" id="msg_form">
                        <input id="chat_msg" name="message" autofocus autocomplete="off"></input>
                    </form>
                    <button type="submit" form="msg_form"><img src="images/catfoot_button.png" alt="Submit button"></button>
                </div>
            </div>
        </div>
    </main>

</body>
<script>
    // If submit event, if offline then stores messages.
    document.getElementById("msg_form").addEventListener("submit", function(e) {
        if (!navigator.onLine) {
            e.preventDefault();
            if (window.localStorage) {
                let msgStorage = [];
                if (localStorage.getItem("msgStorage")) {
                    let oldStorage = localStorage.getItem("msgStorage");
                    msgStorage.push(oldStorage);
                }
                msgStorage.push(document.getElementById("chat_msg").value);
                localStorage.setItem("msgStorage", msgStorage);
                document.getElementById("chat_msg").value = "";
                document.getElementById("chat_msg").focus();

            }
        }
    })

    // If app launched offline, change "online section" css.
    if (!navigator.onLine) {
        document.querySelector(".offline_msg").style.display = "flex";
        document.getElementById("online").style.display = "none";
        document.getElementById("disconnect").style.display = "none";
    }

    // If app turns offline, change "online section" css.
    window.addEventListener('offline', (event) => {
        document.querySelector(".offline_msg").style.display = "flex";
        document.getElementById("online").style.display = "none";
        document.getElementById("disconnect").style.display = "none";
    });


    // When back online, sends the stored messages and restore original CSS.
    window.addEventListener('online', (event) => {
        document.querySelector(".offline_msg").style.display = "";
        document.getElementById("online").style.display = "";
        document.getElementById("disconnect").style.display = "";
        if (localStorage.getItem("msgStorage")) {
            var msgArray = localStorage.getItem("msgStorage").split(",");
            msgArray.forEach(element => {
                let fd = new FormData();
                fd.append("message", element);
                fetch('/meowroom.php', {
                    method: "POST",
                    body: fd
                })
            })
            localStorage.removeItem("msgStorage");
        }
        // And refresh iframes
        document.getElementById("chatframe").contentWindow.location.reload();
        document.getElementById("online").contentWindow.location.reload();
    })
</script>


</html>