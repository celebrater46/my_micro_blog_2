<?php

namespace my_micro_blog\classes;

class Article
{
    public $date = 10000101; // 20220103
    public $date_string = "1000年1月1日";
    public $title;
    public $category1 = "未分類";
    public $category2 = "未分類";
    public $text = [];

    function __construct($line){ // $line == 220103|タイトル|カテゴリ1|カテゴリ2
        if(strpos($line,'|') !== false){
            $temp = explode("|", $line); // 220103, "タイトル", "カテゴリ1", "カテゴリ2"
            $temp2 = [];
            foreach ($temp as $item){
//                $temp2 = str_replace([" ", "　", "\n", "\r", "\r\n"], "", $item); // 悪魔のバグ要因、全角＆半角スペース、改行コードの排除
                array_push($temp2, str_replace([" ", "　", "\n", "\r", "\r\n"], "", $item)); // 悪魔のバグ要因、全角＆半角スペース、改行コードの排除
            }
            $this->date = (int)$temp[0];
            $this->date_string = $this->get_date_string($temp[0]);
            $this->title = $temp[1];
            if(count($temp2) > 2) {
                $this->category1 = $temp[2];
            }
            if(count($temp2) > 3) {
                $this->category2 = $temp[3];
            }
            $this->text = $this->get_text();

        } else {
            $this->title = "ERROR: 記事情報が存在しないか、書き方を間違えています。";
        }
    }

    function get_text(){
        $temp = [];
        if(file_exists("articles/" . (string)$this->date . ".txt")){
            $temp2 = file("articles/" . (string)$this->date . ".txt");
            $temp3 = $this->convert_num_tags($temp2);
            return $this->convert_blank_to_space($temp3);
        } else {
            $temp = ["記事ファイル「" . $this->date . ".txt」が存在しないか、読み込めません。"];
            return $temp;
        }
    }

    function convert_blank_to_space($array){
        $temp_array = [];
        foreach ($array as $line){
            if($line === "" || $line === "\n" || $line === "\r" || $line === "\r\n") {
                array_push($temp_array, "　");
            } else {
                array_push($temp_array, $line);
            }
        }
        return $temp_array;
    }

    function convert_num_tags($array){
        $temp_array = [];
        foreach ($array as $line){
            if(strpos($line,"<") !== false){
//                $ptn = "/\<([1-9])\>/";
//                $rp = "<span class='f$1'>";
                $temp = preg_replace("/\<([1-9])\>/", "<span class='f$1'>", $line);
                $temp2 = preg_replace("/\<\/[1-9]\>/", "</span>", $temp);
                array_push($temp_array, $temp2);
            } else {
                array_push($temp_array, $line);
            }
        }
        return $temp_array;
    }

//    function replace_num_tags($line){
//
//    }

    function get_date_string($date){
        $str = (string)$date;
        $y = substr($str, 0, 4);
        $m = substr($str, 4, 2);
        $d = substr($str, 6, 2);
        return $y . "年" . (int)$m . "月" . (int)$d . "日";
    }
}