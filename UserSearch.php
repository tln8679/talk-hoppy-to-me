<?php
/*
 *  This page displays all users and will have a search function.
*/
require_once 'reg_conn.php';
$page_title = 'Find friends!';
include ('includes/header.php');
include ("beans/beer.php");
require_once '../../mysqli_connect.php';

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
function isFollowing($user_id, $friend_id, $dbc) {
    $sql = "SELECT * \n" . "FROM `USER_FRIENDS` \n" . "WHERE `USERS_ID`=$user_id and `FRIEND_ID`=$friend_id";
    $r = mysqli_query($dbc, $sql);
    $row_cnt = $r->num_rows;
    if (mysqli_num_rows($r) > 0) {
        return TRUE;
    } else return FALSE;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Using prepared statements so we don't need to sanitize
    $curr_user = $_SESSION['usersID'];
    $friend_user_id = $_POST['userID'];
    $friend_name = $_POST['friendName'];
    $sql = "INSERT INTO `USER_FRIENDS`(`USERS_ID`,`FRIEND_ID`)VALUES(?,?)";
    $stmt = mysqli_prepare($dbc, $sql);
    // 'ss' declares the types that we are inserting
    mysqli_stmt_bind_param($stmt, 'ss', $curr_user, $friend_user_id);
    mysqli_stmt_execute($stmt);
    if (mysqli_stmt_affected_rows($stmt)) { //It worked
        echo "<div class=\"alert alert-success\" role=\"alert\">
            <p>You are now following <strong>$friend_name</strong></p>
            </div>";
    } else {
        echo "<div class=\"alert alert-info\" role=\"alert\">
                <p>We're sorry, there was an error trying to follow $friend_name</p>
                </div>";
    }
}
?>


<div class="container">
    <h1 style="text-align: center;">Find new friends</h1>
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
if (isset($_GET['name']) && is_string($_GET['name'])) {
    // This if doesnt make any sense yet
    $current_id = $_GET['id'];
    // Search algorithm
    // $sql = ;
    
} else {
    $sql = "SELECT USERS.USERS_ID, USERS.AVATAR, CONCAT(USERS.FIRST_NAME,' ' ,USERS.LAST_NAME) AS FriendName, USERS.PHONE,USERS.EMAIL,CONCAT(USERS.CITY,', ' ,USERS.STATE) AS Location\n" . "FROM `USERS`\n" . "ORDER BY USERS.FIRST_NAME ASC LIMIT $start,$display";
}
$r = mysqli_query($dbc, $sql);
if (mysqli_num_rows($r) > 0) { // user found
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        $id = $row['USERS_ID'];
        if (isFollowing($_SESSION['usersID'], $id, $dbc)) {
            $following = TRUE;
        } else $following = FALSE;
        $friendName = $row['FriendName'];
        $location = $row['Location'];
        $email = $row['EMAIL'];
        $phone = $row['PHONE'];
        $avatar_path = $row['AVATAR'];
        // <!-- The Grid -->
        echo "<div class=\"w3-row-padding\">
                <div class=\"w3-container w3-card w3-white w3-margin-bottom\">
                        <h2 class=\"w3-text-grey w3-padding-16\"><i class=\"fa fa-suitcase fa-fw w3-xxlarge w3-text-indigo\">$friendName</i></h2>"; ?>
                        <img src="<?php echo dirname($_SERVER['PHP_SELF']) . "/" . $avatar_path ?>" style="width:20%" alt="User's profile pic">
                        <hr>
                        <?php echo "<div class=\"w3-container\">";
        // If following echo following, else echo hidden form to follow
        if (!$following) {
            echo "<div class=\"w3-text-indigo\">
                                <form method=\"POST\" action=\"UserSearch.php\">
                                    <input type=\"hidden\" name=\"userID\" value=\"$id\">
                                    <input type=\"hidden\" name=\"friendName\" value=\"$friendName\">
                                    <label for=\"$id\" style=\"cursor: pointer;\">Click To Follow</label>
                                    <button id=\"$id\" type=\"submit\" class=\"btn btn-link btn-lg\">
                                        <span style=\"color:goldenrod;\" class=\"glyphicon glyphicon-plus\"></span>
                                    </button>
                                </form>
                                </div>";
        } else {
            echo "
                            <h4 class=\"w3-text-indigo\">
                                Following
                                <span style=\"color:goldenrod;\" class=\"glyphicon glyphicon-ok\"></span>
                            </h4>
                            ";
        }
        echo "<h5><b><span class=\"w3-opacity\">Location: </span><span class=\"w3-text-amber\">$location</span></b></h5>
                            <h5><b><span class=\"w3-opacity\">Phone: </span><span class=\"w3-text-amber\">$phone</span></b></h5>
                            <h5><b><span class=\"w3-opacity\">Email: </span><span class=\"w3-text-amber\">$email</span></b></h5>
                            <h4 class=\"w3-text-blue\">" . '<a href="profile.php?id=' . $id . '"><i class="fa fa-calendar fa-fw">View ' . $friendName . '\'s Profile</i>
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
    echo '<div class="container alert alert-info w3-margin-top" role="alert"><p>';
    // Determine what page the script is on:
    $current_page = ($start / $display) + 1;
    // If it's not the first page, make a Previous link:
    if ($current_page != 1) {
        echo '<a href="UserSearch.php?s=' . ($start - $display) . '&p=' . $pages . '">Previous</a> ';
    }
    // Make all the numbered pages:
    for ($i = 1;$i <= $pages;$i++) {
        if ($i != $current_page) {
            echo '<a href="UserSearch.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '">' . $i . '</a> ';
        } else {
            echo $i . ' ';
        }
    } // End of FOR loop.
    // If it's not the last page, make a Next button:
    if ($current_page != $pages) {
        echo '<a href="UserSearch.php?s=' . ($start + $display) . '&p=' . $pages . '">Next</a>';
    }
    echo '</p></div>'; // Close the paragraph.
    
}
?>
<?php
include ('includes/footer.php');
?>