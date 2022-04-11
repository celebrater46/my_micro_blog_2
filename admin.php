<?php

namespace my_micro_blog;

use fp_common_modules as cm;
use my_micro_blog\classes\AdminState;
use my_micro_blog\classes\Article;
use my_micro_blog\classes\PostArticle;

require_once "init.php";
require_once "main.php";
require_once "classes/AdminState.php";
require_once "classes/PostArticle.php";
require_once "classes/Article.php";
require_once MMB_HCM_PATH;

session_start();

$state = new AdminState();

if (isset($_SESSION['username'])) {
    switch ($state->mmb_post){
        case 1:
            post_article();
            break;
        case 2:
            edit_article($state);
            break;
        case 3:
            delete_article($state);
            break;
        case 4:
            delete_comment($state);
            break;
        default:
            echo get_admin_html($state);
            exit;
    }
} else {
    echo '404 Not Found.';
}

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

function get_category_select($num, $list, $selected){
    if($list !== null){
        $html = cm\space_br('<select class="mmb_category" name="category' . $num . '">', 3);
        foreach ($list as $line){
            $temp = explode("|", $line);
            $html .= cm\space_br('<option' . ($temp[0] === $selected ? ' selected' : '') . '>' . $temp[0] . '</option>', 4);
        }
        $html .= cm\space_br('</select>', 3);
        return $html;
    } else {
        return "";
    }
}

function get_article_obj($state){
    if($state->mmb_day !== null) {
        $path = MMB_PATH . "articles/" . $state->mmb_day . ".txt";
        if(file_exists($path)){
            $list = get_articles_list();
            $extracted = extract_articles_list($list, $state, null);
            $article = new Article();
            $article->init($extracted[0]);
            return $article;
        } else {
            echo "Not Found: " . $path . "<br><br>";
            echo "<a href='admin.php'>戻る</a>";
            exit;
        }
    } else {
        return null;
    }
}

function get_form_html($state){
    $article = get_article_obj($state);
    if($article !== null){
        $article->get_lines();
    }
    $subtitle = $article === null ? "" : $article->title;
    $date = $article === null ? date('Y-m-d_H:i:s') : $article->date_string2;
    $body = implode("\n", $article->lines);
    $body = str_replace("\n　\n", "\n", $body);
    $html = cm\space_br('<h2>新規投稿</h2>', 2);
    $html .= cm\space_br('<form action="admin.php?mmb_post=' . $state->mmb_mode . ($state->mmb_day !== null ? "&mmb_day=" . $state->mmb_day : "") . '" method="post">', 2);
    $html .= cm\space_br('<div class="mmb_form">', 3);
    $html .= cm\space_br('<label>', 4);
    $html .= cm\space_br('<span class="mmb_form">タイトル：</span>', 5);
    $html .= cm\space_br('</label><br>', 4);
    $html .= cm\space_br('<input class="mmb_subtitle" type="text" name="subtitle" value="' . $subtitle . '">', 5);
    $html .= cm\space_br('</div>', 3);
    $html .= cm\space_br('<div class="mmb_form">', 3);
    $html .= cm\space_br('<label>', 4);
    $html .= cm\space_br('<span class="mmb_form">本文：</span>', 5);
    $html .= cm\space_br('</label><br>', 4);
    $html .= cm\space_br('<textarea class="mmb_body" name="body">' . $body . '</textarea>', 5);
    $html .= cm\space_br('</div>', 3);
    $html .= cm\space_br('<div class="mmb_form flex">', 3);
    $html .= cm\space_br('<label>', 4);
    $html .= cm\space_br('<span class="mmb_form">日時：</span>', 5);
    $html .= cm\space_br('</label><br>', 4);
    $html .= cm\space_br('<input class="mmb_date" type="text" name="date2" value="' . $date . '">', 4);
    $list = get_categories_list();
    $html .= get_category_select(1, $list, $article->category1);
    $html .= get_category_select(2, $list, $article->category2);
    $html .= cm\space_br('</div>', 3);
    $html .= cm\space_br('<p>※自国記入例：2022-04-01_02:02:03（未入力なら現在時刻）</p>', 3);
    $html .= cm\space_br('<input type="submit" value="投稿する">', 3);
    $html .= cm\space_br('</form>', 2);
    $html .= cm\space_br('<br>', 2);
    $html .= cm\space_br("<a href='admin.php'>一覧へ戻る</a>", 2);
    return $html;
}

