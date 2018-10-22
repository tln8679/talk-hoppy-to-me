<?php
	$page_title = 'Register!';
    include('includes/header.php');
?>

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_REQUEST['fname'] . ' ' . $_REQUEST['lname'];
        echo "<div class=\"alert alert-success\" role=\"alert\">
		<p>Thanks for registering <strong>$name</strong></p>
		</div>";
		// Skip the form but add the footer
    	include('includes/footer.php');
		exit;
    }    
?>

<form method="POST" action="registration.php">
	<fieldset>
		<legend>
			<h2>Thanks for joining!</h2>
		</legend>
		<label>
			<h4>Basics</h4>
		</label>
		<div class="form-group">
			<br>
			<p>
				<label for="fname">First name</label>
				<span style="color:red">*</span>
				<input type="text" id="fname" name="fname" placeholder="First name" class="form-control" required>
			</p>
			<p>
				<label for="lname">Last name</label>
				<span style="color:red">*</span>
				<input type="text" id="lname" name="lname" placeholder="Last name" class="form-control" required>
			</p>
			<p>
				<label for="email">Email</label>
				<span style="color:red">*</span>
				<input id="email" style="width:250px" type="text" name="email" placeholder="Email address" class="form-control"
				 required>
			</p>
			<p>
				<label for="password">Password</label>
				<span style="color:red">*</span>
				<input type="password" id="password" style="width:250px" name="password" placeholder="New password" class="form-control"
				 required>
			</p>
			<p>
				<label for="confirm-password">Re-enter password</label>
				<span style="color:red">*</span>
				<input type="password" id="confirm-password" style="width:250px" name="confirm-password" placeholder="Confirm password"
				 class="form-control" required>
			</p>
		</div>
		<br>
		<label>
			<h4>Address</h4>
		</label>
		<div class="form-group">
			<br>
			<p>
				<label for="street">Street</label>
				<span style="color:red">*</span>
				<input type="text" id="street" name="street" placeholder="Street" class="form-control" required>
			</p>
			<p>
				<label for="city">City</label>
				<span style="color:red">*</span>
				<input type="text" id="city" name="city" placeholder="City" class="form-control" required>
			</p>
			<p>

				<label for="state">State</label>
				<span style="color:red">*</span>
				<input type="text" id="state" name="state" placeholder="State" class="form-control" required>
			</p>
			<p>
				<label for="zip">Zip code</label>
				<span style="color:red">*</span>
				<input type="text" id="zip" name="zip" placeholder="Zip" class="form-control" required>
			</p>
		</div>
		<div class="form-group">
			<br>
			<p>
				<label for="phone">
					<h4>Phone number</h4>
				</label>
				<input type="text" class="form-control" name="phone" placeholder="910-999-9999" maxlength="12" />
				<select id="phonetype" name="phonetype">
					<option value="mobile" class="form-control">Mobile</option>
					<option value="home" class="form-control">Home</option>
					<option value="office" class="form-control">Office</option>
				</select>
			</p>
		</div>
		<div class="form-group">
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
		</div>
		<label for="terms">
			<h5 style="color:red">Agree to terms</h5>
		</label>
		<input type="checkbox" id="terms" name="terms" required>

		<p>
			<input type="submit" name="submit" value="Register" class="btn btn-primary">
		</p>
	</fieldset>
</form>
</div>
<?php
    include('includes/footer.php');
?>