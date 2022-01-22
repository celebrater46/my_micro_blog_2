<?php

// Archives
class Month
{
    public $id;
    public $month; // 202102
    public $month_string = ""; // 2021年2月
    public $articles = [];

    function __construct($id, $month, $list){
        // $list == "20220102|タイトル|カテゴリ1|カテゴリ2", ...
        $this->id = (int)$id;
//        $this->month = substr($list[$this->id], 0, 6); // 202102
        $this->month = (int)$month; // 202102
        $this->month_string = $this->get_month_string($this->month);
        foreach ($list as $line){
            $temp = explode("|", $line);
            $m = substr($temp[0], 0, 6); // 202102
            if ($m == $this->month) {
                array_push($this->articles, $temp[0]);
            }
        }
    }

    function get_month_string($month){
        $str = (string)$month;
        $y = substr($str, 0, 4);
        $m = substr($str, 4, 2);
        return $y . "年" . (int)$m . "月";
    }
}