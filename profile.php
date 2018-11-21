<?php
    $page_title = 'You, yum!';
	// Include header html here
    include('includes/header.php');
    require_once '../../mysqli_connect.php';
    require_once './beans/user.php';
    ini_set('display_errors', 'On'); 
    error_reporting(E_ALL); 
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
    //If we are viewing someone elses page 
    // We will link all friends an href like http://satoshi.cis.uncw.edu/~tln8679/talkhoppytome/profile.php?id=40 to view their profile
    if (isset($_GET['id']) && is_numeric($_GET['id'])) { // Already been determined.
      $current_id = $_GET['id'];
      $sql = "SELECT `FIRST_NAME`,`LAST_NAME`,`AVATAR`,`EMAIL`,`PHONE`,`CITY`,`STATE` FROM `USERS` WHERE `USERS_ID` =". $current_id;
      $result = mysqli_query($dbc, $sql);
      if(mysqli_num_rows($result)==1){ // user found
        $row = 	mysqli_fetch_array($result, MYSQLI_ASSOC);
        $firstName = $row['FIRST_NAME'];
        $lastName = $row['LAST_NAME'];
        $avatar = $row['AVATAR'];
        $email = $row['EMAIL'];
        $phone = $row['PHONE'];
        $city = $row['CITY'];
        $state = $row['STATE'];
        $current_user = new User ($firstName,$lastName,$avatar,$email,$phone,$city,$state,0);
      }
      else { // user doesn't exist
        echo '<div class="alert alert-warning" role="alert"><p> Sorry!</p>
             <p class="text-danger">Oops! This user does not exist.</p></div>';}
      }
    else if (isset($_SESSION['email'])){
      $current_id = $_SESSION['usersID'];
      $current_user = new User ($_SESSION['firstName'],$_SESSION['lastName'],$_SESSION['avatar'],$_SESSION['email'],$_SESSION['phone'],$_SESSION['city'],$_SESSION['state'],$_SESSION['admin']);
    }
    // User hasn't logged in and clicked "My profile", so send him to log in page
    else {
      $url = 'http://'. $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
      $url = rtrim($url, '/\\');
      $page = 'login.php';
      $url .= '/' . $page;
      header("Location: $url");
      exit();
    }
?>
<!-- Page Container -->
<div class="w3-content w3-margin-top" style="max-width:1400px;">

  <!-- The Grid -->
  <div class="w3-row-padding">

    <!-- Left Column -->
    <div class="w3-third">

      <div class="w3-white w3-text-grey w3-card-4 w3-margin-bottom">
        <div class="w3-display-container">
          <?php $avatar_path = $current_user->getAvatar();?>
          <img src="<?php echo dirname($_SERVER['PHP_SELF'])."/".$avatar_path ?>" style="width:100%" alt="Avatar">
          <div class="w3-display-bottomleft w3-container w3-text-black">
          </div>
        </div>
        <div class="w3-container">
          <h2><?php echo $current_user->getFirstName()." ".$current_user->getLastName();?></h2>
          <p>Day drinker</p>
          <p><?php echo $current_user->getCity().", ".$current_user->getState();?></p>
          <p><?php echo $current_user->getEmail();?></p>
          <p><?php echo $current_user->getPhoneNumber();?></p>
          <hr>
          <p class="w3-large"><b>Most Logged Styles</b></p>
          <?php
          // Favorite styles = Most logged style from logged list
            $sql = "SELECT BEER.BEER_STYLE AS BEER_STYLE,COUNT(BEER.BEER_STYLE) AS count, TRUNCATE(count(BEER.BEER_STYLE) * 100.0 / (select count(*) from USER_LOG),0) AS Percent\n"
            . "FROM USER_LOG \n"
            . "JOIN BEER USING (BEER_ID)\n"
            . "WHERE USERS_ID = $current_id\n"
            . "GROUP BY BEER.BEER_STYLE\n"
            . "ORDER BY COUNT(BEER.BEER_STYLE) DESC";
            $r = mysqli_query($dbc, $sql);
            if(mysqli_num_rows($r)>0){ // user found
              $counter = 0;
              while (($row = mysqli_fetch_array($r)) && $counter < 5 ) {
                $style = $row['BEER_STYLE'];
                $num_logged = $row['count'];
                $percent = $row['Percent'];
                $counter++;
          ?>
            <p><?php echo $style.' ('.$num_logged.')'; ?></p>
            <div class="w3-light-grey w3-round-xlarge w3-small">
              <div class="w3-container w3-center w3-round-xlarge w3-indigo" style="width:<?php echo $percent; ?>%"><?php echo $percent; ?>%</div>
            </div>
          <?php
              }
            }
            else{
              echo '<div class="alert alert-warning" role="alert"><p> Sorry!</p>
            <p class="text-danger">No logged beers.<a href="BeerSearch.php">Click to search!</a></p></div>';
            }
          ?>
          <hr>
          <p class="w3-large"><b>Following</b></p>
          <?php
            $sql = "SELECT USER_FRIENDS.USERS_ID, FRIEND_ID, CONCAT(USERS.FIRST_NAME,' ' ,USERS.LAST_NAME) AS FriendName \n"
            . "FROM `USER_FRIENDS`\n"
            . "JOIN USERS on USER_FRIENDS.FRIEND_ID = USERS.USERS_ID\n"
            . "WHERE USER_FRIENDS.USERS_ID = $current_id \n"
            . "ORDER BY USERS.FIRST_NAME\n"
            . "ASC LIMIT 3";
            $r = mysqli_query($dbc, $sql);
            if(mysqli_num_rows($r)>0){ // user found
              while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                $id = $row['FRIEND_ID'];
                $friendName = $row['FriendName'];
                echo '<p><a href="profile.php?id=' . $id . '">View ' . $friendName . '\'s Profile</a></p> ';
              }
            }
            else { // user isnt following anyone
              echo '<div class="alert alert-warning" role="alert"><p> Sorry!</p>
                   <p class="text-danger">This user is not following anyone.</p></div>';
            }
          ?>
          <h4>
            <a href="following.php?id=<?php echo $current_id?>">View all follwing</a>
            <span style="color:goldenrod;" class="glyphicon glyphicon-eye-open"></span>
          </h4>
          <h4>
            <a href="UserSearch.php">Search all users</a>
            <span style="color:goldenrod;" class="glyphicon glyphicon-plus"></span>
          </h4>
        </div>
      </div>


      <!-- End Left Column -->
    </div>

    <!-- Right Column -->
    <div class="w3-twothird">

      <div class="w3-container w3-card w3-white w3-margin-bottom">
        <h2 class="w3-text-grey w3-padding-16">
          <span style="color:goldenrod;" class="glyphicon glyphicon-list">
          </span> 
          <a href="log.php">Logged</a>
        </h2>
        <?php
          // Get the users logged list
          $sql = "SELECT DATE_FORMAT(USER_LOG.LOG_DATE,'%M %D, %Y') AS date, BEER.BEER_NAME AS BeerName, USER_POST.COMMENT AS comment, BREWER.BREWER_NAME AS BrewerName, USER_POST.RATING AS rating ,USER_LOG.BEER_ID as BeerId, LOG_DATE\n"
          . "FROM USER_LOG\n"
          . "JOIN BEER USING (BEER_ID)\n"
          . "JOIN BREWER USING (BREWER_ID)\n"
          . "INNER JOIN USER_POST ON USER_LOG.BEER_ID = USER_POST.BEER_ID AND USER_LOG.USERS_ID=USER_POST.USER_ID\n"
          . "WHERE USER_LOG.USERS_ID =$current_id\n"
          . "ORDER BY LOG_DATE DESC LIMIT 3";
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
          <h6 class="w3-text-indigo"><?php echo $date; ?></h6>
          <h4 class="w3-opacity"><b><?php echo $beer_name; ?> by <?php echo $brewer_name; ?></b></h4>
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
            <p class="text-danger">No logged beers.<a href="BeerSearch.php">Click to search!</a></p></div>';}
