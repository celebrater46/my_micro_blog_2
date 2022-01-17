<?php

$test_url = "test";

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
    <h1>
        <a href="/?t=<?php echo h($test_url); ?>">
            Hello World!
        </a>
    </h1>

</body>
</html>