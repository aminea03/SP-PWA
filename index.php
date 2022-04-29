<?php

// DISPLAY ALL ERRORS
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (isset($_POST["login"]) && isset($_POST["password"])) {
    $db = new mysqli("mysql-tppwa.alwaysdata.net:3306", "tppwa", "988uiND/.p3nhOPD.", "tppwa_chatcha");
    $_SESSION["login"] = $db->real_escape_string($_POST["login"]);
    $connectionQuery = $db->query("SELECT * FROM users WHERE userLogin='" . $_SESSION["login"] . "'");
    if ($connectionQuery->num_rows) {
        while ($row = $connectionQuery->fetch_object()) {
            $connection[] = $row;
        }
        if (password_verify($_POST["password"], $connection[0]->userPassword) == true) {
            $_SESSION["userId"] = $connection[0]->userId;
            $_SESSION["userCount"] = $connection[0]->userCount;
            $db->query("UPDATE users SET userStatus='1', userDate=NOW() WHERE userId='" . $_SESSION["userId"] . "'");
            header("location: meowroom.php");
        } else {
            echo '<script>var connectionAttempt=1; alert("Unknown login or password")</script>';
            session_destroy();
        }
    } else {
        echo '<script>var connectionAttempt=1; alert("Unknown login or password")</script>';
        session_destroy();
    }
}

if (isset($_POST["login_creation"]) && isset($_POST["password_creation"]) && isset($_POST["type"])) {
    $db = new mysqli("mysql-tppwa.alwaysdata.net:3306", "tppwa", "988uiND/.p3nhOPD.", "tppwa_chatcha");
    $registerQuery = $db->query("SELECT userLogin FROM users WHERE userLogin='" . $_POST["login_creation"] . "'");
    if ($registerQuery->num_rows) {
        echo '<script>alert("Login not available, choose another one.")</script>';
    } else {
        $password = password_hash($_POST["password_creation"], PASSWORD_DEFAULT);
        $registration = $db->query("INSERT INTO users VALUES (NULL,'" . $_POST["login_creation"] . "','$password',0,'" . $_POST["type"] . "','0',NOW())");
        header("location:index.php");
    }
}


?>

<!DOCTYPE html>
<html lang="en" translate="no">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Page de connexion à la messagerie instantanée du site chatcha">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="chatcha.css">
    <link rel="manifest" href="manifest.json">
    <script src="chatcha.js"></script>
    <link rel="icon" href="images/icon192.png">
    <link rel="apple-touch-icon" href="/images/icon192.png">
    <meta name="apple-mobile-web-app-status-bar" content="#00B3AF">
    <meta name="theme-color" content="#00B3AF">

    <title>Chatcha : connection</title>
</head>

<body>
    <div class="index_top">
        <img src="images/logo_chatcha.png" alt="logo tête de chat">
    </div>
    <section class="connexion">
        <div class="index_bottom">
            <h2>CONNECTION</h2>
            <div class="index_bottom_form_wrapper">
                <div class="index_bottom_div1">
                    <label for="login">LOGIN</label>
                    <label for="password">PASSWORD</label>
                </div>
                <div class="index_bottom_div2">
                    <form action="" method="POST" id="login_form">
                        <input type="text" id="login" name="login" placeholder="Login">
                        <input type="password" id="password" name="password" placeholder="Password">
                    </form>
                </div>
                <button type="submit" form="login_form" value="Connexion" name="binfo" onClick="Connexion()"><img src="images/catfoot_button.png" alt="patte de chat"></button>
            </div>
            <p class="index_link" onclick="register()">New ? Create a chatccount.</p>
        </div>
    </section>
    <section class="create_account">
        <div class="index_bottom">
            <h2>REGISTER NOW</h2>
            <div>
                <p>What type of cat are you ?</p>
                <form action="" method="POST" id="create_form">
                    <div class="cat_type">
                        <label><input type="radio" name="type" value="Boredcat" required>Bored Cat<img src="images/boredcat.png" alt="boredcat"></label>
                        <label><input type="radio" name="type" value="Businesscat">Business Cat<img src="images/businesscat.png" alt="businesscat"></label>
                        <label><input type="radio" name="type" value="Extracleancat">Extraclean Cat<img src="images/extracleancat.png" alt="extracleancat"></label>
                        <label><input type="radio" name="type" value="Funnycat">Funny Cat<img src="images/funnycat.png" alt="funnycat"></label>
                        <label><input type="radio" name="type" value="Hackercat">Hacker Cat<img src="images/hackercat.png" alt="hackercat"></label>
                        <label><input type="radio" name="type" value="Lazycat">Lazy Cat<img src="images/lazycat.png" alt="lazycat"></label>
                        <label><input type="radio" name="type" value="Stealthcat">Stealth Cat<img src="images/stealthcat.png" alt="stealthcat"></label>
                        <label><input type="radio" name="type" value="Supercat">Super Cat<img src="images/supercat.png" alt="supercat"></label>
                        <label><input type="radio" name="type" value="Unicorncat">Unicorn Cat<img src="images/unicorncat.png" alt="unicorncat"></label>
                    </div>
                    <div class="cat_info">
                        <label>LOGIN (max 20 char.)<input type="text" name="login_creation" id="login_creation"></label>
                        <label>PASSWORD<input type="password" name="password_creation" id="password_creation"></label>
                    </div>
                    <button type="submit"><img src="images/catfoot_button.png" alt="patte de chat"></button>
                </form>
                <p class="link_connection" onclick="backToConnection()">Back to connection</p>
            </div>
        </div>
    </section>
    <!-- Loading animation -->
    <div class="lds_wrapper">
        <div class="lds-ring">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
        <p>Connecting</p>
    </div>


</body>
<script>
    //Username and passord storage
    if (window.localStorage) {
        document.addEventListener("submit", function() {
            window.localStorage.setItem("username", document.getElementById("login").value);
            window.localStorage.setItem("password", document.getElementById("password").value);
            document.querySelector(".lds_wrapper").style.display = "flex";
            if (document.getElementById("login_creation").value != "" && document.getElementById("password_creation").value != "") {
                window.localStorage.setItem("username", document.getElementById("login_creation").value);
                window.localStorage.setItem("password", document.getElementById("password_creation").value);
            }
        })
    }

    //Auto login
    if (localStorage.getItem("username") && localStorage.getItem("password")) {
        document.getElementById("login").value = localStorage.getItem("username");
        document.getElementById("password").value = localStorage.getItem("password");
        // var connectionAttempt is defined only if connection has been aborted due to false login/password.
        if (typeof connectionAttempt === "undefined") {
            if (document.referrer != "https://tppwa.alwaysdata.net/meowroom.php" && document.referrer != "https://tppwa.alwaysdata.net/disconnect.php") {
                document.querySelector(".lds_wrapper").style.display = "flex";
                document.getElementById("login_form").submit();
            }
        }
    }
<<<<<<< HEAD


=======
>>>>>>> e2e9d25d657f2e9e7e9c6ce9cc17a07beffe837c
</script>

</html>