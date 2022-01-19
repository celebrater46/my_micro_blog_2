<?php

class Article
{
    public $date = 10000101; // 20220103
    public $title;
    public $category1 = "未分類";
    public $category2 = "未分類";

    function __construct($line){ // $line == 220103|タイトル|カテゴリ1|カテゴリ2
        if(strpos($line,'|') !== false){
            $temp = explode("|", $line); // 220103, "タイトル", "カテゴリ1", "カテゴリ2"
            $temp2 = [];
            foreach ($temp as $item){
                $temp2 = str_replace([" ", "　", "\n", "\r", "\r\n"], "", $item); // 悪魔のバグ要因、全角＆半角スペース、改行コードの排除
            }
            $this->date = (int)$temp[0];
            $this->title = $temp[1];
            if(count($temp2) > 2) {
                $this->category1 = $temp[2];
            }
            if(count($temp2) > 3) {
                $this->category2 = $temp[3];
            }
        } else {
            $this->title = "ERROR: 記事情報が存在しないか、書き方を間違えています。";
        }
    }
}