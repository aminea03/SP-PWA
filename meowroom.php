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
        setInterval(() => {
            document.getElementById("chatframe").contentWindow.location.reload();
        }, 5000);
        setInterval(() => {
            document.getElementById("online").contentWindow.location.reload();

        }, 10000);

        // Sends message on Enter
        function sendOnEnter() {
            document.getElementById("chat_msg").addEventListener("keypress", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    document.getElementById("msg_form").submit();
                };
            })
        }
    </script>

    <title>Meowroom</title>
</head>

<body class="meowroom" onload="sendOnEnter()">
    <header class="meow_header">
        <img class="logo" src="images/logo_chatcha.png" alt="logo chat">
        <div class="header_right">
            <img src="images/param.png" alt="Engrenage">
            <a href="disconnect.php"><img src="images/disconnect.png" alt="Disconnect"></a>
        </div>
    </header>
    <main>
        <div class="center_wrapper">
            <div class="online_wrapper">
                <iframe src="online.php" id="online"></iframe>
            </div>
            <div class="chat_wrapper">
                <div class="chat">
                    <iframe src="chat.php#end" frameborder="0" id="chatframe">
                    </iframe>
                </div>
                <div class="typing_wrapper">
                    <form action="" method="POST" id="msg_form">
                        <textarea id="chat_msg" name="message" autofocus></textarea>
                    </form>
                    <button type="submit" form="msg_form"><img src="images/catfoot_button.png" alt="Submit button"></button>
                </div>
            </div>
        </div>
    </main>

</body>
<script>
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

    window.addEventListener('online', (event) => {
        let data = {
            message: "barium"
        };

        fetch("/meowroom.php", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(res => {
            console.log("Request complete! response:", res);
        });
        /*    if (localStorage.getItem("msgStorage")) {
               localStorage.getItem("msgStorage").forEach(element => {


               });
           } */
    });
</script>


</html>