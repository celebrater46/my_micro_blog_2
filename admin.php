<?php

namespace my_micro_blog;

use fp_common_modules as cm;

require_once "init.php";
require_once "main.php";
require_once MMB_HCM_PATH;

session_start();

$mmb_mode = isset($_GET["mmb_mode"]) ? (int)$_GET["mmb_mode"] : null;

if (isset($_SESSION['username'])) {
//    echo 'Welcome ' .  h($_SESSION['username']) . ".<br><br>";
//    echo "<a href='logout.php'>ログアウト</a>";
    echo get_admin_html($mmb_mode);
    exit;
} else {
    echo '404 Not Found.';
}

//function h($s){
//    return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
//}

function get_foot_html(){
    return <<<EOT
</body>
</html>
EOT;

}

function get_head_html(){
    return <<<EOT
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>My Micro Blog - My Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
EOT;
}

function get_category_select($num, $list){
    if($list !== null){
        $html = cm\space_br('<select class="mmb_category" name="category' . $num . '">', 3);
        foreach ($list as $line){
            $temp = explode("|", $line);
            $html .= cm\space_br('<option>' . $temp[0] . '</option>', 4);
        }
        $html .= cm\space_br('</select>', 3);
        return $html;
    } else {
        return "";
    }
}

function get_form_html($day){
    $html = cm\space_br('<h2>新規投稿</h2>', 2);
    $html .= cm\space_br('<form action="post.php" method="post">', 2);
    $html .= cm\space_br('<div class="mmb_form">', 3);
    $html .= cm\space_br('<label>', 4);
    $html .= cm\space_br('<span class="mmb_form">タイトル：</span>', 5);
    $html .= cm\space_br('</label><br>', 4);
    $html .= cm\space_br('<input class="mmb_subtitle" type="text" name="name" value="">', 5);
    $html .= cm\space_br('</div>', 3);
    $html .= cm\space_br('<div class="mmb_form">', 3);
    $html .= cm\space_br('<label>', 4);
    $html .= cm\space_br('<span class="mmb_form">本文：</span>', 5);
    $html .= cm\space_br('</label><br>', 4);
    $html .= cm\space_br('<textarea class="mmb_body" name="text"></textarea>', 5);
    $html .= cm\space_br('</div>', 3);
    $html .= cm\space_br('<br>', 3);
    $html .= cm\space_br('<div class="mmb_form flex">', 3);
    $html .= cm\space_br('<label>', 4);
    $html .= cm\space_br('<span class="mmb_form">日時：</span>', 5);
    $html .= cm\space_br('</label><br>', 4);
    $html .= cm\space_br('<input class="mmb_date" type="text" name="year" value="' . date('Y/m/d_H:i:s') . '">', 4);
//    $html .= cm\space_br('<input class="mmb_year" type="text" name="year" value="">年', 4);
//    $html .= cm\space_br('<input class="mmb_month" type="text" name="month" value="">月', 4);
//    $html .= cm\space_br('<input class="mmb_day" type="text" name="day" value="">日', 4);
//    $html .= cm\space_br('<input class="mmb_hour" type="text" name="hour" value="">時', 4);
//    $html .= cm\space_br('<input class="mmb_minute" type="text" name="minute" value="">分', 4);
//    $html .= cm\space_br('<input class="mmb_second" type="text" name="second" value="">秒', 4);
    $list = get_categories_list();
    $html .= get_category_select(1, $list);
    $html .= get_category_select(2, $list);
    $html .= cm\space_br('</div>', 3);
    $html .= cm\space_br('<p>※未入力なら現在時刻</p>', 3);
    $html .= cm\space_br('</form>', 2);
    return $html;
}

function get_article_list_html(){
    $list = get_articles_list();
    rsort($list);
    if($list !== null){
        $i = count($list);
        $html = "";
        foreach ($list as $line){
            $temp = explode("|", $line);
//            0|5|20220104|ブログのテストでーす|2022-01-04_09:33:33|0
            $html .= cm\space_br("<p>" . $i . "　｜　" . $temp[3] . "　｜　" . $temp[4] . "</p>", 2);
            $i--;
        }
        return $html;
    } else {
        return "";
    }
}

function get_admin_html($mode){
    $html = get_head_html();
    $html .= cm\space_br('<div class="admin container">', 1);
    $html .= cm\space_br('<h1>My Micro Blog - My Page</h1>', 2);
    if($mode === null){
        $html .= get_form_html(null);
    } else {
        $html .= get_article_list_html();
    }
    $html .= cm\space_br('<br><br><br>', 2);
    $html .= cm\space_br("<a href='logout.php'>ログアウト</a>", 2);
    $html .= cm\space_br('</div>', 1);
    $html .= get_foot_html();
    return $html;
}