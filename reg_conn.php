<?php
// check the current status
$https = filter_var($_SERVER['HTTPS']);
if ($https) {
    $host = filter_var($_SERVER['HTTP_HOST']);
    $uri = $_SERVER['REQUEST_URI'];
    $uri = filter_var($uri);
    $url = 'http://' . $host . $uri;
    header("Location: " . $url);
    exit();
}
?>