<?php
    /* 
    *  This page displays all beers and will have a search function. When the user chooses to add one to a list 
    *  this same page loads with a form to add a comment and confirm the addition. User taken to 
    *  log/love/or later.php to see their full list.
    */

    $page_title = 'Beers, yum!';
    include('includes/header.php');
    include("beans/beer.php");
    require_once '../../mysqli_connect.php';
   

    // This form displays if the user has selected a beer to add to a list and then exits
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        $beer_name = $_POST['beer-name'];
        $beer_maker = $_POST['beer-maker'];
        $log = $_POST['log-type'];
        echo "
            <div class=\"col-md-4 col-md-offset-4 w3-margin-bottom text-center\">
                <form class=\"justify-content-center\" method=\"POST\" action=\"$log.php\">
                    <fieldset>
                        <legend>
                            <h2>Log your brews!</h2>
                        </legend>
                        <div class=\"input-group w3-margin-bottom cntr-form\">
                        <div class=\"form-group\">
                                <label>Action</label>
                                <input name=\"log-type\" type=\"text\" value=\"$log\" class=\"form-control\" readonly>
                            </div>
                            <div class=\"form-group\">
                                <label>Beer</label>
                                <input name=\"beer-name\" type=\"text\" value=\"$beer_name\" class=\"form-control\" readonly>
                            </div>
                            <div class=\"form-group\">
                                <label>Brewed by</label>
                                <input name=\"beer_maker\" type=\"text\" value=\"$beer_maker\" class=\"form-control\" readonly>
                            </div>
                            <div class=\"form-group\">
                                <label>Rating</label><br>
                                <label class=\"radio-inline\"><input type=\"radio\" name=\"rating\" checked>1</label>
                                <label class=\"radio-inline\"><input type=\"radio\" name=\"rating\">2</label>
                                <label class=\"radio-inline\"><input type=\"radio\" name=\"rating\">3</label>
                                <label class=\"radio-inline\"><input type=\"radio\" name=\"rating\">4</label>
                                <label class=\"radio-inline\"><input type=\"radio\" name=\"rating\">5</label>
                            </div>
                            <div class=\"form-group\">
                                <label for=\"comment\">Comment:</label>
                                <textarea name=\"comment\" class=\"form-control\" rows=\"5\" id=\"comment\"></textarea>
                            </div>
                        </div> 
                            <p>
                                <span class=\"input-group-btn\">
                                    <input type=\"submit\" name=\"submit\" value=\"$log\" class=\"btn btn-primary\">
                                </span>
                            </p>
                    </fieldset>
                </form>
            </div>
        ";
        include("includes/footer.php");
        exit;
    }
    // End form 
?>


<!-- Search form -->
<div class="col-md-4 col-md-offset-4 w3-margin-bottom text-center">
    <form method="GET" action="BeerSearch.php" class="justify-content-center">
        <fieldset>
            <legend>
                <h2>Filter by</h2>
            </legend>
            <div class="form-group">
                <div class="input-group w3-margin-bottom cntr-form">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-primary active bg-primary">
                            <input type="radio" name="options" id="option1" value="beer_name" autocomplete="off" checked> Name
                        </label>
                        <label class="btn btn-primary bg-primary">
                            <input type="radio" name="options" id="option2" value="beer_maker" autocomplete="off"> Brewer                            </label>
                        <label class="btn btn-primary bg-primary">
                            <input type="radio" name="options" id="option3" value="beer_style" autocomplete="off"> Style
                        </label>
                    </div>
                </div>
                <div class="input-group w3-margin-bottom cntr-form">
                    <input type="text" name="criteria" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                        <input type="submit" name="add_beer" value="Go!" class="btn btn-primary">
                    </span>
                </div>
                    <!-- /input-group --> 
            </div>
        </fieldset>
    </form> 
</div>

