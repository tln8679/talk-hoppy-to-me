</div>
<footer class="footer">
	<div class="container">
		<p class="text-muted">
			<p>
				<?php
					// show admin and regular page toggles for admins
					$dir = dirname($_SERVER['PHP_SELF']);
					// Currently on user pages so show admin switch
					if (isset($_SESSION['admin']) && $_SESSION['admin']==1 && !strpos($dir, 'administration')){
				?>
					<a href="contact.php">
						<span class="glyphicon glyphicon-envelope"></span>
						About us 
					</a>  
					<a href="credits.php">
						<span class="glyphicon glyphicon-camera"></span>
						Image credits
					</a> 
					<a href="suggest.php">
						<span class="glyphicon glyphicon-comment"></span>
						Make suggestions
					</a> 
					<a href="administration/ViewUsers.php">
						<span class="glyphicon glyphicon-queen"></span>
						Admin pages
					</a> 
				<?php
					// Close if statement
					}
					// User is on admin pages so show switch back to regular pages
					if (isset($_SESSION['admin']) && $_SESSION['admin']==1 && strpos($dir, 'administration')){
				?>
					<a href="../contact.php">
						<span class="glyphicon glyphicon-envelope"></span>
						About us 
					</a>  
					<a href="../credits.php">
						<span class="glyphicon glyphicon-camera"></span>
						Image credits
					</a> 
					<a href="../suggest.php">
						<span class="glyphicon glyphicon-comment"></span>
						Make suggestions
					</a> 
					<a href="../index.php">
						<span class="glyphicon glyphicon-backward"></span>
						Back to user site
					</a> 
				<?php
					// Close if statement
					}
					// User is not an admin
					else{
				?>
					<a href="contact.php">
						<span class="glyphicon glyphicon-envelope"></span>
						About us 
					</a>  
					<a href="credits.php">
						<span class="glyphicon glyphicon-camera"></span>
						Image credits
					</a> 
					<a href="suggest.php">
						<span class="glyphicon glyphicon-comment"></span>
						Make suggestions
					</a> 
				<?php
					// Close if statement
					}
				?>
		</p>
	</div>
</footer>
</body>

</html>