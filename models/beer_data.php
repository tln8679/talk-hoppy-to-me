<?php
    // Populating a list of beers for beers.php
    // This will be replaced by SQL
    include("../beans/beer.php");
    $beers_arr = array();

    $beer1 = new Beer("Blue Moon","MillerCoors","Blue Moon Belgian White (branded as Belgian Moon in Canada) is a 
    Belgian-style witbier brewed by MillerCoors under the name the Blue Moon Brewing Co. It was launched in 1995,
     and was originally brewed in Golden, Colorado.","Golden, CO","4.2/10","5.4%","80","Witbier");
    array_push($beers_arr,$beer1);

    $beer2 = new Beer("# 100","Nøgne Ø","Our 100th batch, brewed for the enjoyment of the brewers, but popular 
    demand forced us to release it commercially. This malty, yet light bodied ale has a massive hop bitterness. 
    Most enjoyable in a comfortable chair in front of a roaring fire.","Grimstad, Agder, Norway Lunde 8",
    "4.2/10","10%","80","Scottish-Style Light Ale");
    array_push($beers_arr,$beer2);

    $beer3 = new Beer("Pale Ale","Sierra Nevada Brewing Company","Our most popular beer, Sierra Nevada Pale Ale, 
    is a delightful interpretation of a classic style. It has a deep amber color and an exceptionally full-bodied, 
    complex character. ","Chico, CA",
    "4.2/10","5.6%","37","American-Style Pale Ale");
    array_push($beers_arr,$beer3);

    $beer4 = new Beer("Two Hearted Ale", "Bell's Brewery, Inc.", "Bell's Two Hearted Ale is defined by its intense hop aroma and malt balance. 
    Hopped exclusively with the Centennial hop varietal from the Pacific Northwest, massive additions in the kettle 
    and again in the fermenter lend their characteristic grapefruit and pine resin aromas. A significant malt body 
    balances this hop presence; together with the signature fruity aromas of Bell's house yeast, this leads to a 
    remarkably drinkable American-style India Pale Ale.", "Kalamazoo, MI", "4.2/10","7%",
    "N","American-Style Indian Pale Ale");
    array_push($beers_arr,$beer4);

    $beer5 = new Beer("# 9", "Magic Hat Brewing Company", "Not quite pale ale. A beer cloaked in secrecy. An ale 
    whose mysterious unusual palate will swirl across your tongue and ask more questions than it answers. A sort 
    of dry, crisp, fruity, refreshing, not-quite pale ale. #9 is really impossible to describe because there's never
     been anything else quite like it. Our secret ingredient introduces a most unusual aroma which is balanced with 
     residual sweetness.", "SOUTH BURLINGTON, VT", "4.2/10","5.1%",
    "20","American-Style Pale Ale");
    array_push($beers_arr,$beer5);

    $beer6 = new Beer("Admiral Stache - Milwaukee Brewing Company", "Milwaukee Brewing Company", "Milwaukee Brewing Co’s take on a classic European 
    style. Baltic Porters are the stronger lager fermented cousin of the classic London Porter. The higher strength 
    and cold fermentation help to create a smooth, less fruity porter, rich in roasted malt flavors and aromas.", 
    "Milwaukee, WI", "4.2/10","7%",
    "23","Baltic-Style Porter");
    array_push($beers_arr,$beer6);

    $beer7 = new Beer("Airlie Amber Ale", "Wrightsville Beach Brewery" ,"Malty, medium-bodied ale with a light bitterness from noble German hops 
    and hints of dried fruit on the finish.", "Wilmington, NC", "7.2/10","5.2%",
    "19","Red Ale");
    array_push($beers_arr,$beer7);

    $beer8 = new Beer("Bourbon Barrel-Aged Beach Trip Belgian Tripel (1 Year)","Wrightsville Beach Brewery" , 
    "Our Beach Trip Belgian Tripel aged for over 1 year in Maker's Mark bourbon barrels!", "Wilmington, NC",
     "7.2/10","11.6%", "32","Belgian Tripel");
    array_push($beers_arr,$beer8);
    // var_dump(count($beers_arr)); // Returns length of list
?>