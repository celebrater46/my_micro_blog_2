<?php

// Copyright (C) Enin Fujimi All Rights Reserved.

require_once "Article.php";
require_once "Category.php";

$list = file("list.txt"); // 220101|これはタイトルです|カテゴリ1|カテゴリ2, 220103|テストタイトルです|カテゴリ3|カテゴリ2...
$articles = [];
$category_array = get_category_array($list);
$categories = [];

foreach ($category_array as $name) {
    array_push($categories, new Category($name, $list));
}

foreach ($list as $line){
    array_push($articles, new Article($line));
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

        <?php var_dump($categories); ?>
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
</body>
</html>