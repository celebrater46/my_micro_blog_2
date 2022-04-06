<?php

// Copyright (C) Enin Fujimi All Rights Reserved.

namespace my_micro_blog;

require_once "init.php";
require_once "mmb_get_html.php";

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="Author" content="<?php echo MMB_AUTHOR; ?>">
    <title><?php echo MMB_TITLE; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <?php echo MMB_COMMENT ? '<link rel="stylesheet" href="' . MMB_PHBBS_HTML_PATH . 'css/style.css">' : ""; ?>
</head>
<body>
<div class="container">
<?php echo mmb_get_html(); ?>
</div>
</body>
</html>