<?php
    $page_title = 'Your feed, yum!';
	// Include header html here
    include('includes/header.html');
?>
<!-- Page Container -->
<div class="w3-content w3-margin-top" style="max-width:1400px;">

  <!-- The Grid -->
  <div class="w3-row-padding">
  <div class="w3-container w3-card w3-white w3-margin-bottom">
        <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-suitcase fa-fw w3-xxlarge w3-text-blue"></i>Jane Doe</h2>
        <div class="w3-container">
          <h6 class="w3-text-blue"><i class="fa fa-calendar fa-fw "></i>October 2018</span></h6>
          <h5><b><span class="w3-opacity">Global rating: </span><span class="w3-text-amber">6/10</span></b></h5>
          <h5><b><span class="w3-opacity">My rating: </span><span class="w3-text-indigo">6/10</span></b></h5>
          <h5 class="w3-opacity"><b>Name: Miller Lite</b></h5>
          <h5 class="w3-opacity"><b>Brewer: </b></h5>
          <p>Solid American Brew. One of my favorites of all time!</p>
          <hr>
        </div>
    </div>

      <div class="w3-container w3-card w3-white">
        <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-certificate fa-fw w3-xxlarge w3-text-blue"></i>Jacob Thomas</h2>
        <div class="w3-container">
          <h6 class="w3-text-blue"><i class="fa fa-calendar "></i>July 2018</h6>
          <h5><b><span class="w3-opacity">Global rating: </span><span class="w3-text-amber">6/10</span></b></h5>
          <h5><b><span class="w3-opacity">My rating: </span><span class="w3-text-indigo">6/10</span></b></h5>
          <h5 class="w3-opacity"><b>Name: New Glarus Spotted Cow</b></h5>
          <h5 class="w3-opacity"><b>Brewer: </b></h5>
          <p>Amazing beer! Will get again!</p>
          <hr>
        </div>
      </div>

    <!-- End Right Column -->
    </div>
    
  <!-- End Grid -->
  </div>
  
  <!-- End Page Container -->
</div>
<?php
    include('includes/footer.html');
?>