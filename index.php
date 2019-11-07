<?php

require_once("config/config.php");

function login($url,$data){
    $userAgent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:70.0) Gecko/20100101 Firefox/70.0";
    $fp = fopen("cookie.txt", "w");
    fclose($fp);
    $login = curl_init();
    curl_setopt($login, CURLOPT_COOKIEJAR, "cookie.txt");
    curl_setopt($login, CURLOPT_COOKIEFILE, "cookie.txt");
    curl_setopt($login, CURLOPT_TIMEOUT, 40000);
    curl_setopt($login, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($login, CURLOPT_URL, $url);
    curl_setopt($login, CURLOPT_USERAGENT, $userAgent);
    curl_setopt($login, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($login, CURLOPT_POST, TRUE);
    curl_setopt($login, CURLOPT_POSTFIELDS, $data);
    ob_start();
    return curl_exec ($login);
    ob_end_clean();
    curl_close ($login);
    unset($login);    
}                  
 
function grab_page($site){
    $userAgent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:70.0) Gecko/20100101 Firefox/70.0";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
    curl_setopt($ch, CURLOPT_TIMEOUT, 40);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
    curl_setopt($ch, CURLOPT_URL, $site);
    ob_start();
    return curl_exec ($ch);
    ob_end_clean();
    curl_close ($ch);
}  

login("http://moodle.lyon.ort.asso.fr/login/index.php", CREDENTIALS);

$content = grab_page("http://moodle.lyon.ort.asso.fr/course/view.php?id=46");

$dom = new DOMDocument();
$dom->loadHTML($content); 
$xpath = new DomXPath($dom);


$nodeList = $xpath->query("//div[@class='event']");

$array = [];

foreach($nodeList as $node){
    $array[$node->getElementsByTagName('a')->item(0)->nodeValue] = $node->getElementsByTagName('a')->item(0)->getAttribute('href');
}

foreach($array as $key => $event){
    $con = grab_page($event);

    $dom = new DOMDocument();
    $dom->loadHTML($con); 
    
    $date = $dom->getElementById("dates");
    $date = $date->getElementsByTagName('td');

    $submit = $dom->getElementById("userfiles");

    $debut = $date->item(1)->nodeValue;
    $fin = $date->item(3)->nodeValue;
    
    shell_exec("node index.js '$key' '$debut' '$fin' ");
}

?>