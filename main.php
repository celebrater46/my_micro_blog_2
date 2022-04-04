<?php

namespace my_micro_blog;

use my_micro_blog\classes\Article;
use my_micro_blog\classes\Category;
use my_micro_blog\classes\Month;

require_once "init.php";
require_once "classes/Article.php";
require_once "classes/Category.php";
require_once "classes/Month.php";

function get_categories($list){
    $category_array = get_category_array($list); // category1, category2 ...
    $new_array = [];
    $i = 0;
    foreach ($category_array as $name) {
        array_push($new_array, new Category($i, $name, $list));
        $i++;
    }
    return $new_array;
}

function get_months($list){
    $month_array = get_month_array($list); // 202102, 202103 ...
    $new_array = [];
    $j = 0;
    foreach ($month_array as $month) {
        array_push($new_array, new Month($j, $month, $list));
        $j++;
    }
    return $new_array;
}

function get_articles($list){
    $list_per_page = get_list_per_page($list, MMB_MAX_ARTICLES_PER_PAGE); // max:
    $new_array = [];
    foreach ($list_per_page as $line){
        array_push($new_array, new Article($line));
    }
    return $new_array;
}

// "5", "false", "false" ...
function get_setting(){
    if(file_exists("setting.txt")){
        /*
            max:5
            fold:false
            comment:false
            comment_permit:false
            new_comments:5
            new_articles:5
        */
        $list = file("setting.txt");
        $list = str_replace([
            "max:",
            "fold:",
            "comment:",
            "comment_permit:",
            "new_comments:",
            "new_articles:",
            " ",
            "\n",
            "\r",
            "\r\n"
        ], "", $list);
        return $list;
    } else {
        return null;
    }
}

function get_list(){
    if(file_exists("list.txt")){
        return file("list.txt");
    } else {
        return ["ERROR: list.txt が存在しないか、読み込めません。"];
    }
}

function get_list_per_page($list, $max){
    $temp_array = [];
    if((int)$max > 0){
        for($i = 0; $i < $max; $i++){
            array_push($temp_array, $list[$i]);
        }
        return $temp_array;
    } else {
        return $list;
    }
}

// 202101, 202102 ...
function get_month_array($list){
    $array = [];
    foreach ($list as $line){
        $temp = explode("|", $line);
        $temp2 = substr($temp[0], 0, 6); // 202102
        array_push($array, (int)$temp2);
    }
    return array_unique($array);
}

// category1, category2 ...
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