<?php
/*
 *  This page displays all beers and will have a search function. When the user chooses to add one to a list
 *  this same page loads with a form to add a comment and confirm the addition. User taken to
 *  log/love/or later.php to see their full list.
*/
require_once 'secure_conn.php';
$page_title = 'Beers, yum!';
include ('includes/header.php');
require_once ("beans/beer.php");
require_once ("beans/user.php");
require_once '../../mysqli_connect.php';

// This form displays if the user has selected a beer to add to a list and then exits
if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST['log_it'])) {
    $beer_name = $_POST['beer-name'];
    $beer_id = $_POST['beer-id'];
    $beer_maker = $_POST['beer-maker'];
    $log = $_POST['log-type'];
    // display the html
    
?>
<div class="w3-row-padding">
    <div class="w3-container w3-card w3-white w3-margin-bottom">
        <div class="w3-container">            
            <form method="POST" action="BeerSearch.php">
                <fieldset>
                    <legend class="w3-text-grey w3-padding-16" style="text-align: center;">
                        <i class="fa fa-suitcase fa-fw w3-xxlarge w3-text-indigo">Log your brew!</i>
                    </legend>
                    <div class="form-group w3-margin-bottom" style="text-align: center;"> 
                        <label>Action</label>
                        <input name="log-type" style="width:250px; margin: auto;" type="text" value="<?php echo $log; ?>" class="form-control" readonly>
                    </div>

                    <div class="form-group w3-margin-bottom" style="text-align: center;"> 
                        <label>Beer</label>
                        <input name="beer-name" style="width:250px; margin: auto;" type="text" value="<?php echo $beer_name; ?>" class="form-control" readonly>            
                    </div>
                    <div class="form-group w3-margin-bottom" style="text-align: center;"> 
                        <label>Beer ID</label>
                        <input name="beer-id" style="width:250px; margin: auto;" type="text" value="<?php echo $beer_id; ?>" class="form-control" readonly>            
                    </div>
                    <div class="form-group w3-margin-bottom" style="text-align: center;"> 
                        <label>Brewed by</label>
                        <input name="beer-maker" style="width:250px; margin: auto;" type="text" value="<?php echo $beer_maker; ?>" class="form-control" readonly>          
                    </div>
                    <?php
    // Only show rating scale for rating
    if ($log == "log") {
        echo "<div class=\"form-group\" style=\"text-align: center;\">
                                <label>Rating</label><br>
                                <label class=\"radio-inline\"><input type=\"radio\" name=\"rating\" value=\"1\" checked>1</label>
                                <label class=\"radio-inline\"><input type=\"radio\" name=\"rating\" value=\"2\">2</label>
                                <label class=\"radio-inline\"><input type=\"radio\" name=\"rating\" value=\"3\">3</label>
                                <label class=\"radio-inline\"><input type=\"radio\" name=\"rating\" value=\"4\">4</label>
                                <label class=\"radio-inline\"><input type=\"radio\" name=\"rating\" value=\"5\">5</label>
                            </div>";
        // We only want comments for log as well
        
?>
                    <div class="form-group w3-margin-bottom" style="text-align: center;"> 
                        <label>Comment:</label>
                        <textarea rows="5" name="comment" style="width:250px; margin: auto;" class="form-control" maxlength="10000" ><?php if (isset($comment)) echo $comment; ?></textarea>
                    </div>
                    <?php
    } ?>
                    <div class="form-group w3-margin-bottom" style="text-align: center;">           
                        <input type="submit" name="log_it" value="Submit" class="btn btn-primary">
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<?php
    include ("includes/footer.php");
    exit;
}
// End form
// SQL for adding a beer to logged/love/later
if (isset($_POST['log_it'])) {
    // make sure the user is logged in
    if (isset($_SESSION['email'])) {
        $current_id = $_SESSION['usersID'];
        $current_user = new User($_SESSION['firstName'], $_SESSION['lastName'], $_SESSION['avatar'], $_SESSION['email'], $_SESSION['phone'], $_SESSION['city'], $_SESSION['state'], $_SESSION['admin']);
    }
    // User hasn't logged in yet so they can't log anything
    else {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
        $url = rtrim($url, '/\\');
        $page = 'login.php';
        $url.= '/' . $page;
        header("Location: $url");
        exit();
    }
    $action = $_POST['log-type'];
    $beer_id = $_POST['beer-id'];
    $user_id = $_SESSION['usersID'];
    $beer_name = $_POST['beer-name'];
    switch ($action) {
        case "log":
            // always set for log (default)
            $rating = $_POST['rating'];
            if (!empty($_POST['comment'])) {
                // Not going to sanitize because prepared statement is enough
                $comment = $_POST['comment'];
            }
            // Insert to log
            // Ignore if record with this Primary already exists (ie jump to error message)
            $sql = "INSERT IGNORE INTO `USER_LOG`(`BEER_ID`, `USERS_ID`) VALUES (?,?)";
            $stmt = mysqli_prepare($dbc, $sql);
            // 'ss' declares the types that we are inserting
            mysqli_stmt_bind_param($stmt, 'ss', $beer_id, $user_id);
            mysqli_stmt_execute($stmt);
            if (mysqli_stmt_affected_rows($stmt)) { //It worked
                echo "<div class=\"alert alert-success\" role=\"alert\">
                    <p>You have logged <strong>$beer_name</strong></p>
                    <p><a href=\"BeerSearch.php\">Click to return to beers</a></p>
                    </div>";
            } else {
                echo "<div class=\"alert alert-danger\" role=\"alert\">
                        <p>We're sorry, there was an error trying to log $beer_name. Ensure that you haven't already added this beer.</p>
                        <p><a href=\"BeerSearch.php\">Click to return to beers</a></p>
                        </div>";
                break;
            }
            unset($sql);
            unset($stmt);
            //  insert as a post to be displayed on the feed
            $sql = "INSERT IGNORE INTO `USER_POST`(`RATING`, `COMMENT`, `USER_ID`, `BEER_ID`) VALUES (?,?,?,?)";
            $stmt = mysqli_prepare($dbc, $sql);
            mysqli_stmt_bind_param($stmt, 'ssss', $rating, $comment, $user_id, $beer_id);
            mysqli_stmt_execute($stmt);
            if (mysqli_stmt_affected_rows($stmt)) { //It worked
                echo "<div class=\"alert alert-success\" role=\"alert\">
                    <p>You have posted <strong>$beer_name</strong> to the feed!</p>
                    </div>";
            } else {
                echo "<div class=\"alert alert-danger\" role=\"alert\">
                        <p>We're sorry, there was an error posting: $rating, $comment, $user_id, $beer_id</p>
                        <p><a href=\"BeerSearch.php\">Click to return to beers</a></p>
                        </div>";
            }
        break;
        case "love":
            $sql = "INSERT IGNORE INTO `USER_LOVE`(`BEER_ID`, `USERS_ID`) VALUES (?,?)";
            $stmt = mysqli_prepare($dbc, $sql);
            // 'ss' declares the types that we are inserting
            mysqli_stmt_bind_param($stmt, 'ss', $beer_id, $user_id);
            mysqli_stmt_execute($stmt);
            if (mysqli_stmt_affected_rows($stmt)) { //It worked
                echo "<div class=\"alert alert-success\" role=\"alert\">
                    <p>You have loved <strong>$beer_name</strong></p>
                    <p><a href=\"BeerSearch.php\">Click to return to beers</a></p>
                    </div>";
            } else {
                echo "<div class=\"alert alert-danger\" role=\"alert\">
                        <p>We're sorry, there was an error trying to log $beer_name</p>
                        <p><a href=\"BeerSearch.php\">Click to return to beers</a></p>
                        </div>";
            }
        break;
        case "later":
            $sql = "INSERT IGNORE INTO `USER_LATER`(`BEER_ID`, `USERS_ID`) VALUES (?,?)";
            $stmt = mysqli_prepare($dbc, $sql);
            // 'ss' declares the types that we are inserting
            mysqli_stmt_bind_param($stmt, 'ss', $beer_id, $user_id);
            mysqli_stmt_execute($stmt);
            if (mysqli_stmt_affected_rows($stmt)) { //It worked
                echo "<div class=\"alert alert-success\" role=\"alert\">
                    <p>You have marked <strong>$beer_name</strong> for later</p>
                    <p><a href=\"BeerSearch.php\">Click to return to beers</a></p>
                    </div>";
            } else {
                echo "<div class=\"alert alert-danger\" role=\"alert\">
                        <p>We're sorry, there was an error trying to log $beer_name</p>
                        <p><a href=\"BeerSearch.php\">Click to return to beers</a></p>
                        </div>";
            }
        break;
        default:
            echo "<p>Error</p>";
    }
    include ("includes/footer.php");
    exit;
}
?>


