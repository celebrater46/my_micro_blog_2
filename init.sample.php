<?php

namespace my_micro_blog;

ini_set('display_errors', 1);

const MMB_TITLE = "My Micro Blog";
const MMB_AUTHOR = "Enin Fujimi";
const MMB_DESCRIPTION = "これは私のマイクロなブログ。";
const MMB_PATH = "/home/hoge-world/www/my_micro_blog_2/";
const MMB_IMG = MMB_PATH . "img/";
const MMB_PATH_HTTP = "http://hoge-world/";
const MMB_INDEX = MMB_PATH_HTTP . "index.php";
const MMB_IMG_HTTP = MMB_PATH_HTTP . "img/";
const MMB_FCM_PATH = "/home/hoge-world/www/fp_common_modules/";
const MMB_HCM_PATH = MMB_FCM_PATH . "html_common_module.php";
const MMB_MAX_ARTICLES_PER_PAGE = 2;
const MMB_FOLD = false;
const MMB_COMMENT = false;
const MMB_COMMENT_PERMIT = false;
const MMB_NEW_COMMENTS_ = 5;
const MMB_NEW_ARTICLES_ = 5;