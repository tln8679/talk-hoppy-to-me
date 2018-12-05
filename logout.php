<?php
/*
    a. Check for an existing session
    b. Check for a specific $_SESSION variable you have stored at login
    c. If it is set:
    i. i. Empty the $_SESSION array
    ii. Remove the session data from the server with session_destroy();
    iii. Delete the cookie from the user’s browser with (setcookie('PHPSESSID', '',
    time()-3600, '/');
    iv. Set a $message variable (or two) to output that the user is successfully
    logged out
    d. If it is not set: Set the $message variable(s) to indicate that the user has reached the
    page in error. 
*/
require 'includes/header.php';
?>
    <main>
<?php
if (isset($_SESSION['email'])) {
    session_unset();
    session_destroy();
    setcookie('PHPSESSID', '', time() - 3600, '/');
    $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    $url = rtrim($url, '/\\');
    $page = 'login.php';
    $url.= '/' . $page;
    header("Location: $url");
    exit();
}
?>
</main>
<?php // Include the footer and quit the script:
include ('./includes/footer.php');
?>

