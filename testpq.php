<?php
ini_set("display_errors", "On");
error_reporting(E_ALL);
include_once 'phpQuery/phpQuery.php';
$a = phpQuery::newDocumentFile('http://news.shsmu.edu.cn/default.php?mod=article&fid=4');
$dt = pq("#s65872874_content table tr td span");
$i = 0;

foreach ($dt as $item) {
    echo pq($item)->find('span')->html()."<br>";
}
//die;



foreach($dt as $li){
$i++;
?>
                        <div class="postlist">
                            <div class="entry-title"><a href="<?php  echo change_code(pq($li)->find('a')->attr('href'));     ?>" target="_blank"><?php   echo change_code(pq($li)->find('span:eq(1)')->text());   ?></a></div>
                            <ul class="entry-meta clearfix">
                                <li><i class="icon-calendar3"></i><?php   echo change_code(pq($li)->find('span:eq(2)')->text());   ?></li>
                            </ul>
                        </div>
<?php
if($i==5){
break;
}
}


//抓取转码函数
function change_code($str){
    return mb_convert_encoding($str,'ISO-8859-1','utf-8');
}

function object_to_array($obj) {
    $obj = (array)$obj;
    foreach ($obj as $k => $v) {
        if (gettype($v) == 'resource') {
            return;
        }
        if (gettype($v) == 'object' || gettype($v) == 'array') {
            $obj[$k] = (array)object_to_array($v);
        }
    }

    return $obj;
}
?>









