<?php

function h($s){
    return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}

session_start();

if (isset($_SESSION['email'])) {
    echo 'Welcome ' .  h($_SESSION['username']) . ".<br><br>";
    echo "Please click <a href='logout.php'>here</a> to logout.";
    exit;
}