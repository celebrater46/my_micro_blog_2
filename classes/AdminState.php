<?php

namespace my_micro_blog\classes;

require_once "State.php";

class AdminState extends State
{
    public $mmb_mode;
    public $mmb_post;

    public function __construct(){
        parent::__construct();
        $this->mmb_mode = isset($_GET["mmb_mode"]) ? (int)$_GET["mmb_mode"] : null;
        $this->mmb_post = isset($_GET["mmb_post"]) ? (int)$_GET["mmb_post"] : null;
    }
}