function get_article_list_html(){
    $list = get_articles_list();
    if($list !== null){
        $i = 1;
        $html = "";
        foreach ($list as $line){
            $temp = explode("|", $line);
            $title = strlen($temp[3] >= 10) ? mb_substr($temp[3], 0, 9) . '…' : $temp[3];
            // 0|5|20220104|ブログのテストでーす|2022-01-04_09:33:33|0
            $html .= cm\space_br("<p>" . $i . "　｜　", 2);
            $html .= cm\space_br('<a href="admin.php?mmb_mode=2&mmb_day=' . $temp[2] . '" title="' . $title . '">' . $title . '</a>　｜　', 3);
            $html .= cm\space_br($temp[4] . "　｜　", 3);
            $html .= cm\space_br('<a href="admin.php?mmb_mode=4&mmb_day=' . $temp[2] . '">[削除]</a>', 3);
            $html .= cm\space_br("</p>", 2);
            $i++;
        }
        $html .= cm\space_br('<br><br><p><a href="admin.php">パネルトップへ戻る</a>', 2);
        return $html;
    } else {
        return "";
    }
}

function get_edit_articles_html($state){
    if($state->mmb_day === null){
        return get_article_list_html();
    } else {
        return get_form_html($state);
    }
}

function get_menu_html(){
    $html = cm\space_br('<h2>コントロールパネル</h2>', 2);
    $html .= cm\space_br('<h3 class="mmb_control"><a href="admin.php?mmb_mode=1">新規投稿</a></h3>', 2);
    $html .= cm\space_br('<h3 class="mmb_control"><a href="admin.php?mmb_mode=2">記事一覧</a></h3>', 2);
    $html .= cm\space_br('<h3 class="mmb_control"><a href="admin.php?mmb_mode=3">コメント管理</a></h3>', 2);
    $html .= cm\space_br('<br><br><p><a href="' . MMB_INDEX . '">ブログトップへ戻る</a>', 2);
    return $html;
}

function get_article_delete_confirmation($state){
    $html = cm\space_br('<h2>記事の削除</h2>', 2);
    $html .= cm\space_br('<p>ID: ' . $state->mmb_day . ' の記事を削除します。</p>', 2);
    $html .= cm\space_br('<p>削除された記事は復元できません。よろしいですか？</p><br><br>', 2);
    $html .= cm\space_br('<p><a href="admin.php?mmb_post=3&mmb_day=' . $state->mmb_day . '">[削除する]</a>　｜　', 2);
    $html .= cm\space_br('<a href="admin.php?mmb_mode=2">[削除せず一覧へ戻る]</a></p>', 2);
    return $html;
}

function get_contributor($state){
    $index_path = MMB_PHBBS_PATH . "bbs/lists/" . MMB_PHBBS_THREAD_INIT . $state->mmb_day . ".log";
    if(file_exists($index_path)){
        $index_list = file($index_path);
//        var_dump($index_list);
        foreach ($index_list as $line){
            $exploded = explode("<>", $line);
            if((int)$exploded[0] === $state->mmb_comment){
                return $exploded[4];
            }
        }
        echo "コメントリストを検索しましたが、ID: " . $state->mmb_day . "_" . $state->mmb_comment . " の情報が見つかりませんでした。" . "<br>";
        return "不明";
    } else {
        echo $index_path . " の読み込みに失敗しました。" . "<br>";
        return "不明";
    }
}

function get_comment_delete_confirmation($state){
    $path = MMB_PHBBS_PATH . "bbs/comments/" . MMB_PHBBS_THREAD_INIT . $state->mmb_day . "/" . $state->mmb_comment . ".txt";
    if(file_exists($path)){
        $lines = file($path);
        $contributor = get_contributor($state);
        $html = cm\space_br('<h2>コメントの削除</h2>', 2);
        $html .= cm\space_br('<hr>', 2);
        $html .= cm\space_br('<p>投稿者： ' . $contributor . '</p>', 2);
        $html .= cm\space_br('<hr>', 2);
        foreach ($lines as $line){
            $html .= cm\space_br('<p>' . $line . '</p>', 2);
        }
        $html .= cm\space_br('<hr>', 2);
        $html .= cm\space_br('<p>上記 ID: ' . $state->mmb_day . "_" . $state->mmb_comment . ' のコメントを削除します。</p>', 2);
        $html .= cm\space_br('<p>削除されたコメントは復元できません。よろしいですか？</p><br><br>', 2);
        $html .= cm\space_br('<p><a href="admin.php?mmb_post=4&mmb_day=' . $state->mmb_day . '&mmb_comment=' . $state->mmb_comment . '">[削除する]</a>　｜　', 2);
        $html .= cm\space_br('<a href="admin.php?mmb_mode=3">[削除せず一覧へ戻る]</a></p>', 2);
    } else {
        echo $path . " が見つからないか、読み込めません。" . "<br><br>";
        echo '<a href="admin.php?mmb_mode=3">[削除せず一覧へ戻る]</a>';
        exit;
    }
    return $html;
}

function get_delete_comments_html(){
    $html = cm\space_br('<h2>コメント管理</h2>', 2);
    $list = get_comments_list();
    foreach ($list as $line){
        $exploded = explode("<>", $line);
//        echo $line . "<br>";
        if($exploded[11] !== "__DELETED__"){
            $html .= cm\space_br("<p>", 2);
            $html .= cm\space_br("記事ID:" . $exploded[13] . "_" . $exploded[0] . " | " . $exploded[4], 3);
            $html .= cm\space_br('<a href="admin.php?mmb_mode=5&mmb_day=' . $exploded[13] . '&mmb_comment=' . $exploded[0] . '">　[削除する]</a>', 3);
            $html .= cm\space_br("</p>", 2);
        }
    }
    $html .= cm\space_br("<br><br><a href='admin.php'>一覧へ戻る</a>", 2);
    return $html;
}

