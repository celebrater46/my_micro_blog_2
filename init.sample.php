<?php

namespace my_micro_blog;

ini_set('display_errors', 1);

const MMB_TITLE = "My Micro Blog";
const MMB_AUTHOR = "Enin Fujimi";
const MMB_DESCRIPTION = "これは私のマイクロなブログ。";
const MMB_MAX_ARTICLES_PER_PAGE = 2; // 1回の表示で記事を最大いくつまで表示するか
const MMB_COMMENT = true; // コメント機能を使用するかどうか（使用するなら PHP HP BBS の設置が必要）
const MMB_NEW_COMMENTS = 5; // サイドカラムに新着コメントをいくつまで表示するか
const MMB_NEW_ARTICLES = 5; // サイドカラムに新着記事をいくつまで表示するか
const MMB_PHBBS_THREAD_INIT = "mmb_"; // コメント機能を使用する場合の、PHP HP BBS のスレッド名の頭文字（後に「20220401」などと 8 桁の日付を元にした ID が付与される）

const MMB_PATH = "/home/hoge-world/www/my_micro_blog_2/"; // プロジェクトフォルダのパス
const MMB_PATH_HTTP = "https://hoge-world.jp/my_micro_blog_2/"; // プロジェクトフォルダの HTTP パス
const MMB_INDEX = MMB_PATH_HTTP . "index.php"; // index.php のある HTTP パス（外部サイトに埋め込む場合、ここを変更）
const MMB_IMG = MMB_PATH . "img/"; // 画像フォルダのパス
const MMB_IMG_HTTP = MMB_PATH_HTTP . "img/"; // 画像フォルダの HTTP パス
const MMB_FCM_PATH = "/home/hoge-world/www/fp_common_modules/"; // fp_common_modules のパス
const MMB_HCM_PATH = MMB_FCM_PATH . "html_common_module.php"; // html_common_module.php のパス（fp_common_modules に付属）
const MMB_PNLG_PATH = MMB_FCM_PATH . "php_number_link_generator_2/"; // php_number_link_generator のパス（fp_common_modules に付属）
const MMB_PHBBS_PATH = "/home/hoge-world/www/php_hp_bbs_2/"; // PHP HP BBS のパス
const MMB_PHBBS_HTML_PATH = "https://hoge-world.jp/php_hp_bbs_2/"; // PHP HP BBS の HTML パス