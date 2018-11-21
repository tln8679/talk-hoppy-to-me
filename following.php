<?php
    $page_title = 'Following!';
	// Include header html here
    include('includes/header.php');
    require_once '../../mysqli_connect.php';
    require_once './beans/user.php';
?>
<!-- Page Container -->
<div class="w3-content w3-margin-top" style="max-width:1400px;">

<?php
    // Number of records to show per page:
    $display = 10;
    // Determine how many pages there are...
    if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
        $pages = $_GET['p'];
    } else { // Need to determine.
        if (isset($_GET['id']) && is_numeric($_GET['id'])) { // Already been determined.
            $current_id = $_GET['id'];
        }
        else {echo '<div class="alert alert-warning" role="alert"><p> Sorry!</p>
            <p class="text-danger">You have reached this page in error.</p></div>';;}
        // Count the number of records:
        $sql = "SELECT COUNT(`USERS_ID`) FROM `USER_FRIENDS` WHERE `USERS_ID`=$current_id";
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

    if (isset($_GET['id']) && is_numeric($_GET['id'])) { // Already been determined.
        $current_id = $_GET['id'];
        $sql = "SELECT USER_FRIENDS.USERS_ID, FRIEND_ID, CONCAT(USERS.FIRST_NAME,' ' ,USERS.LAST_NAME) AS FriendName, USERS.PHONE,USERS.EMAIL,CONCAT(USERS.CITY,', ' ,USERS.STATE) AS Location\n"
            . "FROM `USER_FRIENDS`\n"
            . "JOIN USERS on USER_FRIENDS.FRIEND_ID = USERS.USERS_ID\n"
            . "WHERE USER_FRIENDS.USERS_ID = $current_id \n"
            . "ORDER BY USERS.FIRST_NAME LIMIT $start,$display";
            $r = mysqli_query($dbc, $sql);
            if(mysqli_num_rows($r)>0){ // user found
              while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                $id = $row['FRIEND_ID'];
                $friendName = $row['FriendName'];
                $location = $row['Location'];
                $email = $row['EMAIL'];
                $phone = $row['PHONE'];
                // <!-- The Grid -->
                echo "<div class=\"w3-row-padding\">
                        <div class=\"w3-container w3-card w3-white w3-margin-bottom\">
                                <h2 class=\"w3-text-grey w3-padding-16\"><i class=\"fa fa-suitcase fa-fw w3-xxlarge w3-text-indigo\">$friendName</i></h2>
                                <div class=\"w3-container\">
                                    <h5><b><span class=\"w3-opacity\">Location: </span><span class=\"w3-text-amber\">$location</span></b></h5>
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
            else { // user isnt following anyone
              echo '<div class="alert alert-warning" role="alert"><p> Sorry!</p>
                   <p class="text-danger"><a href="UserSearch.php">Search users to follow.</a></p></div>';
            }
        }
?>
    
  <!-- End Grid -->
</div>
  
  <!-- End Page Container -->
</div>
<?php
  // Make the links to other pages, if necessary.
  if ($pages > 1) {
    echo '<div class="container alert alert-info w3-margin-top" role="alert">';
    echo '<p>';
    // Determine what page the script is on:
    $current_page = ($start/$display) + 1;
    // If it's not the first page, make a Previous link:
    if ($current_page != 1) {
      echo '<a href="log.php?s=' . ($start - $display) . '&p=' . $pages . '">Previous</a> ';
    }
    // Make all the numbered pages:
    for ($i = 1; $i <= $pages; $i++) {
      if ($i != $current_page) {
          echo '<a href="log.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '">' . $i . '</a> ';
      } 
      else {
        echo $i . ' ';
     }
    } // End of FOR loop.
    // If it's not the last page, make a Next button:
    if ($current_page != $pages) {
      echo '<a href="log.php?s=' . ($start + $display) . '&p=' . $pages . '">Next</a>';
    }
    echo '</p>'; // Close the paragraph.
    echo '</div>';
    }
  include('includes/footer.php');
?>