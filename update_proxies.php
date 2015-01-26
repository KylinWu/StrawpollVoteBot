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

$html = get_html('http://checkerproxy.net/all_proxy');

$dom = new DOMDocument();
$dom->loadHTML($html);
$textarea = $dom->getElementsByTagName("textarea");
foreach ($textarea as $value) {
    if($value->getAttribute('name') == 'insert')
        $content = $value->nodeValue;
}

$file = fopen("proxies.txt","w");
fwrite($file, $content);
fclose($file);

echo 'The proxy list file:proxies.txt are updated at ' . date("Y-m-d H:i:s") . "\n";

?>
