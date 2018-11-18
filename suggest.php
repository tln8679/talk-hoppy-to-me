<?php 
    /* 
    *  This page displays all beers and will have a search function. When the user chooses to add one to a list 
    *  this same page loads with a form to add a comment and confirm the addition. User taken to 
    *  log/love/or later.php to see their full list.
    */

    $page_title = 'Beers, yum!';
    include('includes/header.php');
    include("beans/suggestion.php");
    require_once '../../mysqli_connect.php';

	if (isset($_POST['submit'])) {
	
		// Create scalar variables for the form data:
		if (!empty($_POST['suggestion']))
			$suggestion = filter_var($_POST['suggestion'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		else
			$missing[] = "name";
		$nature = $_POST['nature'];

		if ($missing) { //There is at least one element in the $missing array
			echo 'You forgot the following form item(s):<br>';
			//output the contents of the array
			foreach($missing as $missed){
				echo '-'.$missed."<br>";
			}
		}
		else{
      // This is where we will insert the suggestion into the database
      // Admins will then be able to view the Suggestion

			//Form was filled out completely and submitted. Print the submitted information:
			echo "<p>Thank you, for the following comments:<br>";
			echo "<pre>\"$suggestion\"</pre>"; //HTML pre is preformatted text. We are assuming the comment is non-malicious
			include('includes/footer.php'); 
			exit;
		}
	}
?>

<div class="w3-row-padding">
    <div class="w3-container w3-card w3-white w3-margin-bottom">
        <legend>
            <h2 class="w3-text-grey w3-padding-16" style="text-align: center;"><i class="fa fa-suitcase fa-fw w3-xxlarge w3-text-indigo">Make a suggestion!</i></h2>
        </legend>
            <div class="w3-container">
                <h4> 
                    <form method="POST" action="login.php">
                    <div class="form-group w3-margin-bottom" style="width:250px; margin: auto;"text-align: center;"> 
                      <label>Nature of your suggestion:</label><br>
                              <select name="nature">
                        <?php
                          if (isset($_POST['submit'])) {
                            echo "<option selected value=\"$nature\">$nature</option>\n";
                          }
                        ?>
                                  <option value="add">Add a beer</option>
                                  <option value="add">Edit a beer</option>
                                  <option value="add">Report a user</option>
                                  <option value="add">Other</option>
                        </select>
                      </label>
                    </div>

                    <div class="form-group w3-margin-bottom" style="width:250px; margin: auto;"text-align: center;"> 
                    <label for="suggestion">Suggestion:</label>
                      <textarea
                        name="suggestion"
                        class="form-control"
                        rows="5"
                        id="comment">
                        <?php if(isset($description)) echo $suggestion;?>
                      </textarea>
                    </div>
                    <div class="form-group w3-margin-bottom" style="text-align: center;">           
                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                    </div>
        </div>
    </div>
</div>
<?php
    include('includes/footer.php');
?>