function get_admin_html($state){
    $html = get_head_html();
    $html .= cm\space_br('<div class="admin container">', 1);
    $html .= cm\space_br('<h1>My Micro Blog - My Page</h1>', 2);
    // mmb_mode_11 === a posted comment page
    switch($state->mmb_mode){
        case 1: $html .= get_form_html(null); break;
        case 2: $html .= get_edit_articles_html($state); break;
        case 3: $html .= get_delete_comments_html(); break;
        case 4: $html .= get_article_delete_confirmation($state); break;
        case 5: $html .= get_comment_delete_confirmation($state); break;
        default: $html .= get_menu_html(); break;
    }
    $html .= cm\space_br('<br><br><br>', 2);
    $html .= cm\space_br("<a href='logout.php'>ログアウト</a>", 2);
    $html .= cm\space_br('</div>', 1);
    $html .= get_foot_html();
    return $html;
}

function post_article(){
    $pa = new PostArticle();
    $pa->post_init();
    $pa->update_article_list();
    $pa->save_body();
    echo '<br><br><a href="admin.php">戻る</a>';
}

function edit_article($state){
    delete_article_core($state);
    post_article();
}

function delete_article_core($state){
    $list = get_articles_list();
    $article_txt =  MMB_PATH . "lists/articles.txt";
    $article = MMB_PATH . "articles/" . $state->mmb_day . ".txt";
    $index_result = unlink($article_txt);
    $txt_result = unlink($article);
    echo $article_txt . ($index_result ? ' の削除に成功しました。' . '<br>' : ' の削除に失敗しました。' . '<br>');
    echo $article . ($txt_result ? ' の削除に成功しました。' . '<br>' : ' の削除に失敗しました。' . '<br>');
    foreach ($list as $line){
        $temp = explode("|", $line);
        if((int)$temp[2] === $state->mmb_day){
            continue;
        } else {
            error_log($line, 3, $article_txt);
            echo '[' . $line . '] を ' . $article_txt . 'に追加しました。' . '<br>';
        }
    }
}

function delete_article($state){
    delete_article_core($state);
    echo '<br><br><a href="admin.php">戻る</a>';
}

function delete_comment($state){
    $comment_path = MMB_PHBBS_PATH . 'bbs/comments/' . MMB_PHBBS_THREAD_INIT . $state->mmb_day . "/" . $state->mmb_comment . ".txt";
    if(file_exists($comment_path)){
        $deleted_comment = unlink($comment_path);
        echo $comment_path . ($deleted_comment ? " の削除に成功しました。" : " の削除に失敗しました。") . "<br>";
        error_log("-- 削除されました --", 3, $comment_path);
    } else {
        echo $comment_path . " が見つからないか、読み込めませんでした。" . "<br>";
    }
    $index_path = MMB_PHBBS_PATH . "bbs/lists/" . MMB_PHBBS_THREAD_INIT . $state->mmb_day . ".log";
    if(file_exists($index_path)){
        $lines = file($index_path);
        $deleted_index = unlink($index_path);
        echo $index_path . ($deleted_index ? " の削除に成功しました。" : " の削除に失敗しました。") . "<br>";
        foreach ($lines as $line){
            $exploded = explode("<>", $line);
            if((int)$exploded[0] === $state->mmb_comment){
                $exploded[11] = "__DELETED__";
                $imploded = implode("<>", $exploded);
                error_log($imploded, 3, $index_path);
                echo $index_path . " に [" . $imploded . "] を追加しました。" . "<br>";
            } else {
                error_log($line, 3, $index_path);
                echo $index_path . " に [" . $line . "] を追加しました。" . "<br>";
            }
        }
    } else {
        echo $index_path . " が見つからないか、読み込めませんでした。" . "<br>";
    }
//    $index_path = MMB_PHBBS_PATH . 'bbs/lists/' . MMB_PHBBS_THREAD_INIT . $state->mmb_day . ".log";
//    if(file_exists($index_path)){
//        $lines = file($index_path);
////        $deleted_index = unlink($index_path);
////        echo $index_path . ($deleted_index ? " の削除に成功しました。" : " の削除に失敗しました。") . "<br>";
////        $inserted = false;
////        foreach ($lines as $line){
////            $exploded = explode("<>", $line);
////            if((int)$exploded[0] < $state->mmb_comment){
////                error_log($line, 3, $article_txt);
////            }
////        }
//    } else {
//        echo $index_path . " が見つからないか、読み込めませんでした。" . "<br>";
//    }
    echo '<br><br><a href="admin.php">戻る</a>';
}