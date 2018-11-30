<?php
	ini_set('error_reporting', 1);
	$page_title = 'Register!';
	include("beans/user.php");
	require './includes/header.php';
	require_once '../../mysqli_connect.php'; //$dbc is the connection string set upon successful connection
	$error_message = array();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (!empty($_POST['fname']))
				$first = filter_var(trim($_POST['fname']), FILTER_SANITIZE_STRING);
			else
				$error_message[]= "first";

			if (!empty($_POST['lname']))
				$last = filter_var(trim($_POST['lname']), FILTER_SANITIZE_STRING);
			else
				$error_message[] = "Last name is missing.";

			$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
			if (!filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) { //Either empty or invalid email will be considered missing
				$error_message[] = 'email';
			}
			// We could process city
			if (!empty($_POST['city']))
				$city = filter_var(trim($_POST['city']), FILTER_SANITIZE_STRING);
			else
				$error_message[] = "City is missing.";
			// We could process state
			if (!empty($_POST['state']))
				$state = filter_var(trim($_POST['state']), FILTER_SANITIZE_STRING);
			else
				$error_message[] = "State is missing.";
			// Phone
			if (!empty($_POST['phone'])){
				// Remove any non-digits
				$phone = preg_replace('/[^0-9]/', '', $_POST['phone']);
				//  Validate we have area code (3) + 7 numbers
				if(strlen($phone) !== 10) {
					$error_message[] = "Your phone number should be 10 characters";
				}
			}
			else
				$error_message[] = "Phone is missing.";
			// Check for password confirmation matches
			if (!empty($_POST['pwd']))
				$pwd = filter_var(trim($_POST['pwd']), FILTER_SANITIZE_STRING);
			else
				$error_message[] = "Password is missing.";
			if (!empty($_POST['conf']))
				$conf = filter_var(trim($_POST['conf']), FILTER_SANITIZE_STRING);
			else
				$error_message[] = "Password confirmation is missing";
			if ($pwd != $conf) {
				$error_message[] = "The passwords do not match";
			}

			// This is where we will check to see if the email is already in use. If not, insert new user in the database.
			// Need to also add a default avatar image to images and then insert that path for every user
			if (empty($error_message)){
				require_once '../../mysqli_connect.php';  //$dbc is the connection string set upon successful connection
				$newUser = new User($first,$last,"/imgs/user.png",$email,$phone,$city,$state); 
				$q = "SELECT * FROM USERS WHERE EMAIL = ?";
				$stmt = mysqli_prepare($dbc,$q);
				mysqli_stmt_bind_param($stmt,'s',$email);
				mysqli_stmt_execute($stmt);
				$stmt->store_result();
				$count = $stmt->num_rows;

				if ($count>0){
					echo "<div class=\"alert alert-info\" role=\"alert\">
						<p><strong>$email</strong> is already in use!</p>
						<p>We will not send you an email</p>
						</div>";
					include 'includes/footer.php';
					exit;
				}
				else{
					// Prepare and bind
					$q = "INSERT INTO USERS(FIRST_NAME, LAST_NAME, AVATAR, EMAIL, PASS, PHONE, CITY, STATE) VALUES (?,?,?,?,?,?,?,?)";
					$stmt = mysqli_prepare($dbc,$q);
					$hash_for_user = password_hash($pwd,PASSWORD_BCRYPT);
					// 'ssssssss' declares the types that we are inserting
					mysqli_stmt_bind_param($stmt,'ssssssss',$fname, $lname, $avatar, $email,$pwd,$phone, $city, $state);
					//  Set parameters and execute

					$fname = $newUser->getFirstName();
					$lname = $newUser->getLastName();
					$avatar = $newUser->getAvatar();
					$email = $newUser->getEmail();
					$pwd = $hash_for_user;
					$phone = $newUser->getPhoneNumber();
					$city = $newUser->getCity();
					$state = $newUser->getState();
					mysqli_stmt_execute($stmt);
					if(mysqli_stmt_affected_rows($stmt)) { //It worked
						$name = $first . ' ' . $last;
						echo "<div class=\"alert alert-success\" role=\"alert\">
						<p>Thanks for registering <strong>$name</strong></p>
						<p>Please <a href=\"login.php\">login!</a></p>
						</div>";
					}
					else{
						echo "<div class=\"alert alert-info\" role=\"alert\">
							<p>We're sorry, we were not able to add you at this time.</p>
							</div>";
					}
					include 'includes/footer.php';
					exit;
			}
		}
		else if ($error_message){
				echo "<div class=\"alert alert-danger\" role=\"alert\">
				<p>Please check the following issues <strong><br>";
				foreach($error_message as $missed){
					echo '+ '.$missed."<br>";
				}
				echo "</strong></p></div>";
		}
    }
