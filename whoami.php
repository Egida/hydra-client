<?php
error_reporting(0);
if(!$_GET['key']) die('{"type":"error", "code":"access_denied", "message": "Wrong key"}');
$license = base64_encode('4e2a5f729d156591784ac3313e9b5560');
if($license!==$_GET['key']) {$license_type = 'error';} else {$license_type = 'success';}
if($license_type=='error') die('{"type":"error", "code":"access_denied", "message": "Wrong key"}');
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
if(!file_exists('./whoami.dat')) file_put_contents('./whoami.dat', generateRandomString(30));

if($_GET['command']=='mother') {
    echo('{
    "type": "ok",
    "response": "hello",
    "code": "' . base64_encode(file_get_contents('./whoami.dat')) . '"
}');
} else {
    echo('{
    "code": "' . base64_encode(file_get_contents('./whoami.dat')) . '"
}');
}