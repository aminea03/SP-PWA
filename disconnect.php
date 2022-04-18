<?php
session_start();
if (!isset($_SESSION["userId"])) {
    header("location: index.php");
} else {
    $db = new mysqli("mysql-tppwa.alwaysdata.net:3306", "tppwa", "988uiND/.p3nhOPD.", "tppwa_chatcha");
    $offlineQuery = $db->query("UPDATE users SET userStatus='0' WHERE userId='" . $_SESSION["userId"] . "'");
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();
    header("location: index.php");
}
