<?php
    $page_title = 'Your feed, yum!';
	// Include header html here
    include('includes/header.php');
    require_once '../../mysqli_connect.php';
    require_once './beans/user.php';
    ini_set('display_errors', 'On'); 
    error_reporting(E_ALL); 
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if (isset($_SESSION['email'])){
      $current_id = $_SESSION['usersID'];
      $current_user = new User ($_SESSION['firstName'],$_SESSION['lastName'],$_SESSION['avatar'],$_SESSION['email'],$_SESSION['phone'],$_SESSION['city'],$_SESSION['state'],$_SESSION['admin']);
    }

    // User has chosen to view only their friends and they are logged in
    if(isset($_GET['view'])){
      $sql = "SELECT `USER_ID`, `RATING`, `COMMENT`, CONCAT(USERS.FIRST_NAME, ' ', USERS.LAST_NAME) AS poster_name, DATE_FORMAT(`POST_DATE`,'%M %d, %y') AS DATE,BEER.BEER_NAME,BREWER.BREWER_NAME, USER_FRIENDS.FRIEND_ID\n"
      . "FROM `USER_POST` \n"
      . "INNER JOIN USERS ON USER_POST.USER_ID = USERS.USERS_ID\n"
      . "INNER JOIN BEER ON USER_POST.BEER_ID = BEER.BEER_ID\n"
      . "INNER JOIN BREWER ON BREWER.BREWER_ID = BEER.BEER_ID\n"
      . "INNER JOIN USER_FRIENDS ON USER_POST.USER_ID = USER_FRIENDS.USERS_ID\n"
      . "WHERE USER_FRIENDS.FRIEND_ID = $current_id\n"
      . "ORDER BY POST_DATE DESC";
    }
?>
<!-- Page Container -->
<div class="w3-content w3-margin-top" style="max-width:1400px;">
  <!-- The Grid -->
  <div class="w3-row-padding">
    
    <div class="w3-container w3-margin-bottom">
      <div class="form-group w3-margin-bottom" style="text-align: center;">
        <label> Switch Feed:</label>  
        <br>
        <?php 
        // logged in and in global view
          if (isset($current_id) && empty($_GET['view'])){ 
            echo "<a href=\"feed.php?view=$current_id\" class=\"btn btn-primary\" role=\"button\">Friends only</a>";
          } 
          // logged in and on friend view
          else if(isset($current_id) && isset($_GET['view'])){
            echo "<a href=\"feed.php\" class=\"btn btn-primary\" role=\"button\">Global view</a>";
          }
          // not logged in
          else echo "<a href=\"login.php\" class=\"btn btn-primary\" role=\"button\">Friends only</a>";
        ?>
      </div>
    </div>
    
<?php
  if (empty($sql)){
    // Global query if not in friend view
    $sql = "SELECT `USER_ID`, `RATING`, `COMMENT`, CONCAT(USERS.FIRST_NAME, ' ', USERS.LAST_NAME) AS poster_name, DATE_FORMAT(`POST_DATE`,'%M %d, %y') AS DATE,BEER.BEER_NAME,BREWER.BREWER_NAME\n"
      . "FROM `USER_POST` \n"
      . "INNER JOIN USERS ON USER_POST.USER_ID = USERS.USERS_ID\n"
      . "INNER JOIN BEER ON USER_POST.BEER_ID = BEER.BEER_ID\n"
      . "INNER JOIN BREWER ON BREWER.BREWER_ID = BEER.BEER_ID \n"
      . "ORDER BY POST_DATE DESC";
  }
  $r = mysqli_query($dbc, $sql);

  // paginate variables
  $count = mysqli_num_rows($r);
  // Number of records to show per page:
  $display = 8;
  // Determine how many pages there are...
  if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
      $pages = $_GET['p'];
  } else { // Need to determine.
      // Count the number of records:
      $records = $count;
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
  // Execute the statement with the added pagination
  // Space is needed to seperate "ASC" from "LIMIT"
  $sql = $sql . " LIMIT $start,$display";
  $r = mysqli_query($dbc, $sql);
  if(mysqli_num_rows($r)>0){ // worked
  while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
    $poster_name = $row['poster_name'];
    $beer_name = $row['BEER_NAME'];
    $rating = $row['RATING'];
    $comment = $row['COMMENT'];
    $post_date = $row['DATE'];
    $brewer = $row['BREWER_NAME'];
    $comment = $row['COMMENT'];
    $u_id = $row['USER_ID'];
?>
      <div class="w3-container w3-card w3-white w3-margin-bottom">
          <h2 class="w3-text-grey w3-padding-16"><a href="profile.php?id=<?php echo $u_id; ?>"> <?php echo  $poster_name; ?></a></h2>
          <div class="w3-container">
            <h6 class="w3-text-blue"><?php echo  $post_date; ?></h6>
            <h5><span class="w3-text-amber">My rating: </span><span class="w3-text-indigo"><b><?php echo  $rating; ?></b></span></h5>
            <h5><span class="w3-text-amber" ><b>Name: </b></span><span class="w3-text-indigo"><?php echo  $beer_name ?></span></h5>
            <h5> <span class="w3-text-amber" ><b>Brewer: </b></span><span class="w3-text-indigo"><?php echo  $brewer ?></span></h5>
            <p><?php echo  $comment ?></p>
            <?php 
              echo 
              '<h4><a href="profile.php?id=' . $u_id . '"><span style="color:DarkGoldenRod;" class="glyphicon glyphicon-eye-open"></span>
              View ' . $poster_name . '\'s Profile</a></h4>'; ?>
            <hr>
          </div>
      </div>
<?php
    }
  }
?>

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
    if (empty($_GET['view'])){
      // If it's not the first page, make a Previous link:
      if ($current_page != 1) {
        echo '<a href="feed.php?s=' . ($start - $display) . '&p=' . $pages . '">Previous</a> ';
      }
      // Make all the numbered pages:
      for ($i = 1; $i <= $pages; $i++) {
        if ($i != $current_page) {
            echo '<a href="feed.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '">' . $i . '</a> ';
        } 
        else {
          echo $i . ' ';
      }
      } // End of FOR loop.
      // If it's not the last page, make a Next button:
      if ($current_page != $pages) {
        echo '<a href="feed.php?s=' . ($start + $display) . '&p=' . $pages . '">Next</a>';
      }
    }
    else{
      if ($current_page != 1) {
          echo '<a href="feed.php?s=' . ($start - $display) . '&p=' . $pages . '&view=' . $u_id . '">Previous</a> ';
      }
      // Make all the numbered pages:
      for ($i = 1; $i <= $pages; $i++) {
          if ($i != $current_page) {
              echo '<a href="feed.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&view=' . $u_id . '">' . $i . '</a> ';
          } else {
              echo $i . ' ';
          }
      } // End of FOR loop.
      // If it's not the last page, make a Next button:
      if ($current_page != $pages) {
          echo '<a href="feed.php?s=' . ($start + $display) . '&p=' . $pages . '&view=' . $u_id .'">Next</a>';
      }
    }
    echo '</p>'; // Close the paragraph.
    echo '</div>';
    }
    include('includes/footer.php');
?>