?>

<div class="w3-row-padding">
    <div class="w3-container w3-card w3-white w3-margin-bottom">
            <legend>
                <h2 class="w3-text-grey w3-padding-16" style="text-align: center;"><i class="fa fa-suitcase fa-fw w3-xxlarge w3-text-indigo">Thanks for joining!</i></h2>
            </legend>    
            <div class="w3-container">
                
                    <form method="POST" action="registration.php">
                    <div class="form-group w3-margin-bottom" style="text-align: center;"> 
						<p>
							<label for="fname">First name</label>
							<span style="color:red">*</span>
							<input type="text" id="fname" style="width:250px; margin: auto;" name="fname" <?php if(isset($first)) echo " value=\"$first\""; else echo "placeholder=\"First name\""?> class="form-control" required>
						</p>
						<p>
							<label for="lname">Last name</label>
							<span style="color:red">*</span>
							<input type="text" id="lname" style="width:250px; margin: auto;" name="lname" placeholder="Last name" <?php if(isset($last)) echo " value=\"$last\"";?> class="form-control" required>
						</p>
						<p>
							<label for="email">Email</label>
							<span style="color:red">*</span>
							<input id="email" style="width:250px; margin: auto;" type="text" name="email" placeholder="Email address" <?php if(isset($email)) echo " value=\"$email\"";?> class="form-control"
							required>
						</p>
						<p>
							<label for="password">Password</label>
							<span style="color:red">*</span>
							<input type="password" id="password" style="width:250px; margin: auto;" name="pwd" placeholder="New password" class="form-control"
							required>
						</p>
						<p>
							<label for="conf">Re-enter password</label>
							<span style="color:red">*</span>
							<input type="password" id="confirm-password" style="width:250px; margin: auto;" name="conf" placeholder="Confirm password" class="form-control"
							required>
						</p>
                    </div>
                    <div class="form-group w3-margin-bottom" style="text-align: center;"> 
						<p>
							<label for="city">City</label>
							<span style="color:red">*</span>
							<input type="text" id="city" name="city" style="width:250px; margin: auto;" placeholder="City" class="form-control" <?php if(isset($city)) echo " value=\"$city\"";?> max-length="50" required>
						</p>
						<p>

							<label for="state">State</label>
							<span style="color:red">*</span>
							<input type="text" id="state" name="state" style="width:250px; margin: auto;" placeholder="State" class="form-control" <?php if(isset($state)) echo " value=\"$state\"";?> max-length="2" required>
						</p>
					</div>
                    <div class="form-group w3-margin-bottom" style="text-align: center;"> 
						<p>
							<label for="phonetype">
								Phone number
							</label>
							<input type="text" class="form-control" style="width:250px; margin: auto;" name="phone" placeholder="9109999999" <?php if(isset($phone)) echo " value=\"$phone\"";?> maxlength="12" />
							<select id="phonetype" name="phonetype">
								<option value="mobile" class="form-control">Mobile</option>
								<option value="home" class="form-control">Home</option>
								<option value="office" class="form-control">Office</option>
							</select>
						</p>
					</div>
                    <div class="form-group w3-margin-bottom" style="text-align: center;">           
                        <input type="submit" name="submit" value="Add" class="btn btn-primary">
                    </div>
                    </form>
                
            </div>
    </div>
</div>
<?php

	// Make the links to other pages, if necessary.
	if ($pages > 1) {
		echo '<p>';
		// Determine what page the script is on:
		$current_page = ($start/$display) + 1;
		// If it's not the first page, make a Previous link:
		if ($current_page != 1) {
			echo '<a href="UserSearch.php?s=' . ($start - $display) . '&p=' . $pages . '">Previous</a> ';
		}
		// Make all the numbered pages:
		for ($i = 1; $i <= $pages; $i++) {
			if ($i != $current_page) {
				echo '<a href="UserSearch.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '">' . $i . '</a> ';
			} else {
				echo $i . ' ';
			}
		} // End of FOR loop.
		// If it's not the last page, make a Next button:
		if ($current_page != $pages) {
			echo '<a href="UserSearch.php?s=' . ($start + $display) . '&p=' . $pages . '">Next</a>';
		}
		echo '</p>'; // Close the paragraph.
	}

    include('includes/footer.php');
?>
