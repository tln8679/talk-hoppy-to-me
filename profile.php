<?php
    $page_title = 'You, yum!';
	// Include header html here
    include('includes/header.php');
    require_once '../../mysqli_connect.php';
    require_once './beans/user.php';
    
    //If we are viewing someone elses page 
    // We will link all friends an href like http://satoshi.cis.uncw.edu/~tln8679/talkhoppytome/profile.php?id=40 to view their profile
    if (isset($_GET['id']) && is_numeric($_GET['id'])) { // Already been determined.
      $sql = "SELECT `FIRST_NAME`,`LAST_NAME`,`AVATAR`,`EMAIL`,`PHONE`,`CITY`,`STATE` FROM `USERS` WHERE `USERS_ID` =". $_GET['id'];
      $result = mysqli_query($dbc, $sql);
      if(mysqli_num_rows($result)==1){ //email found
        $row = 	mysqli_fetch_array($result, MYSQLI_ASSOC);
        if ($password == password_verify($password, $row['pw'])) { //passwords match
          $firstName = $row['FIRST_NAME'];
          $lastName = $row['LAST_NAME'];
          $avatar = $row['AVATAR'];
          $email = $row['EMAIL'];
          $phone = $row['PHONE'];
          $city = $row['CITY'];
          $state = $row['STATE'];
          $current_user = new User ($firstName,$lastName,$avatar,$email,$phone,$city,$state,0);
        }
      }
    }
    else if (isset($_SESSION['email'])){
      $current_user = new User ($_SESSION['firstName'],$_SESSION['lastName'],$_SESSION['avatar'],$_SESSION['email'],$_SESSION['phone'],$_SESSION['city'],$_SESSION['state'],$_SESSION['admin']);
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
          <p><i class="fa fa-briefcase fa-fw  w3-large w3-text-indigo"></i>Day drinker</p>
          <p><i class="fa fa-home fa-fw  w3-large w3-text-indigo"></i><?php echo $current_user->getCity().", ".$current_user->getState();?></p>
          <p><i class="fa fa-envelope fa-fw  w3-large w3-text-indigo"></i><?php echo $current_user->getEmail();?></p>
          <p><i class="fa fa-phone fa-fw  w3-large w3-text-indigo"></i><?php echo $current_user->getPhoneNumber();?></p>
          <hr>

          <p class="w3-large"><b><i class="fa fa-asterisk fa-fw  w3-text-indigo"></i>Favorite Styles</b></p>
          <p>Stouts</p>
          <div class="w3-light-grey w3-round-xlarge w3-small">
            <div class="w3-container w3-center w3-round-xlarge w3-indigo" style="width:60%">60%</div>
          </div>
          <p>American Pale Ales</p>
          <div class="w3-light-grey w3-round-xlarge w3-small">
            <div class="w3-container w3-center w3-round-xlarge w3-indigo" style="width:25%">
              <div class="w3-center w3-text-white">25%</div>
            </div>
          </div>
          <p>Kolsch</p>
          <div class="w3-light-grey w3-round-xlarge w3-small">
            <div class="w3-container w3-center w3-round-xlarge w3-indigo" style="width:10%">10%</div>
          </div>
          <p>Sours</p>
          <div class="w3-light-grey w3-round-xlarge w3-small">
            <div class="w3-container w3-center w3-round-xlarge w3-indigo" style="width:5%">5%</div>
          </div>

          <hr>

          <p class="w3-large"><b><i class="fa fa-asterisk fa-fw  w3-text-indigo"></i>Friends</b></p>
          <p><i class="fa fa-briefcase fa-fw  w3-large w3-text-indigo"></i>Top 3 with most beers logged</p>
          <p><i class="fa fa-home fa-fw  w3-large w3-text-indigo"></i>Link to all friends</p>
          <p><i class="fa fa-envelope fa-fw  w3-large w3-text-indigo"></i>Add friends</p>
        </div>
      </div>


      <!-- End Left Column -->
    </div>

    <!-- Right Column -->
    <div class="w3-twothird">

      <div class="w3-container w3-card w3-white w3-margin-bottom">
        <h2 class="w3-text-grey w3-padding-16">
          <i class="fa fa-suitcase fa-fw  w3-xxlarge w3-text-indigo"></i>
          <span style="color:goldenrod;" class="glyphicon glyphicon-list">
          </span> 
          <a href="log.php">Logged</a>
        </h2>
        <div class="w3-container">
          <h6 class="w3-text-indigo"><i class="fa fa-calendar fa-fw "></i>October 2018</span></h6>
          <h5 class="w3-opacity"><b>Miller Lite by $beer->get_maker();</b></h5>
          <p><b><span class="w3-opacity">Global rating: </span><span class="w3-text-amber">6/10</span></b></p>
          <p><b><span class="w3-opacity">I rate this a: </span><span class="w3-text-indigo">7/10</span></b></p>
          <p>Solid American Brew.</p>
          <hr>
        </div>
        <div class="w3-container">
          <h6 class="w3-text-indigo"><i class="fa fa-calendar fa-fw "></i>Mar 2012</h6>
          <h5 class="w3-opacity"><b>Michelob Ultra by $beer->get_maker();</b></h5>
          <p><b><span class="w3-opacity">Global rating: </span><span class="w3-text-amber">8/10</span></b></p>
          <p><b><span class="w3-opacity">I rate this a: </span><span class="w3-text-indigo">7/10</span></b></p>
          <p>Doesn't give me head aches.</p>
          <hr>
        </div>
        <div class="w3-container">
          <h6 class="w3-text-indigo"><i class="fa fa-calendar fa-fw "></i>July 2018</h6>
          <h5 class="w3-opacity"><b>Spotted Cow by New Glarus</b></h5>
          <p><b><span class="w3-opacity">Global rating: </span><span class="w3-text-amber">10/10</span></b></p>
          <p><b><span class="w3-opacity">I rate this a: </span><span class="w3-text-indigo">10/10</span></b></p>
          <p>Amazing. </p><br>
        </div>
      </div>

      <div class="w3-container w3-card w3-white w3-margin-bottom">
        <h2 class="w3-text-grey w3-padding-16">
        <i class="fa fa-certificate fa-fw  w3-xxlarge w3-text-indigo"></i>
        <span style="color:goldenrod;" class="glyphicon glyphicon-heart"></span> 
        <a href="love.php">Loved</a>
        </h2>
        <div class="w3-container">
          <h6 class="w3-text-indigo"><i class="fa fa-calendar fa-fw "></i>July 2018</h6>
          <h5 class="w3-opacity"><b>Spotted Cow by New Glarus</b></h5>
          <p><b><span class="w3-opacity">Global rating: </span><span class="w3-text-amber">10/10</span></b></p>
          <p><b><span class="w3-opacity">I rate this a: </span><span class="w3-text-indigo">10/10</span></b></p>
          <p>Amazing</p>
          <hr>
        </div>
        <div class="w3-container">
          <h6 class="w3-text-indigo"><i class="fa fa-calendar fa-fw "></i>October 2013</h6>
          <h5 class="w3-opacity"><b>Busch by $beer->get_maker();</b></h5>
          <p><b><span class="w3-opacity">Global rating: </span><span class="w3-text-amber">4/10</span></b></p>
          <p><b><span class="w3-opacity">I rate this a: </span><span class="w3-text-indigo">1/10</span></b></p>
          <p>Watery and cheap</p>
          <hr>
        </div>
        <div class="w3-container">
          <h6 class="w3-text-indigo"><i class="fa fa-calendar fa-fw "></i>Birth</h6>
          <h5 class="w3-opacity"><b>Milwaukee's Best by $beer->get_maker();</b></h5>
          <p><b><span class="w3-opacity">Global rating: </span><span class="w3-text-amber">6/10</span></b></p>
          <p><b><span class="w3-opacity">I rate this a: </span><span class="w3-text-indigo">6/10</span></b></p>
          <p>Best in Milwaukeee</p><br>
        </div>
      </div>

      <div class="w3-container w3-card w3-white">
        <h2 class="w3-text-grey w3-padding-16">
          <i class="fa fa-certificate fa-fw  w3-xxlarge w3-text-indigo"></i>
          <span style="color:goldenrod;" class="glyphicon glyphicon-star"></span> 
          <a href="later.php">Later</a>
        </h2>
        <div class="w3-container">
          <h6 class="w3-text-indigo"><i class="fa fa-calendar fa-fw "></i>July 2018</h6>
          <h5 class="w3-opacity"><b>Two Women by New Glarus</b></h5>
          <p><b><span class="w3-opacity">Global rating: </span><span class="w3-text-amber">10/10</span></b></p>
          <hr>
        </div>
        <div class="w3-container">
          <h6 class="w3-text-indigo"><i class="fa fa-calendar fa-fw "></i>October 2013</h6>
          <h5 class="w3-opacity"><b>Moon Man by New Glarus;</b></h5>
          <p><b><span class="w3-opacity">Global rating: </span><span class="w3-text-amber">4/10</span></b></p>
          <hr>
        </div>
        <div class="w3-container">
          <h6 class="w3-text-indigo"><i class="fa fa-calendar fa-fw "></i>Birth</h6>
          <h5 class="w3-opacity"><b>Beach Trip by Wrightsville Beach Brewery;</b></h5>
          <p><b><span class="w3-opacity">Global rating: </span><span class="w3-text-amber">6/10</span></b></p>
        </div>
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