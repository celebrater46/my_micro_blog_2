<?php

namespace my_micro_blog\classes;

require_once "State.php";

class AdminState extends State
{
    public $mmb_post;
    public $mmb_comment;

    public function __construct(){
        parent::__construct();
        $this->mmb_post = isset($_GET["mmb_post"]) ? (int)$_GET["mmb_post"] : null;
        $this->mmb_comment = isset($_GET["mmb_comment"]) ? (int)$_GET["mmb_comment"] : null;
    }
}