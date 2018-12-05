<?php
$page_title = 'View suggestions!';
// page for admin to view beers
include ('../includes/AdminHeader.php');
require_once '../../../mysqli_connect.php'; //$dbc is the connection string set upon successful connection
require ('../beans/beer.php');
ini_set('display_errors', 'On');
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if (empty($_SESSION['email'])) {
    // User hasn't logged in and clicked "My profile", so send him to log in page
    $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    $url = rtrim($url, '/\\');
    $page = 'login.php';
    $url.= '/' . $page;
    header("Location: $url");
    exit();
}
?>


<div class="container">
    <h1 style="text-align: center;">View user suggestions</h1>
    <?php
// Number of records to show per page:
$display = 10;
// Determine how many pages there are...
if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
    $pages = $_GET['p'];
} else { // Need to determine.
    // Count the number of records:
    $sql = "SELECT COUNT(`USER_ID`) FROM `SUGGESTION`";
    $r = mysqli_query($dbc, $sql);
    $row = mysqli_fetch_array($r, MYSQLI_NUM);
    $records = $row[0];
    // Calculate the number of pages...
    if ($records > $display) { // More than 1 page.
        $pages = ceil($records / $display);
    } else {
        $pages = 1;
    }
} // End of p IF.
// Determine where in the database to start returning results...
if (isset($_GET['s']) && is_numeric($_GET['s'])) {
    $start = $_GET['s'];
} else {
    $start = 0;
}
$sql = "SELECT `USER_ID`,`NATURE`,`COMMENT`,DATE_FORMAT(`DATE`,\"%M %d, %y\") AS DATE \n" . "FROM `SUGGESTION` ORDER BY DATE DESC LIMIT $start,$display";
$r = mysqli_query($dbc, $sql);
if (mysqli_num_rows($r) > 0) { // user found
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        $user_id = $row['USER_ID'];
        $nature = $row['NATURE'];
        $comment = $row['COMMENT'];
        $date = $row['DATE'];
        // <!-- The Grid -->
        echo "<div class=\"w3-row-padding\">
                <div class=\"w3-container w3-card w3-white w3-margin-bottom\">
                        <h2 class=\"w3-text-grey w3-padding-16\"><i class=\"fa fa-suitcase fa-fw w3-xxlarge w3-text-indigo\">$user_id </i></h2>
                        <div class=\"w3-container\"><hr>
                        <h5><b><span class=\"w3-opacity\">Nature: </span><span class=\"w3-text-amber\">$nature</span></b></h5>
                            <h5><b><span class=\"w3-opacity\">Suggestion: </span><span class=\"w3-text-amber\">$comment</span></b></h5>
                            <h5><b><span class=\"w3-opacity\">Date: </span><span class=\"w3-text-amber\">$date</span></b></h5>
                            <h4 class=\"w3-text-blue\">" . '<a href="../profile.php?id=' . $user_id . '"><i class="fa fa-calendar fa-fw ">View ' . $user_id . '\'s Profile</i>
                                <span style="color:DarkGoldenRod;" class="glyphicon glyphicon-eye-open">' . "
                                </span></a>
                            </h4>
                            <hr>
                        </div>
                </div>
            </div>";
    }
} else { // No user found
    echo '
            <div class=\"w3-row-padding\">
                <div class="alert alert-warning" role="alert">
                    <p> Sorry!</p>
                    <p class="text-danger">No user found.</p>
                </div>
            </div>';
}
?>
    </div>
        <?php
// Make the links to other pages, if necessary.
if ($pages > 1) {
    echo '<div class="container alert alert-info w3-margin-top" role="alert">';
    echo '<p>';
    // Determine what page the script is on:
    $current_page = ($start / $display) + 1;
    // If it's not the first page, make a Previous link:
    if ($current_page != 1) {
        echo '<a href="ViewSuggestions.php?s=' . ($start - $display) . '&p=' . $pages . '">Previous</a> ';
    }
    // Make all the numbered pages:
    for ($i = 1;$i <= $pages;$i++) {
        if ($i != $current_page) {
            echo '<a href="ViewSuggestions.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '">' . $i . '</a> ';
        } else {
            echo $i . ' ';
        }
    } // End of FOR loop.
    // If it's not the last page, make a Next button:
    if ($current_page != $pages) {
        echo '<a href="ViewSuggestions.php?s=' . ($start + $display) . '&p=' . $pages . '">Next</a>';
    }
    echo '</p></div>'; // Close the paragraph.
    
}
?>
    
<?php
include ('../includes/footer.php');
?>
