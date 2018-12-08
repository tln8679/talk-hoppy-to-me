<?php
    session_start();
    // User is not an admin
    if (isset($_SESSION['admin']) && $_SESSION['admin']==0){
        $url = 'http://'. $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
        $url = rtrim($url, '/\\');
        $page = '../denied.php';
        $url .= '/' . $page;
        header("Location: $url");
        exit();
      }
      // User hasn't logged in
      else if (!isset($_SESSION['admin'])) {
        $url = 'http://'. $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
        $url = rtrim($url, '/\\');
        $page = '../login.php';
        $url .= '/' . $page;
        header("Location: $url");
        exit();
      }   
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!--Taylor Noble, Jacob Thomas-->
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta charset="utf-8">
    <title>
        <?php echo $page_title; ?>
    </title>
    <link href="../css/w3.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
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
                        <li><a href="AddBeer.php">Add Beers</a></li>
                        <li><a href="AddBrewer.php">Add Brewer</a></li>
                        <li><a href="ViewSuggestions.php">View suggestions</a></li>
                        <li><a href="ViewUsers.php">View users</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">
