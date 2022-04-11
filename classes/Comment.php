<?php

namespace my_micro_blog\classes;

use function my_micro_blog\get_articles_list;

require_once dirname(__FILE__) . '/../main.php';

class Comment
{
    public $id;
    public $article_id; // 20211231(int)
    public $article_title;
//    public $date; // 2021-12-31_10:37:37
    public $user_name;
    public $comment_lines = [];
    public $deleted;

    function __construct($id, $line, $articles_list){
        $temp = explode("<>", $line);
        $this->id = $id;
        $this->article_id = (int)$temp[13];
        $this->user_name = $temp[5];
        if($articles_list !== null){
            $this->article_title = $this->get_article_title($articles_list);
        }
        $this->deleted = $temp[11] === "__DELETED__";
    }

    function get_article_title($list){
        if($list !== null){
            foreach ($list as $line){
                $temp = explode("|", $line);
                if((int)$temp[2] === $this->article_id){
                    return $temp[3];
                }
            }
            return "無題";
        } else {
            return "無題";
        }
    }
}