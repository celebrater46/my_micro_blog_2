<?php

// Copyright (C) Enin Fujimi All Rights Reserved.

namespace my_micro_blog;

require_once "init.php";
require_once "mmb_get_html.php";

//$setting = get_setting(); // "5", "false", "false" ...
//$list = get_list(); // 220101|これはタイトルです|カテゴリ1|カテゴリ2, 220103|テストタイトルです|カテゴリ3|カテゴリ2...
//$articles = get_articles($list);

//var_dump($list);

//$category_array = get_category_array($list); // category1, category2 ...

//$list_per_page = get_list_per_page($list, (int)$setting[0]); // max:


//$categories = get_categories($list);
//$months = get_months($list);

//$category_id = isset($_GET["category"]) ? (int)$_GET["category"] : null;
//$month_id = isset($_GET["month"]) ? (int)$_GET["month"] : null;;


// "5", "false", "false" ...


?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="Author" content="<?php echo MMB_AUTHOR; ?>">
    <title><?php echo MMB_TITLE; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
<?php echo mmb_get_html(); ?>
</div>
</body>
</html>