<?php
// Redirect user to ViewUsers.php. This happens if ../administration directory is entered into address bar.
$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
$url = rtrim($url, '/\\');
$page = 'ViewUsers.php';
$url.= '/' . $page;
header("Location: $url");
exit();
?>