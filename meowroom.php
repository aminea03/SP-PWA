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
<html lang="en" translate="no">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Page de messagerie instantanée meowroom du site chatcha">
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
            <a id="disconnect" href="disconnect.php" value="Déconnexion" name="binfo" onClick="Deconnexion()"><img src="images/disconnect.png" alt="Disconnect"></a>
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
                        <img class="emoticon_button" onclick="showEmoticons()" src="images/emoticon.svg" alt="Smiley">
                        <ul class="emoticon_list">
                            <li onclick="typeEmoticon()">😀</li>
                            <li onclick="typeEmoticon()">😁</li>
                            <li onclick="typeEmoticon()">😂</li>
                            <li onclick="typeEmoticon()">😃</li>
                            <li onclick="typeEmoticon()">😄</li>
                            <li onclick="typeEmoticon()">😅</li>
                            <li onclick="typeEmoticon()">😆</li>
                            <li onclick="typeEmoticon()">😇</li>
                            <li onclick="typeEmoticon()">😈</li>
                            <li onclick="typeEmoticon()">😉</li>
                            <li onclick="typeEmoticon()">😊</li>
                            <li onclick="typeEmoticon()">😋</li>
                            <li onclick="typeEmoticon()">😌</li>
                            <li onclick="typeEmoticon()">😍</li>
                            <li onclick="typeEmoticon()">😎</li>
                            <li onclick="typeEmoticon()">😭</li>
                            <li onclick="typeEmoticon()">😐</li>
                            <li onclick="typeEmoticon()">😛</li>
                            <li onclick="typeEmoticon()">😡</li>
                            <li onclick="typeEmoticon()">😱</li>
                            <li onclick="typeEmoticon()">😯</li>
                            <li onclick="typeEmoticon()">🤐</li>
                            <li onclick="typeEmoticon()">🤩</li>
                            <li onclick="typeEmoticon()">🤭</li>
                        </ul>
                    </form>
                    <button type="submit" form="msg_form"><img src="images/catfoot_button.png" alt="Submit button"></button>
                </div>
            </div>
        </div>
    </main>

</body>
<script>
    // If submit event, if Online 



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
        } else {
            // If submit event, if Online 
            if (window.Notification && window.Notification !== 'denied') { 
            
                Notification.requestPermission(perm => {
                    if(perm === 'granted') {
                        const notification = new Notification('New message',{
                            body: 'You received a new message',
                            icon: images/catfoot_button.png,
                        });
                        console.log('acces a la condition2');
                    } else {
                        console.log('désolée2!');
                    }
                })
            } else {
            console.log('désolée encore plus!2');
            }

            console.log ('Ok pour submit online')
        }
    })

    // If app launched offline, change "online section" css.
    if (!navigator.onLine) {
        document.querySelector(".offline_msg").style.display = "flex";
        document.getElementById("online").style.display = "none";
        document.getElementById("disconnect").style.display = "none";
    }

    // If app turns offline, change "online section" css and notification.
    window.addEventListener('offline', (event) => {
        document.querySelector(".offline_msg").style.display = "flex";
        document.getElementById("online").style.display = "none";
        document.getElementById("disconnect").style.display = "none";

        // Notification of "offline mode"

        console.log('hello');

        if (window.Notification && window.Notification !== 'denied') { 
            
            Notification.requestPermission(perm => {
                if(perm === 'granted') {
                    const notification = new Notification('Deconnection',{
                        body: 'You are disconnected',
                        icon: images/catfoot_button.png,
                    });
                    console.log('acces a la condition1');
                } else {
                    console.log('désolée1!');
                }
            })
        } else {
           console.log('désolée encore plus!1');
        }

    });


    // When back online, sends the stored messages and notification and restore original CSS.
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

            // Notification about the number of new messages until the last connection

            if (window.Notification && window.Notification !== 'denied') {
                Notification.requestPermission(perm => {
                    if(perm === 'granted') {
                        const notification = new Notification('Waiting Messages',{
                            body: 'Your ' + msgArray.length + ' waiting messages have been published',
                            icon: images/catfoot_button.png,
                        });
                        console.log('acces a la condition');
                    } else {
                        console.log('désolée!');
                    }
                })
            } else {
                console.log('désolée encore plus!');
            }
            /*console.log(msgArray.length);
            console.log(notification);*/



            localStorage.removeItem("msgStorage");
        }

        window.location.reload();


    })

    //Notification
<<<<<<< HEAD
    console.log(Notification.permission);
   if(Notification.permission === 'default'){
       requestNotification();
=======
    if (Notification.permission === 'default') {
        requestNotification();
>>>>>>> cfc0f538d82402e90dad17b37c3190b5b9910b6e
    }
    if (Notification.permission === 'granted') {
        displayNotification();
    }
    if (Notification.permission === 'denied') {
        console.log('Pas de notification pour le user');
    }

    function requestNotification() {
        Notification.requestPermission().then(permission => {
            console.log(permission);
        })
    }

    function displayNotification() {
        let texte = "ma notification PWA";
        let param = {
            body: texte,
            icon: '🐱'
        };
        const notification = new Notification('My notif', param);
    }

//Notification Déconnecté
    function Deconnexion()
{
     window.alert("Vous avez bien été déconnecté !");
}
</script>


</html>