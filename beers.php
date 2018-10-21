<?php
    $page_title = 'You, yum!';
	// Include header html here
    include('includes/header.html');
?>

<?php
    // Instantiating an array that we will use to populate the cards
    $BEERS = array("Miller Light", "\"18\" Imperial IPA", "\"The Great BOO\" Pumpkin Ale", "Wintah Ale", "Sierra Nevade, Pale Ale","Milwaukees Best",
            "Orange krush kolsch", "Vienna Lager", "Bud Light");
    // Need to start a new row after the four columns have been filled
    $counter = 0;
    foreach($BEERS as $beer){
        // $test = $counter%4;
        // echo "<p>$counter</p>";
        if ($counter % 4 === 0 || counter === 0){
            // This condition, starts a new row
            echo "
                <div class=\"w3-row-padding\">
                    <div class=\"w3-quarter\">
                    <!-- This is the first card in a new row -->
                        <div class=\"w3-container w3-card w3-white w3-margin-bottom\">
                            <h2 class=\"w3-text-grey w3-padding-16\"><i class=\"fa fa-suitcase fa-fw w3-margin-right w3-large\"></i>$beer</h2>
                            <div class=\"w3-container\">
                                <h5 class=\"w3-opacity\"><b>Miller Lite</b></h5>
                                <h6 class=\"w3-text-teal\"><i class=\"fa fa-calendar fa-fw w3-margin-right\"></i>10/10</span></h6>
                                <p>Miller Lite, also known simply as Lite, is a 4.2% ABV American light pale lager sold by MillerCoors of Milwaukee, Wisconsin, United States. Miller Lite competes with Anheuser-Busch's Bud Light beer. The company also produces Miller Genuine Draft and Miller High Life.</p><br>
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
                            <h2 class=\"w3-text-grey w3-padding-16\"><i class=\"fa fa-suitcase fa-fw w3-margin-right w3-xxlarge w3-text-teal\"></i>$beer</h2>
                            <div class=\"w3-container\">
                                <h5 class=\"w3-opacity\"><b>$counter Miller Lite</b></h5>
                                <h6 class=\"w3-text-teal\"><i class=\"fa fa-calendar fa-fw w3-margin-right\"></i>October 2018</span></h6>
                                <p>Solid American Brew.</p><br>
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