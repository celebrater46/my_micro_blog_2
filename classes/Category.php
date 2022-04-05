<?php

namespace my_micro_blog\classes;

use my_micro_blog as mmb;

require_once dirname(__FILE__) . '/../main.php';

class Category
{
    public $id;
    public $name;
    public $articles = [];

    function __construct($id, $name){
        // $list == "20220102|タイトル|カテゴリ1|カテゴリ2", ...
        $this->id = $id;
        $this->name = $name;
        $this->articles = $this->get_articles_in_category();
    }

    function get_articles_in_category(){
        $list = mmb\get_articles_list();
        foreach ($list as $line){
            $temp = explode("|", $line);
            if (isset($temp[0]) && (int)$temp[0] === $this->id) {
                array_push($this->articles, $temp[3]);
            }
            if (isset($temp[0]) && (int)$temp[0] === $this->id) {
                array_push($this->articles, $temp[3]);
            }
        }
    }
}