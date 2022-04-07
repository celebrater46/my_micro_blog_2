<?php

namespace my_micro_blog;

use my_micro_blog\classes\State;
use fp_common_modules as cm;
use php_hp_bbs as phbbs;
use php_number_link_generator\classes\NumberLink;

require_once "init.php";
require_once "main.php";
require_once "classes/State.php";
require_once MMB_HCM_PATH;
require_once MMB_PHBBS_PATH . "phbbs_get_html.php";
require_once MMB_PNLG_PATH . 'init.php';
require_once MMB_PNLG_PATH . 'classes/NumberLink.php';

function get_comment_ul($comments, $state){
    $html = cm\space_br('<div>', 3);
    $html .= cm\space_br('<hr>', 4);
    $html .= cm\space_br('<h2>' . "新着コメント" . '</h2>', 4);
    $html .= cm\space_br('<ul class="mmb_comments">', 4);
//    var_dump($comments);
    foreach ($comments as $comment){
        $parameters = [
            "mmb_category" => null,
            "mmb_month" => null,
            "mmb_day" => $comment->article_id
        ];
        $html .= cm\space_br('<li>', 5);
        $html .= cm\space_br('<a href="' . MMB_INDEX . '?' . $state->get_new_url_parameters($parameters, "") . '">', 6);
        $html .= cm\space_br($comment->article_title . " by " . $comment->user_name, 7);
        $html .= cm\space_br('</a>', 6);
        $html .= cm\space_br('</li>', 5);
    }
    $html .= cm\space_br('</ul>', 4);
    $html .= cm\space_br('</div>', 3);
    return $html;
}

function get_archives_ul($months, $state){
    $html = cm\space_br('<div>', 3);
    $html .= cm\space_br('<hr>', 4);
    $html .= cm\space_br('<h2>' . "月別記事" . '</h2>', 4);
    $html .= cm\space_br('<ul>', 4);
    foreach ($months as $month){
        $parameters = [
            "mmb_category" => null,
            "mmb_month" => $month->id,
            "mmb_day" => null
        ];
        $html .= cm\space_br('<li>', 5);
        $html .= cm\space_br('<a href="' . MMB_INDEX . '?' . $state->get_new_url_parameters($parameters, "") . '">', 6);
        $html .= cm\space_br($month->month_string, 7);
        $html .= cm\space_br('</a>', 6);
        $html .= cm\space_br('</li>', 5);
    }
    $html .= cm\space_br('</ul>', 4);
    $html .= cm\space_br('</div>', 3);
    return $html;
}

function get_category_ul($categories, $state){
    $html = cm\space_br('<div>', 3);
    $html .= cm\space_br('<h2>' . "カテゴリ" . '</h2>', 4);
    $html .= cm\space_br('<ul>', 4);
    foreach ($categories as $category){
        $parameters = [
            "mmb_category" => $category->id,
            "mmb_month" => null,
            "mmb_day" => null
        ];
        $html .= cm\space_br('<li>', 5);
        $html .= cm\space_br('<a href="' . MMB_INDEX . '?' . $state->get_new_url_parameters($parameters, "") . '">', 6);
        $html .= cm\space_br($category->name, 7);
        $html .= cm\space_br('</a>', 6);
        $html .= cm\space_br('</li>', 5);
    }
    $html .= cm\space_br('</ul>', 4);
    $html .= cm\space_br('</div>', 3);
    return $html;
}

function get_article_footer_html($article, $state){
    $html = cm\space_br('<div class="mmb_article_footer">', 4);
    $html .= cm\space_br('<p>', 5);
    $parameters2 = [
        "mmb_category" => null,
        "mmb_month" => null,
        "mmb_day" => null
    ];
    $html .= cm\space_br("カテゴリ： ", 6);
    $parameters2["mmb_category"] = $article->category_id1;
    $html .= cm\space_br('<a href="' . MMB_INDEX . '?' . $state->get_new_url_parameters($parameters2, "") . '">', 6);
    $html .= cm\space_br($article->category1, 7);
    $html .= cm\space_br('</a>', 6);
    $html .= cm\space_br("　|　", 6);
    $parameters2["mmb_category"] = $article->category_id2;
    $html .= cm\space_br('<a href="' . MMB_INDEX . '?' . $state->get_new_url_parameters($parameters2, "") . '">', 6);
    $html .= cm\space_br($article->category2, 7);
    $html .= cm\space_br('</a>', 6);
    $html .= cm\space_br('</p>', 5);
    $comments_num = count_comments_in_one_article($article->date, $state);
    $html .= cm\space_br('<p>', 5);
    if($comments_num > 0){
        $parameters2["mmb_category"] = null;
        $parameters2["mmb_day"] = $article->date;
        $html .= cm\space_br('<a href="' . MMB_INDEX . '?' . $state->get_new_url_parameters($parameters2, "") . '">', 6);
        $html .= cm\space_br("コメント（" . $comments_num . "）", 7);
        $html .= cm\space_br('</a>', 6);
    } else {
        $html .= cm\space_br("コメント（" . $comments_num . "）", 6);
    }

    $html .= cm\space_br('</p>', 5);
    $html .= cm\space_br('</div>', 4);
    return $html;
}

