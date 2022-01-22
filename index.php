<?php

// Copyright (C) Enin Fujimi All Rights Reserved.

require_once "Article.php";
require_once "Category.php";
require_once "Month.php";

$setting = get_setting(); // "5", "false", "false" ...
$list = get_list(); // 220101|これはタイトルです|カテゴリ1|カテゴリ2, 220103|テストタイトルです|カテゴリ3|カテゴリ2...
$articles = [];

var_dump($list);

$category_array = get_category_array($list); // category1, category2 ...
$month_array = get_month_array($list); // 202102, 202103 ...

$list_per_page = get_list_per_page($list, (int)$setting[0]); // max:

$categories = [];
$months = [];

$category_id = isset($_GET["category"]) ? (int)$_GET["category"] : null;
$month_id = isset($_GET["month"]) ? (int)$_GET["month"] : null;;

//if(isset($_GET["category"])){
//    $category_id = $_GET["category"];
//}
//
//if(isset($_GET["month"])){
//    $month_id = $_GET["month"];
//}

$i = 0;
foreach ($category_array as $name) {
    array_push($categories, new Category($i, $name, $list));
    $i++;
}

$j = 0;
foreach ($month_array as $month) {
    array_push($months, new Month($j, $month, $list));
    $j++;
}

foreach ($list_per_page as $line){
    array_push($articles, new Article($line));
}

// "5", "false", "false" ...
function get_setting(){
    if(file_exists("setting.txt")){
        /*
            max:5
            fold:false
            comment:false
            comment_permit:false
            new_comments:5
            new_articles:5
        */
        $list = file("setting.txt");
        $list = str_replace([
            "max:",
            "fold:",
            "comment:",
            "comment_permit:",
            "new_comments:",
            "new_articles:",
            " ",
            "\n",
            "\r",
            "\r\n"
        ], "", $list);
        return $list;
    } else {
        return null;
    }
}

function get_list(){
    if(file_exists("list.txt")){
        return file("list.txt");
    } else {
        return ["ERROR: list.txt が存在しないか、読み込めません。"];
    }
}

function get_list_per_page($list, $max){
    $temp_array = [];
    if((int)$max > 0){
        for($i = 0; $i < $max; $i++){
            array_push($temp_array, $list[$i]);
        }
        return $temp_array;
    } else {
        return $list;
    }
}

// 202101, 202102 ...
function get_month_array($list){
    $array = [];
    foreach ($list as $line){
        $temp = explode("|", $line);
        $temp2 = substr($temp[0], 0, 6); // 202102
        array_push($array, (int)$temp2);
    }
    return array_unique($array);
}

// category1, category2 ...
function get_category_array($list)
{
    $array = [];
    foreach ($list as $line) {
        $temp = explode("|", $line);
        if (isset($temp[2])) {
            array_push($array, $temp[2]);
        }
        if (isset($temp[3])) {
            array_push($array, $temp[3]);
        }
    }
    return array_unique($array);
}

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="Author" content="Enin Fujimi - 富士見永人">
    <title>My Micro Blog</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>
            <a href="/">
                My Micro Blog
            </a>
        </h1>
        <div class="description">私のマイクロなブログです。</div>
        <p><?php var_dump($categories); ?></p>

        <div class="flex">
            <div class="main">

                <?php if ($category_id !== null) : ?>
                    <h2><?php echo $categories[$category_id]->name; ?></h2>
                <?php elseif ($month_id !== null) : ?>
                    <h2><?php echo $months[$month_id]->month_string; ?></h2>
                <?php endif; ?>

                <?php foreach ($articles as $article) : ?>
                    <div class="article">
                        <hr>
                        <div class="date">
                            <?php echo $article->date_string; ?>　｜　<?php echo $article->category1; ?>　｜　<?php echo $article->category2; ?>
                        </div>
                        <h2><?php echo $article->title; ?></h2>
                        <div class="text">
                            <?php foreach ($article->text as $line) : ?>
                                <p><?php echo $line ?></p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="side">
                <div>
                    <h2>カテゴリ</h2>
                    <ul>
                        <?php foreach ($categories as $category) : ?>
                            <li>
                                <a href="index.php?category=<?php echo $category->id; ?>">
                                    <?php echo $category->name; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div>
                    <hr>
                    <h2>アーカイブ</h2>
                    <ul>
                        <?php foreach ($months as $month) : ?>
                            <li>
                                <a href="index.php?month=<?php echo $month->id; ?>">
                                    <?php echo $month->month_string; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</body>
</html>