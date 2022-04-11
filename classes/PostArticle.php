<?php

namespace my_micro_blog\classes;

use function my_micro_blog\get_articles_list;
use function my_micro_blog\get_categories_list;
use const my_micro_blog\MMB_PATH;

require_once dirname(__FILE__) . '/../main.php';

class PostArticle extends Article
{
    function post_init(){
        // <input class="mmb_subtitle" type="text" name="subtitle" value="">
        // <textarea class="mmb_body" name="body">
        // <input class="mmb_date" type="text" name="date2" value="' . $date . '">
        // <select class="mmb_category" name="category1">
        // <select class="mmb_category" name="category2">
        $this->title = isset($_POST["subtitle"]) ? $_POST["subtitle"] : "無題";
        $this->date_string2 = $this->check_date();
        $this->date = $this->get_date();
        $this->category1 = isset($_POST["category1"]) ? $_POST["category1"] : "未分類";
        $this->category2 = isset($_POST["category2"]) ? $_POST["category2"] : "未分類";
        $this->category_id1 = $this->get_category_key($this->category1);
        $this->category_id2 = $this->get_category_key($this->category2);
        $this->lines = $this->get_lines_from_post();
    }

    function save_body(){
        $path = MMB_PATH . "articles/" . $this->date . ".txt";
        error_log($this->lines[0] . "\n", 3, $path);
    }

    function update_article_list(){
        $str = $this->category_id1 . "|" . $this->category_id2 . "|" . $this->date . "|" . $this->title . "|" . $this->date_string2 . "|0";
        $path = MMB_PATH . "lists/articles.txt";
        error_log($str . "\n", 3, $path);
    }

    function get_lines_from_post(){
        if(isset($_POST["body"])){
            return [ $_POST["body"] ];
        } else {
            echo "本文が入力されていません。" . "<br>";
            echo "<a href='admin.php'>戻る</a>";
            exit;
        }
    }

    function get_date(){
        $str = preg_replace('/^([0-9]{4})-([0-9]{2})-([0-9]{2})/', "$1$2$3", $this->date_string2);
        return (int)$str;
    }

    function check_date(){
        if(isset($_POST["date2"])){
            $result = preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}_[0-9]{2}:[0-9]{2}:[0-9]{2}$/', $_POST["date2"]);
            if($result === false){
                echo "日付データが正しく入力されていません（例：2022-04-09_02:02:02）" . "<br>";
                echo "<a href='admin.php'>戻る</a>";
                exit;
            } else {
                return $_POST["date2"];
            }
        } else {
            return "1000-01-01_00:00:00";
        }
    }

    function get_category_key($str){
        $list = get_categories_list();
        $i = 0;
        foreach ($list as $line){
            $temp = explode("|", $line);
//            if(strpos($str, $line) !== false){
            if($temp[0] === $str){
                return $i;
            } else {
                $i++;
            }
        }
    }
}