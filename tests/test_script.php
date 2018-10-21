<?php
    // TESTS for the Beer bean (object)
    include("../beans/beer.php");
    $beer = new Beer("Blue Moon","MillerCoors","Blue Moon Belgian White (branded as Belgian Moon in Canada) is a 
    Belgian-style witbier brewed by MillerCoors under the name the Blue Moon Brewing Co. It was launched in 1995,
     and was originally brewed in Golden, Colorado.","Golden, CO","4.2/5","5.4","4.0","Witbier");
    $name = "Name: ".$beer->get_beer_name();
    echo "<p>$name</p>";

    $maker = "Maker: ".$beer->get_beer_maker();
    echo "<p>$maker</p>";

    $description = "Description: ".$beer->get_description();
    echo "<p>$description</p>";

    $location = "Location: ".$beer->get_location();
    echo "<p>$location</p>";

    $rating = "Rate: ".$beer->get_rating();
    echo "<p>$rating</p>";

    $abv = "ABV: ".$beer->get_abv();
    echo "<p>$abv</p>";

    $ibu = "IBU: ".$beer->get_ibu();
    echo "<p>$ibu</p>";

    $style = "STYLE: ".$beer->get_style;
    echo "<p>$style</p>";

    // TEST: An array of beers
?>