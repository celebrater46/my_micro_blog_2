<?php

namespace my_micro_blog;

use my_micro_blog\classes\Article;
use my_micro_blog\classes\Category;
use my_micro_blog\classes\Comment;
use my_micro_blog\classes\Month;

require_once "init.php";
require_once "classes/Article.php";
require_once "classes/Category.php";
require_once "classes/Month.php";
require_once "classes/Comment.php";

function count_comments_in_one_article($date){
    $list = get_comments_list();
//    var_dump($list);
    if($list !== null){
        $array = [];
        $num = 0;
        foreach ($list as $line){
            $temp = explode("<>", $line);
//            echo "var temp in count_comments_in_one_article()" . "<br>";
//            var_dump($temp);
//            echo "<br>";
            if((int)$temp[13] === $date){
                $num++;
            }
        }
        return $num;
    } else {
        return null;
    }
}

function get_comments(){
    $list = get_comments_list();
//    echo "var list in get_comments()" . "<br>";
//    var_dump($list);
//    echo "<br>";
    $articles_list = get_articles_list();
    if($list !== null){
        $array = [];
        $i = 0;
        foreach ($list as $line){
            array_push($array, new Comment($i, $line, $articles_list));
            $i++;
        }
        return $array;
    } else {
        return null;
    }
}

function get_categories($state, $article_list){
    $list = get_categories_list();
    $new_array = [];
    $i = 0;
    foreach ($list as $line) {
        $temp = explode("|", $line);
        array_push($new_array, new Category($i, $temp[0], $state, $article_list));
        $i++;
    }
    return $new_array;
}

function get_months($list){
    $month_array = get_month_array($list); // 202102, 202103 ...
    $new_array = [];
    $j = 0;
    foreach ($month_array as $month) {
        array_push($new_array, new Month($j, $month, $list));
        $j++;
    }
    return $new_array;
}

function get_articles($list){
//    $list_per_page = get_list_per_page($list, MMB_MAX_ARTICLES_PER_PAGE); // max:
    $new_array = [];
//    foreach ($list_per_page as $line){
    foreach ($list as $line){
        $article = new Article();
        $article->init($line);
        array_push($new_array, $article);
    }
    return $new_array;
}

// "5", "false", "false" ...
//function get_setting(){
//    if(file_exists("setting.txt")){
//        /*
//            max:5
//            fold:false
//            comment:false
//            comment_permit:false
//            new_comments:5
//            new_articles:5
//        */
//        $list = file("setting.txt");
//        $list = str_replace([
//            "max:",
//            "fold:",
//            "comment:",
//            "comment_permit:",
//            "new_comments:",
//            "new_articles:",
//            " ",
//            "\n",
//            "\r",
//            "\r\n"
//        ], "", $list);
//        return $list;
//    } else {
//        return null;
//    }
//}

function add_thread_name_to_list_line($log){
    $date = str_replace([MMB_PHBBS_PATH . "bbs/lists/" . MMB_PHBBS_THREAD_INIT, ".log"], "", $log); // 20211231
    $lines = file($log);
    $array = [];
    foreach ($lines as $line){
        array_push($array, $line . "<>" . $date . "<>0");
    }
    return $array;
}

function get_comments_list(){
//    $list = MMB_PATH . "lists/comments.txt.old";
    $logs = glob(MMB_PHBBS_PATH . "bbs/lists/*");
//    var_dump($logs);
    if($logs !== false){
        $lines = [];
        foreach ($logs as $log){
            if(strpos($log, MMB_PHBBS_THREAD_INIT) !== false){
//            array_push($array, $log);
//                var_dump($log);
//                array_push($lines, add_thread_name_to_list_line($log));
                $array = add_thread_name_to_list_line($log);
                foreach ($array as $line){
                    array_push($lines, $line);
                }
            }
        }
        return $lines;
    } else {
        echo "ERROR: " . MMB_PHBBS_PATH . "bbs/lists が存在しないか、読み込めません。";
        return null;
    }


    $list = MMB_PHBBS_PATH . "bbs/lists/" . MMB_PHBBS_THREAD_INIT . $state->mmb_day . ".log";
    if(file_exists($list)){
        return file($list);
    } else {
        echo "ERROR: " . $list . " が存在しないか、読み込めません。";
        return null;
    }
}

function get_categories_list(){
    if(file_exists(MMB_PATH . "lists/categories.txt")){
        return file(MMB_PATH . "lists/categories.txt");
    } else {
        echo "ERROR: categories.txt が存在しないか、読み込めません。";
        return null;
    }
}

function extract_articles_list($list, $state, $months){
    if($state->mmb_category !== null){
        $array = [];
        foreach ($list as $line){
            $temp = explode("|", $line);
            if((int)$temp[0] === $state->mmb_category
                || (int)$temp[1] === $state->mmb_category)
            {
                array_push($array, $line);
            }
        }
        return $array;
    } else if($state->mmb_month !== null){
        $array = [];
        foreach ($list as $line){
            $temp = explode("|", $line);
            $date_num = substr($temp[2], 0, 6); // 202112
            if($months[$state->mmb_month]->month === (int)$date_num){
                array_push($array, $line);
            }
        }
        return $array;
    } else if($state->mmb_day !== null){
        foreach ($list as $line){
            $temp = explode("|", $line);
            if($state->mmb_day === (int)$temp[2]){
                return [$line];
            }
        }
        echo $state->mmb_day . ".txt が見つからないか、読み込めません。" . "<br>";
        return null;
    } else {
        return $list;
    }
}

function get_articles_list(){
    if(file_exists(MMB_PATH . "lists/articles.txt")){
        return file(MMB_PATH . "lists/articles.txt");
    } else {
        echo "ERROR: articles.txt が存在しないか、読み込めません。";
        return null;
    }
}

//function get_list_per_page($list, $max){
//    $temp_array = [];
//    if((int)$max > 0){
//        for($i = 0; $i < $max; $i++){
//            if(isset($list[$i])){
//                array_push($temp_array, $list[$i]);
//            } else {
//                break;
//            }
//        }
//        return $temp_array;
//    } else {
//        return $list;
//    }
//}

// 202101, 202102 ...
function get_month_array($list){
    $array = [];
    foreach ($list as $line){
        $temp = explode("|", $line);
        $temp2 = substr($temp[2], 0, 6); // 202102
        array_push($array, (int)$temp2);
    }
    return array_unique($array);
}

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}