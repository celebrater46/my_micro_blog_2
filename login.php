<?php

namespace my_micro_blog;

require_once "admin_init.php";

session_start();

$err_msg = [
    "username" => "",
    "password" => ""
];

if (!empty($_POST)) {
    $user_name = $_POST['username'];
    $user_password = $_POST['password'];

    if ($user_name === '') {
        $err_msg['username'] = 'ユーザー名を入力してください。Please input your name.';
    }
    if (strlen($user_name) > 255) {
        $err_msg['username'] = 'ユーザー名は 255 文字以下で入力してください。Please input your name within 255 chars.';
    }
    if ($user_password === '') {
        $err_msg['password'] = 'パスワードを入力してください。Please input your password.';
    }
    if (strlen($user_password) > 255 || strlen($user_password) < 5) {
        $err_msg['password'] = 'パスワードは 6 文字以上 255 文字以下で入力してください。Please input your password 6 to 255 chars.';
    }
    if (!preg_match("/^[a-zA-Z0-9]+$/", $user_password)) {
        $err_msg['password'] = 'パスワードは半角英数字で入力してください。Please input your password in alphanumerical.';
    }

    if($err_msg["username"] === "" && $err_msg["password"] === ""){
        if(MMB_ADMIN === $user_name && MMB_ADMIN_PASSWORD === $user_password){
            $_SESSION['username'] = $user_name;
            header('Location: mypage.php');
            exit;
        }else{
            $err_msg['username'] = 'ユーザー名かパスワードが間違っています。Either the name or password is incorrect.';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理用ページ - For Administrate</title>
</head>
<body>
<h1>管理用ページ - For Administrate</h1>
<form action="" method="post">
    <div class="err_msg"><?php echo $err_msg['username']; ?></div>
    <label for="">
        <span>ユーザー名 - Username</span>
        <input type="text" name="username" id=""><br>
    </label>
    <div class="err_msg"><?php echo $err_msg['password']; ?></div>
    <label for=""><span>パスワード - Password</span>
        <input type="password" name="password" id=""><br>
    </label>
    <input type="submit" value="送信 - Submit">
</form>
</body>
</html>