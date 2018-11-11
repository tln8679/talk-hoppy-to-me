<?php
    $page_title = 'Login, yum!';
	// Include header html here
    include('includes/header.php');
    require_once '../../mysqli_connect.php';
    require_once './beans/user.php'
?>

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // echo '<div class="alert alert-warning" role="alert"><p> Sorry!</p>
        // <p class="text-danger">No database created, yet.</p></div>';
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
                        $_SESSION['firsttName'] = $row['LAST_NAME'];
                        $_SESSION['lastName'] = $row['LAST_NAME'];
                        $_SESSION['avatar'] = $row['AVATAR'];
                        $_SESSION['email'] = $row['EMAIL'];
                        $_SESSION['phone'] = $row['PHONE'];
                        $_SESSION['city'] = $row['CITY'];
                        $_SESSION['state'] =  $row['STATE'];
                        $_SESSION['admin '] = $row['IS_ADMIN'];
                        $url = 'http://'. $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
                        $url = rtrim($url, '/\\');
                        $page = 'profile.php';
                        $url .= '/' . $page;
                        header("Location: $url");
                        exit();
                    }
                    else {
                        echo "<div class=\"alert alert-danger\" role=\"alert\">
                        <p>Password or email is incorrect <strong><br></p></div>";
                    }
                }
            }
            else {
                echo "<div class=\"alert alert-danger\" role=\"alert\">
				<p>Can't connect right now <strong><br></p></div>";
            }
        }
    } 
    if (isset($_SESSION['email'])) {
        $firstname = $_SESSION['firstName'];
        $message = "You have reached this page in error.";
        $message2 = "Hit log out on the menu, if you want to log out";
        echo "<div class=\"alert alert-success\" role=\"alert\">
            <p><h2>$message</h2><br></p>
            <p><h3>$message2</h3><br></p>
            </div>";
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