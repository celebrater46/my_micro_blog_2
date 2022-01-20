<?php

// Copyright (C) Enin Fujimi All Rights Reserved.

require_once "Article.php";
require_once "Category.php";
require_once "Month.php";

$list = file("list.txt"); // 220101|これはタイトルです|カテゴリ1|カテゴリ2, 220103|テストタイトルです|カテゴリ3|カテゴリ2...
$articles = [];

$category_array = get_category_array($list);
$month_array = get_month_array($list);

$categories = [];
$months = [];

$category_id = "";
$month_id = "";

if(isset($_GET["category"])){
    $category_id = $_GET["category"];
}

if(isset($_GET["month"])){
    $month_id = $_GET["month"];
}

$i = 0;
foreach ($category_array as $name) {
    array_push($categories, new Category($i, $name, $list));
    $i++;
}

$j = 0;
foreach ($month_array as $month) {
    array_push($months, new Month($j, $month, $list));
}

foreach ($list as $line){
    array_push($articles, new Article($line));
}

function get_month_array($list){
    $array = [];
    foreach ($list as $line){
        $temp = explode("|", $line);
        $temp2 = substr($temp[0], 0, 6); // 202102
        array_push($array, (int)$temp2);
    }
    return array_unique($array);
}

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

        <div class="flex">
            <div class="main">
                <?php if ($category_id !== "") : ?>
                    <h2><?php echo $categories[$category_id]->name; ?></h2>
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
                    <h2>アーカイブ</h2>
                    <ul>
                        <?php foreach ($months as $month) : ?>
                            <li>
                                <a href="index.php?category=<?php echo $month->month; ?>">
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