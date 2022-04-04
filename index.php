<?php

// Copyright (C) Enin Fujimi All Rights Reserved.

namespace my_micro_blog;

use my_micro_blog\classes\Article;
use my_micro_blog\classes\Category;
use my_micro_blog\classes\Month;

require_once "init.php";
require_once "main.php";
require_once "classes/Article.php";
require_once "classes/Category.php";
require_once "classes/Month.php";

//$setting = get_setting(); // "5", "false", "false" ...
$list = get_list(); // 220101|これはタイトルです|カテゴリ1|カテゴリ2, 220103|テストタイトルです|カテゴリ3|カテゴリ2...
$articles = get_articles($list);

var_dump($list);

//$category_array = get_category_array($list); // category1, category2 ...

//$list_per_page = get_list_per_page($list, (int)$setting[0]); // max:


$categories = get_categories($list);
$months = get_months($list);

$category_id = isset($_GET["category"]) ? (int)$_GET["category"] : null;
$month_id = isset($_GET["month"]) ? (int)$_GET["month"] : null;;


// "5", "false", "false" ...


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