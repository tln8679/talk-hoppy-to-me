<?php
    include("../beans/beer.php");
    // TESTS for the Beer bean (object)
    echo "<p><h1>Beer object test</h1></p>";
    $beer1 = new Beer("Blue Moon","MillerCoors","Blue Moon Belgian White (branded as Belgian Moon in Canada) is a 
    Belgian-style witbier brewed by MillerCoors under the name the Blue Moon Brewing Co. It was launched in 1995,
     and was originally brewed in Golden, Colorado.","Golden, CO","4.2/5","5.4%","80","Witbier");
    $name = "Name: ".$beer1->get_beer_name();
    echo "<p>$name</p>";

    $maker = "Maker: ".$beer1->get_beer_maker();
    echo "<p>$maker</p>";

    $description = "Description: ".$beer1->get_description();
    echo "<p>$description</p>";

    $location = "Location: ".$beer1->get_location();
    echo "<p>$location</p>";

    $rating = "Rate: ".$beer1->get_rating();
    echo "<p>$rating</p>";

    $abv = "ABV: ".$beer1->get_abv();
    echo "<p>$abv</p>";

    $ibu = "IBU: ".$beer1->get_ibu();
    echo "<p>$ibu</p>";

    $style = "STYLE: ".$beer1->get_style();
    echo "<p>$style</p>";

    $beer1->set_beer_name("<Changed name>");
    $new_name = $beer1->get_beer_name();
    echo "<p>$new_name</p>";

    // TEST: An array of beers
    $beers_arr = array();
    array_push($beers_arr,$beer1);
    $beer2 = new Beer("# 100","Nøgne Ø","Our 100th batch, brewed for the enjoyment of the brewers, but popular 
    demand forced us to release it commercially. This malty, yet light bodied ale has a massive hop bitterness. 
    Most enjoyable in a comfortable chair in front of a roaring fire.","Grimstad, Agder, Norway Lunde 8",
    "4.2/5","10%","80","Scottish-Style Light Ale");
    array_push($beers_arr,$beer2);
    $beer3 = new Beer("Pale Ale","Sierra Nevada Brewing Company","Our most popular beer, Sierra Nevada Pale Ale, 
    is a delightful interpretation of a classic style. It has a deep amber color and an exceptionally full-bodied, 
    complex character. ","Chico, CA",
    "4.2/5","5.6%","37","American-Style Pale Ale");
    array_push($beers_arr,$beer3);
    $beer4 = new Beer("Two Hearted Ale", "Bell's Brewery, Inc.", "Bell's Two Hearted Ale is defined by its intense hop aroma and malt balance. 
    Hopped exclusively with the Centennial hop varietal from the Pacific Northwest, massive additions in the kettle 
    and again in the fermenter lend their characteristic grapefruit and pine resin aromas. A significant malt body 
    balances this hop presence; together with the signature fruity aromas of Bell's house yeast, this leads to a 
    remarkably drinkable American-style India Pale Ale.", "Kalamazoo, MI", "4.2/5","7%",
    "N","American-Style Indian Pale Ale");
    array_push($beers_arr,$beer4);
    echo "<p><h1>Objects array test: </h1></p>";
    var_dump(count($beers_arr)); // Returns length of list
    foreach($beers_arr as $beer){
        $loc = $beer->get_location();
        $name = $beer->get_beer_name();
        echo "<p>$name is brewed in $loc</p>";
    }
?>