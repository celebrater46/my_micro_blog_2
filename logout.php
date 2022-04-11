<?php

session_start();

$output = '';

if (isset($_SESSION["username"])) {
    $output = 'Logged out.';
} else {
    $output = 'The session has timed out.';
}

$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

@session_destroy();

echo $output . "<br><br><a href='index.php'>BACK</a>";