// End logged list and then start loved list
        ?>
        <div class="w3-container">
          <h3 class="w3-text-indigo"><i class="fa fa-calendar fa-fw "><a href="log.php">View all</a></i></h3>
          <hr>
        </div>
      </div>

      <div class="w3-container w3-card w3-white w3-margin-bottom">
        <h2 class="w3-text-grey w3-padding-16">
        
        <span style="color:goldenrod;" class="glyphicon glyphicon-heart"></span> 
        <a href="love.php">Loved</a>
        </h2>
        <?php
          unset($sql);
          unset($r);
          unset($sub_sql);
          // Get the users logged list
          $sql = "SELECT DATE_FORMAT(USER_LOVE.LOVE_DATE,'%M %D, %Y') AS date, BEER.BEER_NAME AS BeerName, BREWER.BREWER_NAME AS BrewerName, USER_LOVE.BEER_ID as BeerId FROM USER_LOVE JOIN BEER USING (BEER_ID) JOIN BREWER USING (BREWER_ID) WHERE USER_LOVE.USERS_ID = $current_id ORDER BY LOVE_DATE DESC LIMIT 3";
          $r = mysqli_query($dbc, $sql);
            if(mysqli_num_rows($r)>0){ // worked
              while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                $beer_name = $row['BeerName'];
                $brewer_name = $row['BrewerName'];
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
          <h6 class="w3-text-indigo"><?php echo $date; ?></h6>
          <h4 class="w3-opacity"><b><?php echo $beer_name; ?> by <?php echo $brewer_name; ?></b></h4>
          <p><b><span class="w3-opacity">Global rating: </span><span class="w3-text-amber"><?php echo $global_rating; ?></span></b></p>
          <hr>
        </div>
        <?php
            }
          }
          else{
            echo '<div class="alert alert-warning" role="alert"><p> Sorry!</p>
            <p class="text-danger">No loved beers. <a href="BeerSearch.php">Click to search!</a></p></div>';}
// End loved list and then start later list
        ?>
        <div class="w3-container">
          <h3 class="w3-text-indigo"><i class="fa fa-calendar fa-fw "><a href="love.php">View all</a></i></h3>
          <hr>
        </div>
      </div>


      <div class="w3-container w3-card w3-white">
        <h2 class="w3-text-grey w3-padding-16">
          
          <span style="color:goldenrod;" class="glyphicon glyphicon-star"></span> 
          <a href="later.php">Later</a>
        </h2>
        <?php
          // Get the users loved list
          $sql = "SELECT DATE_FORMAT(USER_LATER.LATER_DATE,'%M %D, %Y') AS date, BEER.BEER_NAME AS BeerName, BREWER.BREWER_NAME AS BrewerName,USER_LATER.BEER_ID as BeerId\n"
          . "FROM USER_LATER\n"
          . "JOIN BEER USING (BEER_ID)\n"
          . "JOIN BREWER USING (BREWER_ID)\n"
          . "WHERE USER_LATER.USERS_ID =$current_id\n"
          . "ORDER BY LATER_DATE DESC LIMIT 3";
          $r = mysqli_query($dbc, $sql);
            if(mysqli_num_rows($r)>0){ // worked
              while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                $beer_name = $row['BeerName'];
                $brewer_name = $row['BrewerName'];
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
          <h6 class="w3-text-indigo"><?php echo $date; ?></h6>
          <h4 class="w3-opacity"><b><?php echo $beer_name; ?> by <?php echo $brewer_name; ?></b></h4>
          <p><b><span class="w3-opacity">Global rating: </span><span class="w3-text-amber"><?php echo $global_rating; ?></span></b></p>
          <hr>
        </div>
        <?php
            }
          }
          else{
            echo '<div class="alert alert-warning" role="alert"><p> Sorry!</p>
            <p class="text-danger">No beers on your wish list. <a href="BeerSearch.php">Click to search!</a></p></div>';}
// End later list
        ?>
        <div class="w3-container">
          <h3 class="w3-text-indigo"><i class="fa fa-calendar fa-fw "><a href="later.php">View all</a></i></h3>
          <hr>
        </div>
      <!-- End Right Column -->
    </div>

    <!-- End Grid -->
  </div>

  <!-- End Page Container -->
</div>
<?php
    include('includes/footer.php');
?>