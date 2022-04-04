<?php

namespace my_micro_blog\classes;

class State
{
    public $mmb_category;
    public $mmb_month;

    function __construct(){
        $this->mmb_category = isset($_GET["mmb_category"]) ? (int)$_GET["mmb_category"] : 0;
        $this->mmb_month = isset($_GET["mmb_month"]) ? (int)$_GET["mmb_month"] : 0;
    }

    function get_url_parameters(){
        return "mmb_category=" . $this->mmb_category . "&mmb_month=" . $this->mmb_month;
    }
}