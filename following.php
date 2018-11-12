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
    if (isset($_GET['id']) && is_numeric($_GET['id'])) { // Already been determined.
        $current_id = $_GET['id'];
        $sql = "SELECT USER_FRIENDS.USERS_ID, FRIEND_ID, CONCAT(USERS.FIRST_NAME,' ' ,USERS.LAST_NAME) AS FriendName, USERS.PHONE,USERS.EMAIL,CONCAT(USERS.CITY,', ' ,USERS.STATE) AS Location\n"
            . "FROM `USER_FRIENDS`\n"
            . "JOIN USERS on USER_FRIENDS.FRIEND_ID = USERS.USERS_ID\n"
            . "WHERE USER_FRIENDS.USERS_ID = $current_id \n"
            . "ORDER BY USERS.FIRST_NAME";
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
                   <p class="text-danger">Search users to follow.</p></div>';
            }
        }
?>
    
  <!-- End Grid -->
</div>
  
  <!-- End Page Container -->
</div>
<?php
    include('includes/footer.php');
?>