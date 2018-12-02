<?php
    /* 
    *  This page displays the list of beers a user logs.
    *  The input variables come from BeerSearch.php when the user adds
    *  the beer via one of the buttons.
    */

	$page_title = 'Your Log!';
    include('includes/header.php');
    require_once '../../mysqli_connect.php';
    require_once './beans/user.php';
    // Set current user to whoever's list we are viewing
    if (isset($_GET['id'])){
        $current_id = $_GET['id'];
    }
    // Default list will be the logged in user
    else if (isset($_SESSION['email'])){
        $current_id = $_SESSION['usersID'];
        $current_user = new User ($_SESSION['firstName'],$_SESSION['lastName'],$_SESSION['avatar'],$_SESSION['email'],$_SESSION['phone'],$_SESSION['city'],$_SESSION['state'],$_SESSION['admin']);
    }
    else {
        $url = 'http://'. $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
        $url = rtrim($url, '/\\');
        $page = 'login.php';
        $url .= '/' . $page;
        header("Location: $url");
        exit();
      }
          // Number of records to show per page:
          $display = 8;
          // Determine how many pages there are...
          if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
              $pages = $_GET['p'];
          } else { // Need to determine.
              // Count the number of records:
              $sql = "SELECT COUNT(`USERS_ID`) FROM `USER_LOG` WHERE USERS_ID= $current_id";
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
?>

      <div class="w3-container w3-card w3-white w3-margin-bottom">
        <h2 class="w3-text-grey w3-padding-16">
          <i class="fa fa-suitcase fa-fw  w3-xxlarge w3-text-indigo"></i>
          <span style="color:goldenrod;" class="glyphicon glyphicon-list"> Logged</span> 
        </h2>
        <?php
          // Get the users logged list
          $sql = "SELECT DATE_FORMAT(USER_LOG.LOG_DATE,'%M %D, %Y') AS date, BEER.BEER_NAME AS BeerName, USER_POST.COMMENT AS comment, BREWER.BREWER_NAME AS BrewerName, USER_POST.RATING AS rating ,USER_LOG.BEER_ID as BeerId\n"
          . "FROM USER_LOG\n"
          . "JOIN BEER USING (BEER_ID)\n"
          . "JOIN BREWER USING (BREWER_ID)\n"
          . "INNER JOIN USER_POST ON USER_LOG.BEER_ID = USER_POST.BEER_ID AND USER_LOG.USERS_ID=USER_POST.USER_ID\n"
          . "WHERE USER_LOG.USERS_ID =$current_id\n"
          . "ORDER BY LOG_DATE DESC LIMIT $start,$display";
          $r = mysqli_query($dbc, $sql);
            if(mysqli_num_rows($r)>0){ // worked
              while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                $beer_name = $row['BeerName'];
                $brewer_name = $row['BrewerName'];
                $rating = $row['rating']."/5";
                $comment = $row['comment'];
                $date = $row['date'];
                // Get the beer rating from derivation
                $sub_sql = "SELECT BEER_NAME AS beer, AVG(USER_POST.RATING) AS Rating\n"
                . " FROM `BEER` JOIN USER_POST USING (BEER_ID)\n"
                . " WHERE BEER.BEER_NAME = \"$beer_name \"";
                $sub_stmt = mysqli_query($dbc, $sub_sql);
                while ($sub_record = mysqli_fetch_array($sub_stmt, MYSQLI_ASSOC)) {
                    $global_rating = $sub_record['Rating'];
                }
                if (empty($global_rating)) $global_rating = "0 (No reviews yet)";
                else $global_rating.="/5";
        // Display the variables in the html 
        ?>
        <div class="w3-container">
          <h6 class="w3-text-indigo"><i class="fa fa-calendar fa-fw "></i><?php echo $date; ?></span></h6>
          <h4 class="w3-opacity"><b><a href="BeerSearch.php?options=beer_name&criteria=<?php echo $beer_name; ?>"><?php echo $beer_name; ?></a> by <?php echo $brewer_name; ?></b></h4>
          <p><b><span class="w3-opacity">Global rating: </span><span class="w3-text-amber"><?php echo $global_rating; ?></span></b></p>
          <p><b><span class="w3-opacity">I rate this a: </span><span class="w3-text-indigo"><?php echo $rating; ?></span></b></p>
          <p><?php echo $comment; ?></p>
          <hr>
        </div>
        <?php
            }
          }
          else{
            echo '<div class="alert alert-warning" role="alert"><p> Sorry!</p>
            <p class="text-danger">No logged beers.</p></div>';}
// End logged list and then start logged list
        ?>
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
      echo '<a href="log.php?id='.$current_id.'&s=' . ($start - $display) . '&p=' . $pages . '">Previous</a> ';
    }
    // Make all the numbered pages:
    for ($i = 1; $i <= $pages; $i++) {
      if ($i != $current_page) {
          echo '<a href="log.php?id='.$current_id.'&s=' . (($display * ($i - 1))) . '&p=' . $pages . '">' . $i . '</a> ';
      } 
      else {
        echo $i . ' ';
     }
    } // End of FOR loop.
    // If it's not the last page, make a Next button:
    if ($current_page != $pages) {
      echo '<a href="log.php?id='.$current_id.'&s=' . ($start + $display) . '&p=' . $pages . '">Next</a>';
    }
    echo '</p>'; // Close the paragraph.
    echo '</div>';
    }
  include('includes/footer.php');
?>