<?php

header("Content-type:text/html;charset=utf-8");

include 'phpQuery/phpQuery.php';



$html = phpQuery::newDocumentFile("http://www.ks.gov.cn/ksyw_rdfw?itemid=1971&tname=%E9%80%9A%E7%9F%A5%E5%85%AC%E5%91%8A&flag=0&currentPage=1&recordCount=6421");
$data = pq(".ICRC-con li");
foreach ($data as $value) {
    $href = pq($value)->find('a')->attr('href');
    $href = "http://www.ks.gov.cn" . $href;
    $href = str_replace('xwnr?', 'xwnr_contentc?', $href);
    $con = get_fcontent($href);
    phpQuery::newDocumentHTML($con);
    $content = pq('p')->html();


}


function get_fcontent($url, $timeout = 5)
{
    $url = str_replace("&amp;", "&", urldecode(trim($url)));
    $ch  = curl_init();
    //模拟浏览器 在HTTP请求中包含一个"User-Agent: "头的字符串。
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36");
    //需要获取的URL地址，也可以在 curl_init()函数中设置。
    curl_setopt($ch, CURLOPT_URL, $url);
    //启用时会将服务器服务器返回的"Location: "放在header中递归的返回给服务器，使用CURLOPT_MAXREDIRS可以限定递归返回的数量。
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    //HTTP请求头中"Accept-Encoding: "的值。支持的编码有"identity"，"deflate"和"gzip"。如果为空字符串""，请求头会发送所有支持的编码类型。
    //在cURL 7.10中被加入。
    curl_setopt($ch, CURLOPT_ENCODING, "");
    //将 curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //当根据Location:重定向时，自动设置header中的Referer:信息。 curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
    //禁用后cURL将终止从服务端进行验证。使用CURLOPT_CAINFO选项设置证书使用CURLOPT_CAPATH选项设置证书目录 如果CURLOPT_SSL_VERIFYPEER(默认值为2)被启用，CURLOPT_SSL_VERIFYHOST需要被设置成TRUE否则设置为FALSE。
    //自cURL 7.10开始默认为TRUE。从cURL 7.10开始默认绑定安装。
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    # required for https urls
    //在发起连接前等待的时间，如果设置为0，则无限等待。
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    //设置cURL允许执行的最长毫秒数。
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
//指定最多的HTTP重定向的数量，这个选项是和CURLOPT_FOLLOWLOCATION一起使用的。
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    $content = curl_exec($ch);
    curl_close($ch);
    return $content;
}

function change_code($str)
{
    return mb_convert_encoding($str, 'ISO-8859-1', 'utf-8');
}

?>

