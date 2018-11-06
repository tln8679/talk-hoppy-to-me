<?php
    $page_title = 'Login, yum!';
	// Include header html here
    include('includes/header.php');
    require_once '../../mysqli_connect.php';
?>

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // echo '<div class="alert alert-warning" role="alert"><p> Sorry!</p>
        // <p class="text-danger">No database created, yet.</p></div>';
        if (!empty($_POST['email']))
				$mail = trim($_POST['email']);
		else
			$missing[] = "Email is missing.";
        if (!empty($_POST['password']))
			$password = trim($_POST['password']);
		else
            $missing[] = "Password is missing.";
        
        if ($missing){
            echo "<div class=\"alert alert-danger\" role=\"alert\">
				<p>Please check the following issues <strong><br>";
				foreach($missing as $missed){
					echo '+ '.$missed."<br>";
				}
				echo "</strong></p></div>";
        }
        else {
            // Prepare statement
            $q = "SELECT PASS FROM USERS WHERE EMAIL = ?";
            $stmt = mysqli_prepare($dbc,$q);
            // Bind and execute
			mysqli_stmt_bind_param($stmt,'s',$email);
			$email = $mail;
            mysqli_stmt_execute($stmt);
            // Get results and get the password hash
			$stmt_result = $stmt->get_result();
            $count = $stmt_result->num_rows;
            if ($stmt_result->num_rows==1){
                while($row = $stmt_result->fetch_assoc()) {
                    $hashAndSalt = $row['PASS'];
                }
            }
            // Fetch hash+salt from database, place in $hashAndSalt variable
            // and then to verify $password:
            if (password_verify($password, $hashAndSalt)) {     
                echo "<div class=\"alert alert-success\" role=\"alert\">
				<p>Success! You are now logged in! <strong><br></p></div>";
            }
            else {
                echo "<div class=\"alert alert-danger\" role=\"alert\">
				<p>Password or email is incorrect <strong><br></p></div>";
            }
        }
    }    
?>

<div class="form-group w3-margin-bottom text-center\"">
    <form method="POST" action="login.php" class="justify-content-center">

        <fieldset>
            <legend>
                <h2>Welcome back!</h2>
            </legend>
            <div class="row justify-content-center col-lg-6 offset-lg-3">
                <p>
                    <label for="email">Email</label>
                    <span style="color:red">*</span>
                    <input id="email" style="width:250px" type="text" name="email" placeholder="Enter email" <?php if(isset($email)) echo " value=\"$email\"";?> class="form-control"
                        required>
                </p>
                <p>
                    <label for="password">Password</label>
                    <span style="color:red">*</span>
                    <input type="password" id="password" style="width:250px" name="password"  placeholder="Enter password"
                        class="form-control" required>
                </p>
                <input type="submit" name="submit" value="Login" class="btn btn-primary">
            </div>
        </fieldset>
    </form>
</div>
<?php
    include('includes/footer.php');
?>