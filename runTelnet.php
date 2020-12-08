wdw
<?php

function exec_script($url, $params = array()) {
    $parts = parse_url($url);

    if (!$fp = fsockopen($parts['host'], isset($parts['port']) ? $parts['port'] : 80)) {
        return false;
    }

    $data = http_build_query($params, '', '&');

    fwrite($fp, "POST " . (!empty($parts['path']) ? $parts['path'] : '/') . " HTTP/1.1\r\n");
    fwrite($fp, "Host: " . $parts['host'] . "\r\n");
    fwrite($fp, "Content-Type: application/x-www-form-urlencoded\r\n");
    fwrite($fp, "Content-Length: " . strlen($data) . "\r\n");
    fwrite($fp, "Connection: Close\r\n\r\n");
    fwrite($fp, $data);
    fclose($fp);

    return true;
}

exec_script('127.0.0.1:55130/telnet_core_middle_client.php', array('foo' => 'bar'));
