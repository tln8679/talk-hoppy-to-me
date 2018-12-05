<?php
$page_title = 'Access denied!';
// Include header html here
include ('includes/header.php');
echo '<div class="alert alert-warning" role="alert"><p> Sorry!</p>
        <p class="text-danger">You are not an administrator.</p></div>';
include ('includes/footer.php');
?>