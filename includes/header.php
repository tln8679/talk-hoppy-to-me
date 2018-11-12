<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!--Taylor Noble-->
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta charset="utf-8">
    <title>
        <?php echo $page_title; ?>
    </title>
    <link href="css/w3.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
        crossorigin="anonymous">
    <!-- This JavaScript is needed to expand the collapsable menu -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
    <header>
        <label id="icon-label">Talk Hoppy To Me</label>
        <nav class="navbar navbar-light bg-taylor-blue">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="BeerSearch.php">Find Beers</a></li>
                        <li><a href="feed.php">My Feed</a></li>
                        <li><a href="profile.php">My Profile</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <?php if (isset($_SESSION['email'])) { ?>
                            <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>   
                        <?php }  
                            else {
                        ?>
                            <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>  
                            <li><a href="registration.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                        <?php } ?> 
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">
    <!-- <?php
        echo "<h1>".$_SESSION['email']."</h1>";
    ?> -->