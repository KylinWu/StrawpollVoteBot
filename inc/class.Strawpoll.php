<?php

class StrawPoll {
    public function __construct() {
    }

    public function vote($id, $votes, $amount = 10, $proxyList = null, $timeout = 5) {
        $mh = curl_multi_init();
        
        if(is_file($proxyList)){ 
            $parts = pathinfo($proxyList);
            $proxies = file($proxyList);
        }
        $body = '{"votes":['."$votes".']}';
        $headers = array(
            'Content-Type: application/json'
        );

        if($amount > 1000) {
            $amount = count($proxies);      
        }
        
        $handle = array();
        $used = array();
        $url = 'http://strawpoll.me/api/v2/polls/'.$id;

        for($i = 0; $i < $amount; $i++) {
            $ch = curl_init();
            if(isset($proxies)) {
                if(count($proxies) < 1) break;
                $key = array_rand($proxies);
                $proxy = $proxies[$key];
                unset($proxies[$key]);
                $proxyType = CURLPROXY_HTTP;
                $proxy = trim($proxy);
                $parts = explode(':', $proxy);
                if(isset($parts[0], $parts[1])) {
                    $proxyIP = gethostbyname($parts[0]);
                    $proxyPort = $parts[1];
                } 
                else {
                    $i--;
                    continue;
                }
                if(isset($parts[2])) {
                    $proxyType = strtoupper($proxyType) == 'SOCKS5' ? CURLPROXY_SOCKS5 : CURLPROXY_HTTP;
                }
                if(isset($used[$proxyIP])) {
                    $i--;
                    continue;
                }
                $used[$proxyIP] = true;
                if(!filter_var($proxyIP, FILTER_VALIDATE_IP,
                                         FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)
                   || (!ctype_digit($proxyPort) || ($proxyPort < 0 || $proxyPort > 65535))) {
                    $i--;
                    continue;
                }
                curl_setopt_array($ch, array(
                    CURLOPT_PROXY => $proxyIP . ':' . $proxyPort,
                    CURLOPT_PROXYTYPE => $proxyType
                ));
            }
            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_CUSTOMREQUEST => 'PATCH',
                CURLOPT_POSTFIELDS => $body,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_TIMEOUT => $timeout
            ));
            curl_multi_add_handle($mh, $ch);
            $handle[$i] = $ch;
        }

        $running = null;
        $votes = 0;
        do {
            curl_multi_exec($mh, $running);
            curl_multi_select($mh);
        } while ($running > 0);

        foreach($handle as $ch) {
            $info = curl_getinfo($ch);
            if($info['http_code'] == 200) {
                $votes++;
            }
        }

        foreach($handle as $ch) {
            curl_multi_remove_handle($mh, $ch);
        }
        curl_multi_close($mh);

        return array('votes' => $votes, 'total' => $amount);
    }
}
?>
