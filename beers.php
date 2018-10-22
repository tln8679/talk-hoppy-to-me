<?php
    $page_title = 'Beers, yum!';
	// Include header html here
    include('includes/header.html');
    // You need this because the include in beer_data is now processed from this dir
    include("beans/beer.php");
    // getting the Array for populating the cards
    include("tests/beer_data.php");

    echo "<h1>Search functionality will go here</h1>";

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
                        <div class=\"w3-container w3-card w3-white w3-margin-bottom\">
                            <h2 class=\"w3-text-grey w3-padding-16\"><i class=\"fa fa-suitcase fa-fw  w3-large\"></i>$name</h2>
                            <div class=\"w3-container\">
                                <h5 class=\"w3-text-blue\"><b>$rating</b></h5>
                                <h5 class=\"w3-opacity\"><b>Brewed by:</b> $maker</h5>
                                <h5 class=\"w3-opacity\"><b>Brewed in:</b> $location</h5>
                                <h5 class=\"w3-opacity\"><b>Brewed by:</b> $style</h5>
                                <h5 class=\"w3-opacity\"><b>ABV:</b> $abv</h5>
                                <h5 class=\"w3-opacity\"><b>IBU:</b> $ibu</h5>
                                <p>$description</p><br>
                            </div>
                        </div> 
                    </div>";
        }
        else{
            // cards 2,3,4 in a row
            echo "
                    <div class=\"w3-quarter\">
                    <!-- This is the card card # $counter -->
                        <div class=\"w3-container w3-card w3-white w3-margin-bottom\">
                            <h2 class=\"w3-text-grey w3-padding-16\"><i class=\"fa fa-suitcase fa-fw  w3-xxlarge w3-text-teal\"></i>$name</h2>
                            <div class=\"w3-container\">
                                <h5 class=\"w3-text-blue\"><b>$rating</b></h5>
                                <h5 class=\"w3-opacity\"><b>Brewed by:</b> $maker</h5>
                                <h5 class=\"w3-opacity\"><b>Brewed in:</b> $location</h5>
                                <h5 class=\"w3-opacity\"><b>Brewed by:</b> $style</h5>
                                <h5 class=\"w3-opacity\"><b>ABV:</b> $abv</h5>
                                <h5 class=\"w3-opacity\"><b>IBU:</b> $ibu</h5>
                                <p>$description</p><br>
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
<?php
    include('includes/footer.html');
?>