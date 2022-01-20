<?php

//$str = '<h1>Google.com</h1>へのリンクです';
//$pattern = '/<h1>(.*)<\/h1>/u';
//$replace = '<a href="http://$1">$1</a>';
//
//$content = preg_replace($pattern, $replace, $str);

$line = "<6>大晦日</6>";
//$ptn = "/\<[1-7]\>(.*)\<\/[1-7]\>/u";
$ptn = "/\<([1-7])\>(.*)\<\/.\>/u";
$rp = "<span class='f$1'>$2</span>";

$temp = preg_replace($ptn, $rp, $line);

var_dump($temp); // string(33) "<span class='f6'>大晦日</span>"
