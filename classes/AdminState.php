<?php

namespace my_micro_blog\classes;

require_once "State.php";

class AdminState extends State
{
    public $mmb_mode;

    public function __construct(){
        parent::__construct();
        $this->mmb_mode = isset($_GET["mmb_mode"]) ? (int)$_GET["mmb_mode"] : null;
    }
}