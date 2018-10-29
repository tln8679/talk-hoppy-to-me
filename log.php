<?php
    /* 
    *  This page displays the list of beers a user wishes to try.
    *  The input variables come from BeerSearch.php when the user adds
    *  the beer via one of the buttons.
    */

	$page_title = 'Register!';
    include('includes/header.php');
    echo "<h1>Logged list</h1>";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $beer_name = $_POST['beer-name'];
        $beer_maker = $_POST['beer-maker'];
        $log = $_POST['log-type'];
        $comment = $_POST['comment'];
        echo "
        <div class=\"alert alert-success\" role=\"alert\">
            <p>
                You added <strong>$beer_name</strong> by <strong>$beer_maker</strong> to your $log list with comment:
                $comment
            </p>
		</div>";
		// Skip the form but add the footer
    	include('includes/footer.php');
		exit;
    }    

        // TODO: Iterate through the users logged beers and display them 

    include('includes/footer.php');
?>