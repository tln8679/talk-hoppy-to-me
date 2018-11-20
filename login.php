<?php
    $page_title = 'Login, yum!';
	// Include header html here
    include('includes/header.php');
    require_once '../../mysqli_connect.php';
    require_once './beans/user.php';
?>

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $mail = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
	    if (!filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) { //Either empty or invalid email will be considered missing
            $missing[] = 'email';
        }
        if (!empty($_POST['password']))
			$password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
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
            $q = "SELECT * FROM USERS WHERE EMAIL = ?";
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
                    // Fetch hash+salt from database, place in $hashAndSalt variable
                    // and then to verify $password:
                    if (password_verify($password, $hashAndSalt)) {     
                        session_start();
                        $_SESSION['usersID'] = $row['USERS_ID'];
                        $_SESSION['firstName'] = $row['FIRST_NAME'];
                        $_SESSION['lastName'] = $row['LAST_NAME'];
                        $_SESSION['avatar'] = $row['AVATAR'];
                        $_SESSION['email'] = $row['EMAIL'];
                        $_SESSION['phone'] = $row['PHONE'];
                        $_SESSION['city'] = $row['CITY'];
                        $_SESSION['state'] =  $row['STATE'];
                        $_SESSION['admin'] = $row['IS_ADMIN'];
                        $url = 'http://'. $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
                        $url = rtrim($url, '/\\');
                        $page = 'profile.php';
                        $url .= '/' . $page;
                        header("Location: $url");
                        exit();
                    }
                    else {
                        echo "<div class=\"alert alert-danger\" role=\"alert\">
                        <p>Password or email is incorrect<br></p></div>";
                    }
                }
            }
            else {
                echo "<div class=\"alert alert-danger\" role=\"alert\">
				<p>Can't connect right now. Ensure your email is correct.<br></p></div>";
            }
        }
    } 
?>

<div class="w3-row-padding">
    <div class="w3-container w3-card w3-white w3-margin-bottom">
        <div class="w3-container">
                <form method="POST" action="login.php">
                    <fieldset>
                        <legend class="w3-text-grey w3-padding-16" style="text-align: center;">
                            <i class="fa fa-suitcase fa-fw w3-xxlarge w3-text-indigo">Log in</i>
                        </legend>
                        <div class="form-group w3-margin-bottom" style="text-align: center;"> 
                            <label for="email">Email</label>
                            <span style="color:red">*</span>
                            <input id="email" style="width:250px; margin: auto;" type="text" name="email" placeholder="Enter email" <?php if(isset($email)) echo " value=\"$email\"";?> class="form-control"
                                    required>
                        </div>
                        <div class="form-group w3-margin-bottom" style="text-align: center;"> 
                            <label for="password">Password</label>
                            <span style="color:red">*</span>
                            <input type="password" id="password" style="width:250px; margin: auto;" name="password"  placeholder="Enter password"
                            class="form-control" required>
                        </div>
                        <div class="form-group w3-margin-bottom" style="text-align: center;">           
                            <input type="submit" name="submit" value="Login" class="btn btn-primary">
                        </div>
                </fieldset>
                </form>
        </div>
    </div>
</div>

<?php
    include('includes/footer.php');
?>