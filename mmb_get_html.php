<?php

namespace my_micro_blog;

use my_micro_blog\classes\State;
use fp_common_modules as cm;

require_once "init.php";
require_once "main.php";
require_once "classes/State.php";
require_once MMB_HCM_PATH;

function get_archives_ul($months, $state){
    $html = cm\space_br('<div>', 3);
    $html .= cm\space_br('<hr>', 4);
    $html .= cm\space_br('<h2>' . "カテゴリ" . '</h2>', 4);
    $html .= cm\space_br('<ul>', 4);
    foreach ($months as $month){
        $html .= cm\space_br('<li>', 5);
        $html .= cm\space_br('<a href="' . MMB_INDEX . '?' . $state->get_new_url_parameters(["mmb_month" => $month->id], "") . '">', 6);
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
        $html .= cm\space_br('<li>', 5);
        $html .= cm\space_br('<a href="' . MMB_INDEX . '?' . $state->get_new_url_parameters(["mmb_category" => $category->id], "") . '">', 6);
        $html .= cm\space_br($category->name, 7);
        $html .= cm\space_br('</a>', 6);
        $html .= cm\space_br('</li>', 5);
    }
    $html .= cm\space_br('</ul>', 4);
    $html .= cm\space_br('</div>', 3);
    return $html;
}

function get_articles_html($articles){
    $html = "";
    foreach ($articles as $article){
        $article->get_lines();
        $html .= cm\space_br('<div class="mmb_article">', 3);
        $html .= cm\space_br('<hr>', 4);
        $html .= cm\space_br('<div class="mmb_date">', 4);
        $html .= cm\space_br($article->date_string . "　|　", 5);
        $html .= cm\space_br($article->category1 . "　|　", 5);
        $html .= cm\space_br($article->category2, 5);
        $html .= cm\space_br('</div>', 4);
        $html .= cm\space_br('<h2>' . $article->title . '</h2>', 4);
        $html .= cm\space_br('<div class="mmb_text">', 4);
        foreach ($article->lines as $line){
            $html .= cm\space_br('<p>' . $line . '</p>', 5);
        }
        $html .= cm\space_br('</div>', 4);
        $html .= cm\space_br('</div>', 3);
    }
    return $html;
}

function get_splitter_div($articles, $categories, $months, $state){
    $html = cm\space_br('<div class="mmb_splitter">', 1);
    $html .= cm\space_br('<div class="mmb_main">', 2);
    if($state->mmb_category > 0){
        $html .= cm\space_br('<h2>' . $categories[$state->mmb_category]->name . '</h2>', 3);
    } else if($state->mmb_month > 0){
        $html .= cm\space_br('<h2>' . $months[$state->mmb_month]->month_string . '</h2>', 3);
    }
    $html .= get_articles_html($articles);
    $html .= cm\space_br('</div>', 2);
    $html .= cm\space_br('<div class="mmb_side">', 2);
    $html .= get_category_ul($categories, $state);
    $html .= get_archives_ul($months, $state);
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
    $list = get_articles_list(); // 220101|これはタイトルです|カテゴリ1|カテゴリ2, 220103|テストタイトルです|カテゴリ3|カテゴリ2...
    $articles = get_articles($list);
    $categories = get_categories();
    $months = get_months($list);
    $state = new State();
    $html = get_head_html();
    $html .= get_splitter_div($articles, $categories, $months, $state);
    return $html;
}