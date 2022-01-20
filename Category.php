<?php

class Category
{
    public $name;
    public $articles = [];

    function __construct($name, $list){
        // $list == "20220102|タイトル|カテゴリ1|カテゴリ2", ...
        $this->name = $name;
        foreach ($list as $line){
            $temp = explode("|", $line);
            if (isset($temp[2]) && $temp[2] == $name) {
//                array_push($array, $temp[2]);
                array_push($this->articles, $temp[1]);
            }
            if (isset($temp[3]) && $temp[3] == $name && $temp[3] != $temp[2]) {
                array_push($this->articles, $temp[1]);
            }
        }
    }
}