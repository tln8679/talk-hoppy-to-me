<?php
require_once 'secure_conn.php';
$page_title = 'Beer, yum!'; // Include header html here
include ('includes/header.php'); ?>

<div class="page-header"><h1>What are you drinking tonight?</h1></div>

<!-- Right-aligned media object -->
<div class="media">
  <div class="media-body">
    <h4 class="media-heading">
      Don't drink alone when you can drink with friends!
    </h4>
    <ul class="list-unstyled">
      <li class="media">
        <img class="media-object" src="imgs/fans.png" alt="friends" />
        <div class="media-body">
          <h5 class="mt-0 mb-1">
            Follow your friends on their beer-adventures!
          </h5>
        </div>
      </li>
      <li class="media my-4">
        <img class="media-object" src="imgs/rating.png" alt="rate" />
        <div class="media-body">
          <h5 class="mt-0 mb-1">Log and rank your favorite brews!</h5>
        </div>
      </li>
      <li class="media">
        <img class="media-object" src="imgs/to-do.png" alt="compete" />
        <div class="media-body">
          <h5 class="mt-0 mb-1">
            Compete with friends and see who can log the most brews!
          </h5>
        </div>
      </li>
    </ul>
  </div>
  <div class="media-right">
    <!--
      Photo size will be responsive. Photos are hidden/shown based on browser width.
    -->
    <div class="hidden-xs col-sm hidden-md hidden-lg">
      <img
        src="imgs/friends-sm.jpg"
        class="media-object w3-round"
        alt="friends"
      />
    </div>
    <div class="hidden-xs hidden-sm col-md hidden-lg">
      <img
        src="imgs/friends-md.jpg"
        class="media-object w3-round"
        alt="friends"
      />
    </div>
    <div class="hidden-xs hidden-sm hidden-md col-lg">
      <img
        src="imgs/friends-lg.jpg"
        class="media-object w3-round"
        alt="friends"
      />
    </div>
    <div class="hidden-xs hidden-sm hidden-md hidden-lg col-xl">
      <img
        src="imgs/friends-xl.jpg"
        class="media-object w3-round w3-grayscale-min"
        alt="friends"
      />
    </div>
  </div>
</div>

<?php include ('includes/footer.php'); ?>
