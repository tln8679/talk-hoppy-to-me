<?php
    /* 
    *  This page displays all beers and will have a search function. When the user chooses to add one to a list 
    *  this same page loads with a form to add a comment and confirm the addition. User taken to 
    *  log/love/or later.php to see their full list.
    */

    $page_title = 'Beers, yum!';
	// Include header html here
    include('includes/header.php');
    // You need this because the include in beer_data is now processed from this dir
    include("beans/beer.php");
    // getting the Array for populating the cards
    include("models/beer_data.php");

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
                            <p>
                                <label>Action</label>
                                <input name=\"log-type\" type=\"text\" value=\"$log\" class=\"form-control\" readonly>
                            </p>
                            <p>
                                <label>Beer</label>
                                <input name=\"beer-name\" type=\"text\" value=\"$beer_name\" class=\"form-control\" readonly>
                            </p>
                            <p>
                                <label>Brewed by</label>
                                <input name=\"beer_maker\" type=\"text\" value=\"$beer_maker\" class=\"form-control\" readonly>
                            </p>
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
    // End form start html
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


    <?php
    // Instantiating an array that we will use to populate the cards
    $BEERS = array("Miller Light", "\"18\" Imperial IPA", "\"The Great BOO\" Pumpkin Ale", "Wintah Ale", "Sierra Nevade, Pale Ale","Milwaukees Best",
            "Orange krush kolsch", "Vienna Lager", "Bud Light");
    // Need to start a new row after the four columns have been filled
    $counter = 0;
    // var_dump(count($beers_arr)); // Returns length of list
    foreach($beers_arr as $beer){
        // Get variables from the object
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
                                <div class=\"w3-row-padding\">
                                    <div class=\"w3-third\">
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
                                <div class=\"w3-row-padding\">
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
            echo "</div>";
        }
        $counter++;
    }
?>

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