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

<div class="col-md-4 col-md-offset-4 w3-margin-bottom text-center">
  <form class="justify-content-center" method="POST" action="suggest.php">
    <fieldset>
      <legend><h2>Make a suggestion!</h2></legend>
      <div class="input-group w3-margin-bottom cntr-form">
        <div class="form-group">
            <label>Nature of your suggestion:</label>
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
		    </label></p>
        </div>
        <div class="form-group">
          <label for="suggestion">Suggestion:</label>
          <textarea
            name="suggestion"
            class="form-control"
            rows="5"
            id="comment"
          ><?php if(isset($description)) echo " value=\"$suggestion\"";?></textarea>
        </div>
      </div>
      <p>
        <span class="input-group-btn">
          <input
            type="submit"
            name="submit"
            value="Submit"
            class="btn btn-primary"
          />
        </span>
      </p>
    </fieldset>
  </form>
</div>
<?php
    include('includes/footer.php');
?>