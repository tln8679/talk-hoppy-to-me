<?php
    $page_title = 'Beer, yum!';
	// Include header html here
    include('includes/header.html');
?>

<?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                echo '<div class="alert alert-warning" role="alert"><p> Sorry!</p>
		 <p class="text-danger">No database created, yet.</p></div>';
            }    
        ?>

<div class="form-group">
    <form method="POST" action="index.php">

        <fieldset>
            <legend>
                <h2>Welcome back!</h2>
            </legend>
            <div class="row justify-content-center col-lg-6 offset-lg-3">
                <p>
                    <label for="email">Email</label>
                    <span style="color:red">*</span>
                    <input id="email" style="width:250px" type="text" name="email" placeholder="Enter email" class="form-control"
                        required>
                </p>
                <p>
                    <label for="password">Password</label>
                    <span style="color:red">*</span>
                    <input type="password" id="password" style="width:250px" name="password" placeholder="Enter password"
                        class="form-control" required>
                </p>
                <input type="submit" name="submit" value="Login" class="btn btn-primary">
            </div>
        </fieldset>
    </form>
</div>
<?php
    include('includes/footer.html');
?>