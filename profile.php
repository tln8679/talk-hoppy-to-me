<?php
    $page_title = 'You, yum!';
	// Include header html here
    include('includes/header.php');
?>
<!-- Page Container -->
<div class="w3-content w3-margin-top" style="max-width:1400px;">

  <!-- The Grid -->
  <div class="w3-row-padding">

    <!-- Left Column -->
    <div class="w3-third">

      <div class="w3-white w3-text-grey w3-card-4 w3-margin-bottom">
        <div class="w3-display-container">
          <img src="imgs/jane.jpeg" style="width:100%" alt="Avatar">
          <div class="w3-display-bottomleft w3-container w3-text-black">
          </div>
        </div>
        <div class="w3-container">
          <h2>Taylor Noble</h2>
          <p><i class="fa fa-briefcase fa-fw  w3-large w3-text-indigo"></i>Day drinker</p>
          <p><i class="fa fa-home fa-fw  w3-large w3-text-indigo"></i>Wilmington, NC</p>
          <p><i class="fa fa-envelope fa-fw  w3-large w3-text-indigo"></i>tln8679@uncw.edu</p>
          <p><i class="fa fa-phone fa-fw  w3-large w3-text-indigo"></i>1910435534</p>
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
        </div><br>
      </div>


      <!-- End Left Column -->
    </div>

    <!-- Right Column -->
    <div class="w3-twothird">

      <div class="w3-container w3-card w3-white w3-margin-bottom">
        <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-suitcase fa-fw  w3-xxlarge w3-text-indigo"></i>Beers</h2>
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
        <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-certificate fa-fw  w3-xxlarge w3-text-indigo"></i>Favorites</h2>
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
        <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-certificate fa-fw  w3-xxlarge w3-text-indigo"></i>To
          drink list</h2>
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