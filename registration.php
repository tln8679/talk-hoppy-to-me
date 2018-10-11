<?php
    include('includes/header.html');
?>
	<div class="form-style">
		<form method="POST" action="register.php">
			<fieldset>
				<legend>
					<h2>Thanks for joining!</h2>
				</legend>
				<label>
					<span>Basics</span>
				</label>
				<br>
				<p>
					<label for="fname"></label>
					<span class="required">*</span>
					<input type="text" id="fname" name="fname" placeholder="First name" class="input-field" required>
					<label for="lname"></label>
					<span class="required">*</span>
					<input type="text" id="lname" name="lname" placeholder="Last name" class="input-field" required>
				</p>
				<p>
					<label for="email"></label>
					<span class="required">*</span>
					<input id="email" style="width:250px" type="text" name="email" placeholder="Email address" class="input-field" required>
				</p>
				<p>
					<label for="password"></label>
					<span class="required">*</span>
					<input type="password" id="password" style="width:250px" name="password" placeholder="New password" class="input-field" required>
				</p>
				<p>
					<label for="passwordverification"></label>
					<span class="required">*</span>
					<input type="password" id="passwordverification" style="width:250px" name="passwordverification" placeholder="New password"
					 class="input-field" required>
				</p>
				<br>
				<label>
					<span>Address</span>
				</label>
				<br>
				<label for="street"></label>
				<span class="required">*</span>
				<input type="text" id="street" name="street" placeholder="Street" class="input-field" required>
				<label for="city"></label>
				<span class="required">*</span>
				<input type="text" id="city" name="city" placeholder="City" class="input-field" required>
				<br>
				<label for="state"></label>
				<span class="required">*</span>
				<input type="text" id="state" name="state" placeholder="State" class="input-field" required>
				<label for="zip"></label>
				<span class="required">*</span>
				<input type="text" id="zip" name="zip" placeholder="Zip" class="input-field" required>

				<p>
					<label>
						<span>Phone number</span>
					</label>
					<br>
					<br>
					<label for="phone"></label>
					<input type="text" class="input-field" name="phone" placeholder="910-999-9999" maxlength="12" />
					<select id="phonetype" name="phonetype">
						<option value="mobile" class="input-field">Mobile</option>
						<option value="home" class="input-field">Home</option>
						<option value="office" class="input-field">Office</option>
					</select>
				</p>
				<br>

				<label>
					<span>Preferred method of contact</span>
				</label>

				<br>
				<br>
				<br>
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
				<label for="terms">
					<span>Agree to terms</span>
				</label><br><br><br>
				<input type="checkbox" id="terms" name="terms" class="input-field" required>
				<br><br>
				<p>
					<input type="submit" name="submit" value="Register">
				</p>
			</fieldset>
		</form>
	</div>
<?php
    include('includes/footer.html');
?>