<!-- Search form -->
<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-container w3-card w3-white w3-margin-bottom">
        <div class="w3-container">
            <form method="GET" action="BeerSearch.php" class="justify-content-center">
                <fieldset>
                    <legend class="w3-text-grey w3-padding-16" style="text-align: center;">
                        Filter by
                    </legend>
                    <div class="form-group w3-margin-bottom" style="text-align: center;">
                        <div class="input-group w3-margin-bottom cntr-form">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-primary active bg-primary">
                                    <input type="radio" name="options" id="option1" value="beer_name" checked> Name
                                </label>
                                <label class="btn btn-primary bg-primary">
                                    <input type="radio" name="options" id="option2" value="beer_maker"> Brewer                            </label>
                                <label class="btn btn-primary bg-primary">
                                    <input type="radio" name="options" id="option3" value="beer_style"> Style
                                </label>
                            </div>
                        </div>
                        <div class="input-group w3-margin-bottom cntr-form">
                            <input type="text" name="criteria" class="form-control" placeholder="Search for...">
                            <span class="input-group-btn">
                                <input type="submit" value="Go!" class="btn btn-primary">
                            </span>
                        </div>
                            <!-- /input-group --> 
                    </div>
                </fieldset>
            </form> 
        </div>
    </div>  
</div>


