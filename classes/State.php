<?php

namespace my_micro_blog\classes;

class State
{
    public $mmb_mode;
    public $mmb_category;
    public $mmb_month;
    public $mmb_day;
    public $page;

    function __construct(){
        $this->mmb_mode = isset($_GET["mmb_mode"]) ? (int)$_GET["mmb_mode"] : null;
        $this->mmb_category = isset($_GET["mmb_category"]) ? (int)$_GET["mmb_category"] : null;
        $this->mmb_month = isset($_GET["mmb_month"]) ? (int)$_GET["mmb_month"] : null;
        $this->mmb_day = isset($_GET["mmb_day"]) ? (int)$_GET["mmb_day"] : null;
        $this->page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
    }

    function get_ques_or_and($str){
        return $str !== "" ? "&" : "";
//        if(strpos($str, "?") === false)
//        return strpos($str, "?") === false ? "?" : "&";
    }

    // $array = ["hoge" => 1, "fuga" => 2 ... ]
    function get_new_url_parameters($array, $additional){
        $parameters = [
            "mmb_mode" => $this->mmb_mode,
            "mmb_category" => $this->mmb_category,
            "mmb_month" => $this->mmb_month,
            "mmb_day" => $this->mmb_day,
            "page" => $this->page
        ];
        foreach ($array as $key => $num){
            $parameters[$key] = $num;
        }
        $parameter_str = $parameters["mmb_mode"] === null ? "" : "mmb_mode=" . $parameters["mmb_mode"];
        $parameter_str .= $parameters["mmb_category"] === null ? "" : $this->get_ques_or_and($parameter_str) . "mmb_category=" . $parameters["mmb_category"];
        $parameter_str .= $parameters["mmb_month"] === null ? "" : $this->get_ques_or_and($parameter_str) . "mmb_month=" . $parameters["mmb_month"];
        $parameter_str .= $parameters["mmb_day"] === null ? "" : $this->get_ques_or_and($parameter_str) . "mmb_day=" . $parameters["mmb_day"];
        $parameter_str .= $parameters["page"] === null ? "" : $this->get_ques_or_and($parameter_str) . "page=" . $parameters["page"];
        return $parameter_str;
//        $mode = $parameters["mmb_mode"] === null ? "" : "mmb_mode=" . $parameters["mmb_mode"];
//        $category = $parameters["mmb_category"] === null ? "" : "mmb_category=" . $parameters["mmb_category"];
//        $month = $parameters["mmb_month"] === null ? "" : "&mmb_month=" . $parameters["mmb_month"];
//        $day = $parameters["mmb_day"] === null ? "" : "&mmb_day=" . $parameters["mmb_day"];
//        $page = $parameters["page"] === null ? "" : "&page=" . $parameters["page"];
//        return $category . $month . $day . $additional;
    }

    function get_url_parameters($additional){
        $parameter_str = $this->mmb_category === null ? "" : "mmb_category=" . $this->mmb_category;
        $parameter_str .= $this->mmb_category === null ? "" : $this->get_ques_or_and($parameter_str) . "mmb_category=" . $this->mmb_category;
        $parameter_str .= $this->mmb_month === null ? "" : $this->get_ques_or_and($parameter_str) . "mmb_month=" . $this->mmb_month;
        $parameter_str .= $this->mmb_day === null ? "" : $this->get_ques_or_and($parameter_str) . "mmb_day=" . $this->mmb_day;
        $parameter_str .= $this->page === null ? "" : $this->get_ques_or_and($parameter_str) . "page=" . $this->page;
        return $parameter_str;
//        $category = $this->mmb_category === null ? "" : "mmb_category=" . $this->mmb_category;
//        $month = $this->mmb_month === null ? "" : "&mmb_month=" . $this->mmb_month;
//        $day = $this->mmb_day === null ? "" : "&mmb_day=" . $this->mmb_day;
//        $page = $this->page === null ? "" : "&page=" . $this->page;
//        return $category . $month . $day . $this->page . $additional;
    }
}