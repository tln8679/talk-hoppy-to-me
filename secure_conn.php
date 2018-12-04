<?php
    // make sure the page uses a secure connection
    $https = filter_var($_SERVER['HTTPS']);
    if (!$https) {
        $host = filter_var($_SERVER['HTTP_HOST']);
        $uri = filter_input($_SERVER['REQUEST_URI']);
        $url = 'https://' . $host . $uri;
        header("Location: " . $url);
        exit();
    }
?>