<div class="container">
    <?php
// Query for the beers. $sql query is dependent on what the user has searched for if searched.
if (isset($_GET['options'])) {
    $option = $_GET['options'];
    if (isset($_GET['criteria'])) {
        // Escape because prepared statements and pagination is no fun together
        $criteria = mysqli_real_escape_string($dbc, trim($_GET['criteria']));
    }
    // Don't allow a blank search
    else {
        echo "<div class=\"alert alert-danger\" role=\"alert\">
            <p>Invalid search</p>
            <p><a href=\"BeerSearch.php\">You must enter criteria to search for!</a></p>
            </div>";
        include ('includes/footer.php');
        exit;
    }
    if ($option == "beer_name") {
        $sql = "SELECT `BEER_ID`, `BEER_NAME`,BREWER.BREWER_NAME,`BEER_DESCRIPTION`,CONCAT(BREWER.BREWER_CITY,', ' ,BREWER.BREWER_STATE) AS Location,`BEER_ABV`,`BEER_IBU`,`BEER_STYLE` \n" . "FROM `BEER`\n" . "INNER JOIN BREWER on BEER.BREWER_ID=BREWER.BREWER_ID\n" . "WHERE BEER_NAME LIKE '%$criteria%'\n" . "ORDER by BEER_NAME\n" . "ASC";
    } else if ($option == "beer_maker") {
        $sql = "SELECT `BEER_ID`, `BEER_NAME`,BREWER.BREWER_NAME,`BEER_DESCRIPTION`,CONCAT(BREWER.BREWER_CITY,', ' ,BREWER.BREWER_STATE) AS Location,`BEER_ABV`,`BEER_IBU`,`BEER_STYLE` \n" . "FROM `BEER`\n" . "INNER JOIN BREWER on BEER.BREWER_ID=BREWER.BREWER_ID\n" . "WHERE BREWER.BREWER_NAME LIKE '%$criteria%'\n" . "ORDER by BEER_NAME\n" . "ASC";
    } else if ($option == "beer_style") {
        $sql = "SELECT `BEER_ID`, `BEER_NAME`,BREWER.BREWER_NAME,`BEER_DESCRIPTION`,CONCAT(BREWER.BREWER_CITY,', ' ,BREWER.BREWER_STATE) AS Location,`BEER_ABV`,`BEER_IBU`,`BEER_STYLE` \n" . "FROM `BEER`\n" . "INNER JOIN BREWER on BEER.BREWER_ID=BREWER.BREWER_ID\n" . "WHERE BEER_STYLE LIKE '%$criteria%'\n" . "ORDER by BEER_NAME\n" . "ASC";
    } else {
        echo "<div class=\"alert alert-danger\" role=\"alert\">
            <p>Invalid search</p>
            <p><a href=\"BeerSearch.php\">Click to return to beers</a></p>
            </div>";
        include ('includes/footer.php');
        exit;
    }
} else {
    // Show all beers
    $sql = "SELECT `BEER_ID`, `BEER_NAME`,BREWER.BREWER_NAME,`BEER_DESCRIPTION`,CONCAT(BREWER.BREWER_CITY,', ' ,BREWER.BREWER_STATE) AS Location,`BEER_ABV`,`BEER_IBU`,`BEER_STYLE` \n" . "FROM `BEER`\n" . "INNER JOIN BREWER on BEER.BREWER_ID=BREWER.BREWER_ID\n" . "ORDER by BEER_NAME\n" . "ASC";
}
$r = mysqli_query($dbc, $sql);
// paginate variables
$count = mysqli_num_rows($r);
// Number of records to show per page:
$display = 16;
// Determine how many pages there are...
if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
    $pages = $_GET['p'];
} else { // Need to determine.
    // Count the number of records:
    $records = $count;
    // Calculate the number of pages...
    if ($records > $display) { // More than 1 page.
        $pages = ceil($records / $display);
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
$counter = 0;
if (mysqli_num_rows($r) > 0) { // If user had searched, results are found
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        $beer_name = $row['BEER_NAME'];
        $beer_id = $row['BEER_ID'];
        // Get the beer rating from derivation
        $sql = "SELECT BEER_NAME AS beer, AVG(USER_POST.RATING) AS Rating\n" . " FROM `BEER` JOIN USER_POST USING (BEER_ID)\n" . " WHERE BEER.BEER_NAME = \"$beer_name \"";
        $stmt = mysqli_query($dbc, $sql);
        while ($record = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
            $rating = $record['Rating'];
        }
        if (empty($rating)) $rating = "0 (No reviews yet)";
        else $rating.= "/5";
        $beer = new Beer($row['BEER_NAME'], $row['BREWER_NAME'], $row['BEER_DESCRIPTION'], $row['Location'], $rating, $row['BEER_ABV'], $row['BEER_IBU'], $row['BEER_STYLE']);
        $name = $beer->get_beer_name();
        $maker = $beer->get_beer_maker();
        $description = $beer->get_description();
        $location = $beer->get_location();
        $rating = $beer->get_rating();
        // convert abv to percentage string
        $abv = $beer->get_abv();
        $abv = (float)$abv * 100;
        $abv = strval($abv) . "%";
        $ibu = $beer->get_ibu();
        $style = $beer->get_style();
        if ($counter % 4 === 0 || $counter === 0) {
            // This condition, starts a new row
            echo "
                    <div class=\"w3-row-padding\">
                        <div class=\"w3-quarter\">
                        <!-- This is the first card in a new row -->
                            <div class=\"w3-container w3-card w3-white w3-margin-bottom\">";
            // This is an effort to make the cards closet to the same size
            if (strlen($name) < 18) {
                echo "<h2 class=\"w3-text-grey w3-padding-16\"><i class=\"fa fa-suitcase fa-fw  w3-large\"></i>$name</h2>";
            } else if (strlen($name) < 25) {
                echo "<h3 class=\"w3-text-grey w3-padding-16\"><i class=\"fa fa-suitcase fa-fw  w3-large\"></i>$name</h3>";
            } else {
                echo "<h4 class=\"w3-text-grey w3-padding-16\"><i class=\"fa fa-suitcase fa-fw  w3-large\"></i>$name</h4>";
            }
            echo "<div class=\"w3-container\">
                                    <h5 class=\"w3-text-blue\"><b>$rating</b></h5>
                                    <h5 class=\"w3-opacity\"><b>Brewed by:</b> $maker</h5>
                                    <h5 class=\"w3-opacity\"><b>Brewed in:</b> $location</h5>
                                    <h5 class=\"w3-opacity\"><b>Style:</b> $style</h5>
                                    <h5 class=\"w3-opacity\"><b>ABV:</b> $abv</h5>
                                    <h5 class=\"w3-opacity\"><b>IBU:</b> $ibu</h5>
                                    <!-- Shows and hides description -->
                                    <div id=\"$counter\" style=\"display:none;\">
                                        <p>$description</p><br>
                                    </div>";
            // In order to be html valid we can't use the same id twice
            // Since there are only 16 beers on a page adding 1000 to the beer (overkill) ensures no duplicates
            $js_counter = $counter + 1000;
            echo "<a href=\"javascript:showMore($counter, $js_counter)\" id=\"$js_counter\">Show description...</a>
                                    <!-- This is where we will add the beer to the favorites table -->
                                    <h5 class=\"w3-opacity text-center\"><b>Log/Love/Later:</b></h5>
                                    <div class=\"w3-row-padding cntr-form\">
                                        <div class=\"w3-third \">
                                            <form method=\"POST\" action=\"BeerSearch.php\">
                                                <input type=\"hidden\" name=\"beer-name\" value=\"$name\">
                                                <input type=\"hidden\" name=\"beer-id\" value=\"$beer_id\">
                                                <input type=\"hidden\" name=\"beer-maker\" value=\"$maker\">
                                                <input type=\"hidden\" name=\"log-type\" value=\"log\">
                                                <button type=\"submit\" class=\"btn btn-link btn-lg\">
                                                    <span style=\"color:goldenrod;\" class=\"glyphicon glyphicon-th-list\"></span>
                                                </button>
                                            </form>
                                        </div>
                                        <div class=\"w3-third\">
                                            <form method=\"POST\" action=\"BeerSearch.php\">
                                                <input type=\"hidden\" name=\"beer-name\" value=\"$name\">
                                                <input type=\"hidden\" name=\"beer-id\" value=\"$beer_id\">
                                                <input type=\"hidden\" name=\"beer-maker\" value=\"$maker\">
                                                <input type=\"hidden\" name=\"log-type\" value=\"love\">
                                                <button type=\"submit\" class=\"btn btn-link btn-lg\">
                                                    <span style=\"color:goldenrod;\" class=\"glyphicon glyphicon-heart\"></span>
                                                </button>
                                            </form>
                                        </div>
                                        <div class=\"w3-third\">
                                            <form method=\"POST\" action=\"BeerSearch.php\">
                                                <input type=\"hidden\" name=\"beer-name\" value=\"$name\">
                                                <input type=\"hidden\" name=\"beer-id\" value=\"$beer_id\">
                                                <input type=\"hidden\" name=\"beer-maker\" value=\"$maker\">
                                                <input type=\"hidden\" name=\"log-type\" value=\"later\">
                                                <button type=\"submit\" class=\"btn btn-link btn-lg\">
                                                    <span style=\"color:goldenrod;\" class=\"glyphicon glyphicon-star\"></span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>";
        } else {
            // cards 2,3,4 in a row
            echo "
                        <div class=\"w3-quarter\">
                        <!-- This is the card card # $counter -->
                            <div class=\"w3-container w3-card w3-white w3-margin-bottom\">";
            // This is an effort to make the cards closet to the same size
            if (strlen($name) < 18) {
                echo "<h2 class=\"w3-text-grey w3-padding-16\"><i class=\"fa fa-suitcase fa-fw  w3-large\"></i>$name</h2>";
            } else if (strlen($name) < 25) {
                echo "<h3 class=\"w3-text-grey w3-padding-16\"><i class=\"fa fa-suitcase fa-fw  w3-large\"></i>$name</h3>";
            } else {
                echo "<h4 class=\"w3-text-grey w3-padding-16\"><i class=\"fa fa-suitcase fa-fw  w3-large\"></i>$name</h4>";
            }
            echo "<div class=\"w3-container\">
                                    <h5 class=\"w3-text-blue\"><b>$rating</b></h5>
                                    <h5 class=\"w3-opacity\"><b>Brewed by:</b> $maker</h5>
                                    <h5 class=\"w3-opacity\"><b>Brewed in:</b> $location</h5>
                                    <h5 class=\"w3-opacity\"><b>Style:</b> $style</h5>
                                    <h5 class=\"w3-opacity\"><b>ABV:</b> $abv</h5>
                                    <h5 class=\"w3-opacity\"><b>IBU:</b> $ibu</h5>
                                    <!-- Shows and hides description -->
                                    <div id=\"$counter\" style=\"display:none;\">
                                        <p>$description</p><br>
                                    </div>";
            // In order to be html valid we can't use the same id twice
            // Since there are only 16 beers on a page adding 1000 to the beer (overkill) ensures no duplicates
            $js_counter = $counter + 1000;
            echo "<a href=\"javascript:showMore($counter, $js_counter)\" id=\"$js_counter\">Show description...</a>
                                    <!-- This is where we will add the beer to the favorites table --!>
                                    <h5 class=\"w3-opacity text-center\"><b>Log/Love/Later:</b></h5>
                                    <div class=\"w3-row-padding cntr-form\">
                                        <div class=\"w3-third\">
                                            <form method=\"POST\" action=\"BeerSearch.php\">
                                                <input type=\"hidden\" name=\"beer-name\" value=\"$name\">
                                                <input type=\"hidden\" name=\"beer-id\" value=\"$beer_id\">
                                                <input type=\"hidden\" name=\"beer-maker\" value=\"$maker\">
                                                <input type=\"hidden\" name=\"log-type\" value=\"log\">
                                                <button type=\"submit\" title=\"log\" class=\"btn btn-link btn-lg\">
                                                    <span style=\"color:goldenrod;\" class=\"glyphicon glyphicon-th-list\"></span>
                                                </button>
                                            </form>
                                        </div>
                                        <div class=\"w3-third\">
                                            <form method=\"POST\" action=\"BeerSearch.php\">
                                                <input type=\"hidden\" name=\"beer-name\" value=\"$name\">
                                                <input type=\"hidden\" name=\"beer-id\" value=\"$beer_id\">
                                                <input type=\"hidden\" name=\"beer-maker\" value=\"$maker\">
                                                <input type=\"hidden\" name=\"log-type\" value=\"love\">
                                                <button type=\"submit\" title=\"love\" class=\"btn btn-link btn-lg\">
                                                    <span style=\"color:goldenrod;\" class=\"glyphicon glyphicon-heart\"></span>
                                                </button>
                                            </form>
                                        </div>
                                        <div class=\"w3-third\">
                                            <form method=\"POST\" action=\"BeerSearch.php\">
                                                <input type=\"hidden\" name=\"beer-name\" value=\"$name\">
                                                <input type=\"hidden\" name=\"beer-id\" value=\"$beer_id\">
                                                <input type=\"hidden\" name=\"beer-maker\" value=\"$maker\">
                                                <input type=\"hidden\" name=\"log-type\" value=\"later\">
                                                <button type=\"submit\" title=\"later\" class=\"btn btn-link btn-lg\">
                                                    <span style=\"color:goldenrod;\" class=\"glyphicon glyphicon-star\"></span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>";
        }
        if (($counter + 1) % 4 === 0) {
            // Last card on the row, so close the row tag
            echo "</div>";
        }
        $counter++;
    }
} else {
    echo "<div class=\"alert alert-danger\" role=\"alert\">
            <p>Error retrieving data. Check your spelling and try again.</p>
            <p><a href=\"BeerSearch.php\">Click to return to beers</a></p>
            </div>";
    include ('includes/footer.php');
    exit;
}
?>
    </div>
    
<?php
// Make the links to other pages, if necessary.
// Not going to paginate the search
if ($pages > 1) {
    echo '<div class="container alert alert-info w3-margin-top" role="alert">';
    // Determine what page the script is on:
    $current_page = ($start / $display) + 1;
    // If it's not the first page, make a Previous link:
    if (empty($_GET['options'])) {
        if ($current_page != 1) {
            echo '<a href="BeerSearch.php?s=' . ($start - $display) . '&p=' . $pages . '">Previous</a> ';
        }
        // Make all the numbered pages:
        for ($i = 1;$i <= $pages;$i++) {
            if ($i != $current_page) {
                echo '<a href="BeerSearch.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '">' . $i . '</a> ';
            } else {
                echo $i . ' ';
            }
        } // End of FOR loop.
        // If it's not the last page, make a Next button:
        if ($current_page != $pages) {
            echo '<a href="BeerSearch.php?s=' . ($start + $display) . '&p=' . $pages . '">Next</a>';
        }
    } else {
        if ($current_page != 1) {
            echo '<a href="BeerSearch.php?s=' . ($start - $display) . '&p=' . $pages . '&options=' . $option . '&criteria=' . $criteria . '">Previous</a> ';
        }
        // Make all the numbered pages:
        for ($i = 1;$i <= $pages;$i++) {
            if ($i != $current_page) {
                echo '<a href="BeerSearch.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&options=' . $option . '&criteria=' . $criteria . '">' . $i . '</a> ';
            } else {
                echo $i . ' ';
            }
        } // End of FOR loop.
        // If it's not the last page, make a Next button:
        if ($current_page != $pages) {
            echo '<a href="BeerSearch.php?s=' . ($start + $display) . '&p=' . $pages . '&options=' . $option . '&criteria=' . $criteria . '">Next</a>';
        }
    }
    echo '</div>'; // Close the paragraph.
    
}
?>
<script>
    function showMore(show_description, link_id) {
            show_description = show_description.toString();
            if (document.getElementById(show_description).style.display === "none") {
                // Change to hide
                document.getElementById(link_id).innerHTML = "Hide description...";
                // Show beer desciption
                document.getElementById(show_description).style.display = "block";
            }
            else {
                // back to original
                document.getElementById(link_id).innerHTML = "Show description...";
                document.getElementById(show_description).style.display = "none";
            }
        }
</script>

<?php
include ('includes/footer.php');
?>