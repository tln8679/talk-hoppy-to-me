<?php
	ini_set('error_reporting', 1);
	$page_title = 'Register!';
	include("beans/user.php");
	require './includes/header.php';
	require_once '../../mysqli_connect.php'; //$dbc is the connection string set upon successful connection
	$missing = array();	
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (!empty($_POST['fname']))
				$first = trim($_POST['fname']);
			else
				$missing[]= "first";
		
			if (!empty($_POST['lname']))
				$last = trim($_POST['lname']);
			else
				$missing['lname'] = "Last name is missing.";
			
			if (!empty($_POST['email']))
				$email = trim($_POST['email']);
			else
				$missing[] = "Email is missing.";
			// We could process city
			if (!empty($_POST['city']))
				$pwd = trim($_POST['city']);
			else
				$missing[] = "City is missing.";	
			// We could process state
			if (!empty($_POST['state']))
				$pwd = trim($_POST['state']);
			else
				$missing[] = "State is missing.";	
			// Phone
			if (!empty($_POST['phone']))
				$phone = trim($_POST['phone']);
			else
				$missing[] = "Phone is missing.";	
			// Check for password confirmation matches
			if (!empty($_POST['pwd']))
				$pwd = trim($_POST['pwd']);
			else
				$missing[] = "Password is missing.";
			if (!empty($_POST['conf']))
				$conf = trim($_POST['conf']);
			else
				$missing[] = "Password confirmation is missing";	
			if ($pwd != $conf) {
				$missing[] = "The passwords do not match";
			}
			if (!empty($_POST['city']))
				$city = trim($_POST['city']);
			else
				$city = NULL;	
			if (!empty($_POST['state']))
				$state = trim($_POST['state']);
			else
				$state = NULL;
			// This is where we will check to see if the email is already in use. If not, insert new user in the database.
			// Need to also add a default avatar image to images and then insert that path for every user
			if (empty($missing)){
				require_once '../../mysqli_connect.php';  //$dbc is the connection string set upon successful connection
				$newUser = new User($first,$last,"/path/to/file",$email,$pwd,$phone,$city,$state); 
				$q = "SELECT * FROM USERS WHERE EMAIL = ?";
				$stmt = mysqli_prepare($dbc,$q);
				mysqli_stmt_bind_param($stmt,'s',$email);
				$email = $newUser->getEmail();
				mysqli_stmt_execute($stmt);
				$stmt->store_result();
				$count = $stmt->num_rows;
				echo count;
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
						<p>We will not send you an email</p>
						</div>";
					}
					else 
					echo "<div class=\"alert alert-info\" role=\"alert\">
						<p>We're sorry, we were not able to add you at this time.</p>
						</div>";
					include 'includes/footer.php';
					exit;
			}
		}
    }    
?>

<form method="POST" action="registration.php" class="justify-content-center">
	<fieldset>
		<?php if ($missing)
				echo "<div class=\"alert alert-danger\" role=\"alert\">
				<p>Please check the following issues <strong><br>";
				foreach($missing as $missed){
					echo '+ '.$missed."<br>";
				}
				echo "</strong></p></div>";
			?>
		<div class="form-group w3-margin-bottom cntr-form">
			<legend>
				<h2>Thanks for joining!</h2>
			</legend>
		</div>
		
		<div class="form-group w3-margin-bottom cntr-form">
			<label>
				<h4>Basics</h4>
			</label>
			<p>
				<label for="fname">First name</label>
				<span style="color:red">*</span>
				<input type="text" id="fname" name="fname" <?php if(isset($first)) echo " value=\"$first\""; else echo "placeholder=\"First name\""?> class="form-control" required>
			</p>
			<p>
				<label for="lname">Last name</label>
				<span style="color:red">*</span>
				<input type="text" id="lname" name="lname" placeholder="Last name" <?php if(isset($last)) echo " value=\"$last\"";?> class="form-control" required>
			</p>
			<p>
				<label for="email">Email</label>
				<span style="color:red">*</span>
				<input id="email" style="width:250px" type="text" name="email" placeholder="Email address" <?php if(isset($email)) echo " value=\"$email\"";?> class="form-control"
				required>
			</p>
			<p>
				<label for="password">Password</label>
				<span style="color:red">*</span>
				<input type="password" id="password" style="width:250px" name="pwd" placeholder="New password" class="form-control"
				 required>
			</p>
			<p>
				<label for="conf">Re-enter password</label>
				<span style="color:red">*</span>
				<input type="password" id="confirm-password" style="width:250px" name="conf" placeholder="Confirm password" class="form-control"
				 required>
			</p>
		</div>
		<div class="form-group w3-margin-bottom cntr-form">
			<label>
				<h4>Address</h4>
			</label>
			<!-- <p>
				<label for="street">Street</label>
				<span style="color:red">*</span>
				<input type="text" id="street" name="street" placeholder="Street" class="form-control" required>
			</p> -->
			<p>
				<label for="city">City</label>
				<span style="color:red">*</span>
				<input type="text" id="city" name="city" placeholder="City" class="form-control" <?php if(isset($city)) echo " value=\"$city\"";?> max-length="50" required>
			</p>
			<p>

				<label for="state">State</label>
				<span style="color:red">*</span>
				<input type="text" id="state" name="state" placeholder="State" class="form-control" <?php if(isset($state)) echo " value=\"$state\"";?> max-length="2" required>
			</p>
			<!-- <p>
				<label for="zip">Zip code</label>
				<span style="color:red">*</span>
				<input type="text" id="zip" name="zip" placeholder="Zip" class="form-control" required>
			</p> -->
		</div>
		<div class="form-group w3-margin-bottom cntr-form">
			<p>
				<label for="phone">
					<h4>Phone number</h4>
				</label>
				<input type="text" class="form-control" name="phone" placeholder="9109999999" <?php if(isset($phone)) echo " value=\"$phone\"";?> maxlength="12" />
				<select id="phonetype" name="phonetype">
					<option value="mobile" class="form-control">Mobile</option>
					<option value="home" class="form-control">Home</option>
					<option value="office" class="form-control">Office</option>
				</select>
			</p>
		</div>
		<!-- <div class="form-group">
			<br>
			<label>
				<h4>Preferred method of contact</h4>
			</label><br>
			<p>
				<label for="contact">
					<input type="radio" name="contact" value="text" id="contact"> Text
				</label>
				<br>
				<label for="emailr">
					<input type="radio" name="contact" value="email" id="emailr"> Email
				</label>
				<br>
				<label for="postalr">
					<input type="radio" name="contact" value="postal" id="postalr"> Postal
				</label>
			</p>
		</div> -->
		<div class="form-group w3-margin-bottom cntr-form">
			<label for="terms">
				<h5 style="color:red">Agree to terms</h5>
			</label>
			<input type="checkbox" id="terms" name="terms" required>
			<p>
				<input type="submit" name="submit" value="Register" class="btn btn-primary">
			</p>
		</div>
	</fieldset>
</form>
<?php
    include('includes/footer.php');
?>