<div class="container">
    <?php
    // Number of records to show per page:
    $display = 16;
    // Determine how many pages there are...
    if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
        $pages = $_GET['p'];
    } else { // Need to determine.
        // Count the number of records:
        $sql = "SELECT COUNT(`BEER_ID`) FROM `BEER`";
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

    // Query for the beers
    $sql = "SELECT `BEER_NAME`,BREWER.BREWER_NAME,`BEER_STYLE` ,`BEER_ABV`,`BEER_IBU`,`BEER_DESCRIPTION`\n"
    . "FROM `BEER`\n"
    . "INNER JOIN BREWER on BEER.BREWER_ID=BREWER.BREWER_ID\n"
    . "ORDER by BEER_NAME\n"
    . "ASC LIMIT $start,$display";
    $r = mysqli_query($dbc, $sql);
    $counter = 0;
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        $beer = new Beer ($row['BEER_NAME'],$row['BREWER_NAME'],$row['BEER_DESCRIPTION'],$row['BREWER_STATE'],"5",$row['BEER_ABV'],$row['BEER_IBU'],$row['BEER_DESCRIPTION']);
        $name = $beer->get_beer_name();
        $maker = $beer->get_beer_maker();
        $description = $beer->get_description();
        $location = $beer->get_location();
        $rating = $beer->get_rating();
        $abv = $beer->get_abv();
        $ibu = $beer->get_ibu();
        $style = $beer->get_style();
        if ($counter % 4 === 0 || counter === 0){
            // This condition, starts a new row
            echo "
                <div class=\"w3-row-padding\">
                    <div class=\"w3-quarter\">
                    <!-- This is the first card in a new row -->
                        <div class=\"w3-container w3-card w3-white w3-margin-bottom\">";
                        // This is an effort to make the cards closet to the same size
                            if (strlen($name) < 18) {
                                echo "<h2 class=\"w3-text-grey w3-padding-16\"><i class=\"fa fa-suitcase fa-fw  w3-large\"></i>$name</h2>";
                            }
                            else if (strlen($name) < 25) {
                                echo "<h3 class=\"w3-text-grey w3-padding-16\"><i class=\"fa fa-suitcase fa-fw  w3-large\"></i>$name</h3>";
                            }
                            else {
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
                                </div>
                                <a href=\"javascript:showMore($counter)\" id=\"link\">Show description...</a>
                                <!-- This is where we will add the beer to the favorites table -->
                                <h5 class=\"w3-opacity text-center\"><b>Log/Love/Later:</b></h5>
                                <div class=\"w3-row-padding cntr-form\">
                                    <div class=\"w3-third \">
                                        <form method=\"POST\" action=\"BeerSearch.php\">
                                            <input type=\"hidden\" name=\"beer-name\" value=\"$name\">
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
        }
        else{
            // cards 2,3,4 in a row
            echo "
                    <div class=\"w3-quarter\">
                    <!-- This is the card card # $counter -->
                        <div class=\"w3-container w3-card w3-white w3-margin-bottom\">";
                        // This is an effort to make the cards closet to the same size
                        if (strlen($name) < 18) {
                            echo "<h2 class=\"w3-text-grey w3-padding-16\"><i class=\"fa fa-suitcase fa-fw  w3-large\"></i>$name</h2>";
                        }
                        else if (strlen($name) < 25) {
                            echo "<h3 class=\"w3-text-grey w3-padding-16\"><i class=\"fa fa-suitcase fa-fw  w3-large\"></i>$name</h3>";
                        }
                        else {
                            echo "<h4 class=\"w3-text-grey w3-padding-16\"><i class=\"fa fa-suitcase fa-fw  w3-large\"></i>$name</h4>";
                        }
                        echo
                                "<div class=\"w3-container\">
                                <h5 class=\"w3-text-blue\"><b>$rating</b></h5>
                                <h5 class=\"w3-opacity\"><b>Brewed by:</b> $maker</h5>
                                <h5 class=\"w3-opacity\"><b>Brewed in:</b> $location</h5>
                                <h5 class=\"w3-opacity\"><b>Style:</b> $style</h5>
                                <h5 class=\"w3-opacity\"><b>ABV:</b> $abv</h5>
                                <h5 class=\"w3-opacity\"><b>IBU:</b> $ibu</h5>
                                <!-- Shows and hides description -->
                                <div id=\"$counter\" style=\"display:none;\">
                                    <p>$description</p><br>
                                </div>
                                <a href=\"javascript:showMore($counter)\" id=\"link\">Show description...</a>
                                <!-- This is where we will add the beer to the favorites table --!>
                                <h5 class=\"w3-opacity text-center\"><b>Log/Love/Later:</b></h5>
                                <div class=\"w3-row-padding cntr-form\">
                                    <div class=\"w3-third\">
                                        <form method=\"POST\" action=\"BeerSearch.php\">
                                            <input type=\"hidden\" name=\"beer-name\" value=\"$name\">
                                            <input type=\"hidden\" name=\"beer-maker\" value=\"$maker\">
                                            <input type=\"hidden\" name=\"log-type\" value=\"log\">
                                            <button id=\"log\" type=\"submit\" title=\"log\" class=\"btn btn-link btn-lg\">
                                                <span style=\"color:goldenrod;\" class=\"glyphicon glyphicon-th-list\"></span>
                                            </button>
                                        </form>
                                    </div>
                                    <div class=\"w3-third\">
                                        <form method=\"POST\" action=\"BeerSearch.php\">
                                            <input type=\"hidden\" name=\"beer-name\" value=\"$name\">
                                            <input type=\"hidden\" name=\"beer-maker\" value=\"$maker\">
                                            <input type=\"hidden\" name=\"log-type\" value=\"love\">
                                            <button id=\"love\" type=\"submit\" title=\"love\" class=\"btn btn-link btn-lg\">
                                                <span style=\"color:goldenrod;\" class=\"glyphicon glyphicon-heart\"></span>
                                            </button>
                                        </form>
                                    </div>
                                    <div class=\"w3-third\">
                                        <form method=\"POST\" action=\"BeerSearch.php\">
                                            <input type=\"hidden\" name=\"beer-name\" value=\"$name\">
                                            <input type=\"hidden\" name=\"beer-maker\" value=\"$maker\">
                                            <input type=\"hidden\" name=\"log-type\" value=\"later\">
                                            <button id=\"later\" type=\"submit\" title=\"later\" class=\"btn btn-link btn-lg\">
                                                <span style=\"color:goldenrod;\" class=\"glyphicon glyphicon-star\"></span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>";
        }
        if (($counter+1)%4===0){
            // Last card on the row, so close the row tag
            echo "</div></br>";
        }
        $counter++;
    }
    ?>
    </div>
    <div class="container alert alert-info w3-margin-top" role="alert">
        <?php
        // Make the links to other pages, if necessary.
        if ($pages > 1) {
            echo '<p>';
            // Determine what page the script is on:
            $current_page = ($start/$display) + 1;
            // If it's not the first page, make a Previous link:
            if ($current_page != 1) {
                echo '<a href="BeerSearch.php?s=' . ($start - $display) . '&p=' . $pages . '">Previous</a> ';
            }
            // Make all the numbered pages:
            for ($i = 1; $i <= $pages; $i++) {
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
            echo '</p>'; // Close the paragraph.
        }
        ?>
    </div>

        <script>
    function showMore(show_description) {
            show_description = show_description.toString();
            if (document.getElementById(show_description).style.display === "none") {
                // Change to hide
                document.getElementById('link').innerHTML = "Hide description...";
                // Show beer desciption
                document.getElementById(show_description).style.display = "block";
            }
            else {
                // back to original
                document.getElementById('link').innerHTML = "Show description...";
                document.getElementById(show_description).style.display = "none";
            }
        }
</script>

<?php
    include('includes/footer.php');
?>