function get_articles_html($articles, $state){
    rsort($articles);
//    var_dump($articles);
    $html = "";
    $start_article = ($state->page - 1) * MMB_MAX_ARTICLES_PER_PAGE;
    $end_article = $state->page * MMB_MAX_ARTICLES_PER_PAGE;
//    foreach ($articles as $article){
    for($i = $start_article; $i < $end_article; $i++){
        if(isset($articles[$i])){
            $parameters = [
                "mmb_category" => null,
                "mmb_month" => null,
                "mmb_day" => $articles[$i]->date
            ];
            $articles[$i]->get_lines();
            $html .= cm\space_br('<div class="mmb_article">', 3);
            $html .= cm\space_br('<hr>', 4);
            $html .= cm\space_br('<div class="mmb_date">', 4);
            $html .= cm\space_br($articles[$i]->date_string, 5);
            $html .= cm\space_br('</div>', 4);
            $html .= cm\space_br('<h2>', 4);
            $html .= cm\space_br('<a href="' . MMB_INDEX . '?' . $state->get_new_url_parameters($parameters, "") . '">' . $articles[$i]->title . '</a>', 5);
            $html .= cm\space_br('</h2>', 4);
            $html .= cm\space_br('<div class="mmb_text">', 4);
            foreach ($articles[$i]->lines as $line){
                $html .= cm\space_br('<p>' . $line . '</p>', 5);
            }
            $html .= cm\space_br('</div>', 4);
            $html .= get_article_footer_html($articles[$i], $state);
            $html .= cm\space_br('</div>', 3);
            if(MMB_COMMENT && $state->mmb_day !== null){
                $html .= cm\space_br('<hr>', 3);
                $html .= cm\space_br('<h3>コメント</h3>', 3);
                $html .= phbbs\phbbs_get_html("mmb_" . $state->mmb_day);
            }
        }
    }
    if(count($articles) > MMB_MAX_ARTICLES_PER_PAGE){
        $link = new NumberLink(count($articles), MMB_MAX_ARTICLES_PER_PAGE);
        $html .= $link->get_page_links_html("", MMB_INDEX);
    }
    return $html;
}

function get_splitter_div($state){
    $list = get_articles_list(); // 220101|これはタイトルです|カテゴリ1|カテゴリ2, 220103|テストタイトルです|カテゴリ3|カテゴリ2...
    $categories = get_categories($state, $list);
    $months = get_months($list);
    $comments = get_comments($state);
//    var_dump($comments);
    $extracted = extract_articles_list($list, $state, $months);
    $articles = get_articles($extracted);
    $html = cm\space_br('<div class="mmb_splitter">', 1);
    $html .= cm\space_br('<div class="mmb_main">', 2);
    if($state->mmb_category > -1){
        $html .= cm\space_br('<h2>' . $categories[$state->mmb_category]->name . '</h2>', 3);
    } else if($state->mmb_month > -1){
        $html .= cm\space_br('<h2>' . $months[$state->mmb_month]->month_string . '</h2>', 3);
    }
    $html .= get_articles_html($articles, $state);
    $html .= cm\space_br('</div>', 2);
    $html .= cm\space_br('<div class="mmb_side">', 2);
    $html .= get_category_ul($categories, $state);
    $html .= get_archives_ul($months, $state);
    $html .= get_comment_ul($comments, $state);
    $html .= cm\space_br('</div>', 2);
    $html .= cm\space_br('</div>', 1);
    return $html;
}

function get_head_html(){
    $html = cm\space_br("<h1>", 1);
    $html .= cm\space_br("<a href='" . MMB_INDEX . "'>" . MMB_TITLE . '</a>', 2);
    $html .= cm\space_br("</h1>", 1);
    $html .= cm\space_br('<div class="description">' . MMB_DESCRIPTION . '</div>', 1);
    return $html;
}

function mmb_get_html(){
    $state = new State();
//    $list = get_articles_list(); // 220101|これはタイトルです|カテゴリ1|カテゴリ2, 220103|テストタイトルです|カテゴリ3|カテゴリ2...
//    $categories = get_categories($state, $list);
//    $months = get_months($list);
//    $extracted = extract_articles_list($list, $state, $months);
//    $articles = get_articles($extracted);
    $html = get_head_html();
    $html .= get_splitter_div($state);
    return $html;
}