<?php

namespace my_micro_blog\classes;

class Old_Categories
{

    public $categories = [];
    public $error = "";

    function __construct()
    {
        if (file_exists("list.txt")) {
            $list = file("list.txt");
            $this->categories = $this->get_category_array($list);
        } else {
            $this->error = "ERROR: 記事リスト（list.txt）が存在しないか、書き方を間違えています。";
        }
    }

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
}