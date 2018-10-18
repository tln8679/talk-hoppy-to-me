<?php
    $page_title = 'Beer, yum!';
	// Include header html here
    include('includes/header.html');
?>

<div class="page-header">
    <h1>What are you drinking tonight?</h1>
</div>

<!-- Right-aligned media object -->
<div class="media">
    <div class="media-body">
        <h4 class="media-heading">Don't drink alone when you can drink with friends!</h4>
        <p>
            <ul class="list-unstyled">
                <li class="media">
                    <img class="media-object" src="imgs/fans.png" alt="friends">
                    <div class="media-body">
                        <h5 class="mt-0 mb-1">Follow your friends on their beer-adventures!</h5>
                    </div>
                </li>
                <li class="media my-4">
                    <img class="media-object" src="imgs/rating.png" alt="rate">
                    <div class="media-body">
                        <h5 class="mt-0 mb-1">Log and rank your favorite brews!</h5>
                    </div>
                </li>
                <li class="media">
                    <img class="media-object" src="imgs/to-do.png" alt="compete">
                    <div class="media-body">
                        <h5 class="mt-0 mb-1">Compete with friends and see who can log the most brews!</h5>
                    </div>
                </li>
            </ul>
        </p>
    </div>
    <div class="media-right">
        <div class="hidden-xs hidden-sm-4 hidden-md col-lg-4">
            <div class="beer-pics">
                <div>
                    <img src="imgs/friends.jpg" class="media-object">
                </div>
                <div>
                    <img src="imgs/rating.png" class="media-object">
                </div>
                <div>
                    <img src="imgs/pint.png" class="media-object">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- test -->




<!-- end test -->

<?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                echo '<div class="alert alert-warning" role="alert"><p> Sorry!</p>
		 <p class="text-danger">No database created, yet.</p></div>';
            }    
        ?>
<div class="form-style">
    <form method="POST" action="index.php">
        <p>
            <label for="email"></label>
            <span class="required">*</span>
            <input id="email" style="width:250px" type="text" name="email" placeholder="Email address" class="input-field"
                required>
        </p>
        <p>
            <label for="password"></label>
            <span class="required">*</span>
            <input type="password" id="password" style="width:250px" name="password" placeholder="Password" class="input-field"
                required>
        </p>
        <input type="submit" name="submit" value="Login">
    </form>
</div>
<?php
    include('includes/footer.html');
?>

<!-- Script for the slick carousel -->
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="slick/slick.min.js"></script>
<script type="text/javascript">
    $('.beer-pics').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        variableWidth: true
    });
</script>