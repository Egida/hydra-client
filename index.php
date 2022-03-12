<?php
error_reporting(0);
if(!$_ENV['head']) $headlink = 'http://localhost:3000'; else $headlink = $_ENV['head'];
if($_SERVER['REQUEST_URI']=='/') $a = ''; else $a = $_SERVER['REQUEST_URI'];
echo('Trying to connect head: '.'/heartbeat?id='.uniqid().'&address='.$_SERVER['HTTP_HOST'].$a);
file_get_contents($headlink.'/heartbeat?id='.uniqid().'&address='.$_SERVER['HTTP_HOST'].$a);