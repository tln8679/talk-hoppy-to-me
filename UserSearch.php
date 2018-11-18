<?php
    /* 
    *  This page displays all users and will have a search function.
    */

    $page_title = 'Beers, yum!';
    include('includes/header.php');
    include("beans/beer.php");
    require_once '../../mysqli_connect.php';
    ini_set('display_errors', 'On'); 
    error_reporting(E_ALL); 
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
    // If the user is following the inputted friend id then return true
    // mysqli requires you pass the connection in as a parameter
    function isFollowing ($user_id,$friend_id,$dbc){
        $sql = "SELECT * \n"
        . "FROM `USER_FRIENDS` \n"
        . "WHERE `USERS_ID`=$user_id and `FRIEND_ID`=$friend_id";
        $r = mysqli_query($dbc, $sql);
        $row_cnt = $r->num_rows;
        if(mysqli_num_rows($r)>0){
            return TRUE;
        }
        else return FALSE;
    }
?>
<!-- Search form -->
<div class="col-md-4 col-md-offset-4 w3-margin-bottom text-center">
    <form method="GET" action="UserSearch.php" class="justify-content-center">
        <fieldset>
            <legend>
                <h2>Search User</h2>
            </legend>
            <div class="form-group">
                <div class="input-group w3-margin-bottom cntr-form">
                    <input type="text" name="criteria" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                        <input type="submit" name="name" value="Go!" class="btn btn-primary">
                    </span>
                </div>
                    <!-- /input-group --> 
            </div>
        </fieldset>
    </form> 
</div>

<div class="container">
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
            $pages = ceil ($records/$display);
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
    }
    else {
        $sql = "SELECT USERS.USERS_ID, CONCAT(USERS.FIRST_NAME,' ' ,USERS.LAST_NAME) AS FriendName, USERS.PHONE,USERS.EMAIL,CONCAT(USERS.CITY,', ' ,USERS.STATE) AS Location\n"
            . "FROM `USERS`\n"
            . "ORDER BY USERS.FIRST_NAME ASC LIMIT $start,$display";
    }
    $r = mysqli_query($dbc, $sql);
    if(mysqli_num_rows($r)>0){ // user found
      while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        $id = $row['USERS_ID'];
        if (isFollowing($_SESSION['usersID'],$id,$dbc)){
           $following = TRUE;
        }
        else $following = FALSE;
        $friendName = $row['FriendName'];
        $location = $row['Location'];
        $email = $row['EMAIL'];
        $phone = $row['PHONE'];
        // <!-- The Grid -->
            echo "<div class=\"w3-row-padding\">
                <div class=\"w3-container w3-card w3-white w3-margin-bottom\">
                        <h2 class=\"w3-text-grey w3-padding-16\"><i class=\"fa fa-suitcase fa-fw w3-xxlarge w3-text-indigo\">$friendName</i></h2>
                        <div class=\"w3-container\">";
                        // If following echo following, else echo hidden form to follow
                        if(!$following){
                            echo
                            "<h4> 
                                <div class=\"w3-text-indigo\">
                                <form method=\"POST\" action=\"#INSERTfollower\">
                                    <input type=\"hidden\" name=\"userID\" value=\"$id\">
                                    <input type=\"hidden\" name=\"friendName\" value=\"$friendName\">
                                    <label for=\"$friendName\">Click To Follow</label>
                                    <button id=\"$friendName\" type=\"submit\" class=\"btn btn-link btn-lg\">
                                        <span style=\"color:goldenrod;\" class=\"glyphicon glyphicon-plus\"></span>
                                    </button>
                                </form>
                                </div>
                            </h4>";
                        }
                        else{
                            echo
                            "
                            <h4 class=\"w3-text-indigo\">
                                Following
                                <span style=\"color:goldenrod;\" class=\"glyphicon glyphicon-ok\"></span>
                            </h4>
                            ";
                        }

                        echo "<h5><b><span class=\"w3-opacity\">Location: </span><span class=\"w3-text-amber\">$location</span></b></h5>
                            <h5><b><span class=\"w3-opacity\">Phone: </span><span class=\"w3-text-amber\">$phone</span></b></h5>
                            <h5><b><span class=\"w3-opacity\">Email: </span><span class=\"w3-text-amber\">$email</span></b></h5>
                            <h4 class=\"w3-text-blue\"><i class=\"fa fa-calendar fa-fw \">"
                                . '<a href="profile.php?id=' . $id . '">View ' . $friendName . '\'s Profile</a>' ."</i>
                                <span style=\"color:DarkGoldenRod;\" class=\"glyphicon glyphicon-eye-open\"></span>
                            </h4>
                            <hr>
                        </div>
                </div>
            </div>";
          }
    }
    else { // No user found
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
    <div class="container alert alert-info w3-margin-top" role="alert">
        <?php
        // Make the links to other pages, if necessary.
        if ($pages > 1) {
            echo '<p>';
            // Determine what page the script is on:
            $current_page = ($start/$display) + 1;
            // If it's not the first page, make a Previous link:
            if ($current_page != 1) {
                echo '<a href="UserSearch.php?s=' . ($start - $display) . '&p=' . $pages . '">Previous</a> ';
            }
            // Make all the numbered pages:
            for ($i = 1; $i <= $pages; $i++) {
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
            echo '</p>'; // Close the paragraph.
        }
        ?>
    </div>

        <script>
    function showMore(show_description) {
            show_description = show_description.toString();
            if (document.getElementById(show_description).style.display === "none") {
                // Change to hide
                document.getElementById('link').innerHTML = "Hide description...";
                // Show beer desciption
                document.getElementById(show_description).style.display = "block";
            }
            else {
                // back to original
                document.getElementById('link').innerHTML = "Show description...";
                document.getElementById(show_description).style.display = "none";
            }
        }
</script>

<?php
    include('includes/footer.php');
?>