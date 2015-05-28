<?php
ini_set('memory_limit', '-1');

function get_html($url) {
	$ch = curl_init();
	$timeout = 15;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

$today = date("Y-m-d");
$url = 'http://checkerproxy.net/getProxy?date='.$today;
$html = get_html($url);

$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($html);
libxml_clear_errors();
$textarea = $dom->getElementsByTagName("li");
$file = fopen("proxies.txt","w");
foreach ($textarea as $value) {
    $class = $value->getAttribute('class');
    if(empty($class)){
        $content = $value->nodeValue."\n";
        fwrite($file, $content);
    }
}

fclose($file);

echo 'The proxy list file:proxies.txt are updated at ' . date("Y-m-d H:i:s") . "\n";
?>
