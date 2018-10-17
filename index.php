<?php
    $page_title = 'Beer, yum!';
	// Include header html here
    include('includes/header.html');
?>
    <section>
        <h1>What are you drinking tonight?</h1>
        <ul>
            <li>
                <span class="icon-follow"></span> Follow your friends' beer-adventures!
                <br/>
                <br/>
            </li>
            <li>
                <span class="icon-log"></span> Log and rank your favorite brews!
                <br/>
                <br/>
            </li>
            <li>
                <span class="icon-wish"></span> Compete with friends and see who can log the most brews!
            </li>
        </ul>
        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                echo '<div class="alert alert-warning" role="alert"><p> Sorry!</p>
		 <p class="text-danger">No database created, yet.</p></div>';
            }    
        ?>
        <div class="form-style">
            <form method="POST" action="index.php">
                <label for="email"></label>
                <span class="required">*</span>
                <input id="email" style="width:250px" type="text" name="email" placeholder="Email address" class="input-field" required>
                <label for="password"></label>
                <span class="required">*</span>
                <input type="password" id="password" style="width:250px" name="password" placeholder="Password" class="input-field" required>
                <br><br>
                <input type="submit" name="submit" value="Login">
            </form>
        </div>
    </section>
    <aside>
        <img src="imgs/friends.jpg" alt="Photo by ELEVATE from Pexels">
    </aside>
<?php
    include('includes/footer.html');
?>
