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
            $db->query("UPDATE users SET userStatus='1' WHERE userId='" . $_SESSION["userId"] . "'");
            header("location: meowroom.php");
        } else {
            echo '<script>alert("Unknown login or password")</script>';
            session_destroy();
        }
    } else {
        echo '<script>alert("Unknown login or password")</script>';
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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="chatcha.css">
    <link rel="manifest" href="manifest.json">
    <script src="chatcha.js"></script>
    <script src="sw.js"></script>
    <link rel="icon" href="images/icon192.png">
    <link rel="apple-touch-icon" href="/images/icon192.png">
    <meta name="apple-mobile-web-app-status-bar" content="#695312">
    <meta name="theme-color" content="#695312">
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
                        <input type="text" id="login" name="login">
                        <input type="password" id="password" name="password">
                    </form>

                </div>
                <button type="submit" form="login_form"><img src="images/catfoot_button.png" alt="patte de chat"></button>
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
                        <label>LOGIN (max 20 char.)<input type="text" name="login_creation"></label>
                        <label>PASSWORD<input type="password" name="password_creation"></label>
                    </div>
                    <button type="submit"><img src="images/catfoot_button.png" alt="patte de chat"></button>
                </form>
                <p class="link_connection" onclick="backToConnection()">Back to connection</p>
            </div>
        </div>
    </section>


</body>

</html>