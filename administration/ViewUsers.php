<?php
$page_title = 'View users!';
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
// If the user is following the inputted friend id then return true
// mysqli requires you pass the connection in as a parameter
if (isset($_POST['deleteUser'])) {
    // Using prepared statements so we don't need to sanitize
    $friend_user_id = $_POST['userID'];
    $sql = "DELETE FROM USERS WHERE USERS_ID= $friend_user_id";
    $r = mysqli_query($dbc, $sql);
    echo "<h2>" . " Number of users deleted: " . mysqli_affected_rows($dbc) . "</h2>";
}
if (isset($_POST['makeAdmin'])) {
    echo "This button currently has no functionality";
}
// if(isset($_POST['makeAdmin'])) {
//     // Using prepared statements so we don't need to sanitize
//     $friend_user_id = $_POST['userID'];
//     $sql = "DELETE FROM USERS WHERE USERS_ID= $friend_user_id";
//     $r = mysqli_query($dbc, $sql);
//     echo "<h2>" . " Number of users deleted: " . mysqli_affected_rows($dbc) . "</h2>";
// }

?>


<div class="container">
    <h1 style="text-align: center;">Moderate Users</h1>
    <?php
// Number of records to show per page:
$display = 10;
// Determine how many pages there are...
if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
    $pages = $_GET['p'];
} else { // Need to determine.
    // Count the number of records:
    $sql = "SELECT COUNT(`USERS_ID`) FROM `USERS`";
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
$sql = "SELECT USERS.USERS_ID, CONCAT(USERS.FIRST_NAME,' ' ,USERS.LAST_NAME) AS FriendName, USERS.PHONE,USERS.EMAIL,CONCAT(USERS.CITY,', ' ,USERS.STATE) AS Location\n" . "FROM `USERS`\n" . "ORDER BY USERS.FIRST_NAME ASC LIMIT $start,$display";
$r = mysqli_query($dbc, $sql);
if (mysqli_num_rows($r) > 0) { // user found
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        $id = $row['USERS_ID'];
        // if (isFollowing($_SESSION['usersID'],$id,$dbc)){
        //    $following = TRUE;
        // }
        // else $following = FALSE;
        $otherUser = $row['FriendName'];
        $location = $row['Location'];
        $email = $row['EMAIL'];
        $phone = $row['PHONE'];
        // <!-- The Grid -->
        echo "<div class=\"w3-row-padding\">
                <div class=\"w3-container w3-card w3-white w3-margin-bottom\">
                        <h2 class=\"w3-text-grey w3-padding-16\"><i class=\"fa fa-suitcase fa-fw w3-xxlarge w3-text-indigo\">$otherUser</i></h2>
                        <div class=\"w3-container\"><hr>";
        // Delete user form
        echo "<div class=\"w3-text-indigo\">
                                <form method=\"POST\" action=\"ViewUsers.php\">
                                    <input type=\"hidden\" name=\"userID\" value=\"$id\">
                                    <label for=\"$id\" style=\"cursor: pointer;\">Click To Delete</label>
                                    <button id=\"$id\" type=\"submit\" name=\"deleteUser\" class=\"btn btn-link btn-lg\">
                                        <span style=\"color:goldenrod;\" class=\"glyphicon glyphicon-remove\"></span>
                                    </button>
                                </form>
                            </div>
                            <hr>";
        //Make a user an admin form
        echo "<div class=\"w3-text-indigo\">
                                <form method=\"POST\" action=\"ViewUsers.php\">
                                    <input type=\"hidden\" name=\"userID\" value=\"$id-2\">
                                    <label for=\"$id-2\" style=\"cursor: pointer;\">Click To Make An Admin</label>
                                    <button id=\"$id-2\" type=\"submit\" name=\"makeAdmin\" class=\"btn btn-link btn-lg\">
                                        <span style=\"color:goldenrod;\" class=\"glyphicon glyphicon-plus\"></span>
                                    </button>
                                </form>
                            </div>
                            <hr>";
        echo "<h5><b><span class=\"w3-opacity\">Location: </span><span class=\"w3-text-amber\">$location</span></b></h5>
                            <h5><b><span class=\"w3-opacity\">Phone: </span><span class=\"w3-text-amber\">$phone</span></b></h5>
                            <h5><b><span class=\"w3-opacity\">Email: </span><span class=\"w3-text-amber\">$email</span></b></h5>
                            <h4 class=\"w3-text-blue\">" . '<a href="profile.php?id=' . $id . '"><i class="fa fa-calendar fa-fw ">View ' . $otherUser . '\'s Profile</i>
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
        echo '<a href="ViewUsers.php?s=' . ($start - $display) . '&p=' . $pages . '">Previous</a> ';
    }
    // Make all the numbered pages:
    for ($i = 1;$i <= $pages;$i++) {
        if ($i != $current_page) {
            echo '<a href="ViewUsers.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '">' . $i . '</a> ';
        } else {
            echo $i . ' ';
        }
    } // End of FOR loop.
    // If it's not the last page, make a Next button:
    if ($current_page != $pages) {
        echo '<a href="ViewUsers.php?s=' . ($start + $display) . '&p=' . $pages . '">Next</a>';
    }
    echo '</p></div>'; // Close the paragraph.
    
}
?>

<?php
include ('../includes/footer.php');
?>
