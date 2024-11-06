<?php
	include('header.php');

	if (loggedin()) {
		header('Location: home.php');
	}
?>

<title>Examination Verification System</title>

<div class="container pt-5 mb-5">
	<h2 class="mb-4 fw-bold">Login System</h2>
	<?php 
		if(isset($_POST['username']) && isset($_POST['password']))
		{
			$username = $_POST['username'];
			$password = $_POST['password'];
			
			if(!empty($username) && !empty($password))
			{
				$password_hash = md5($password);
				
				$query = "SELECT id FROM users WHERE username = :username AND password = :password";
				$statement = $con->prepare($query);
				$statement->execute([
					'username'=>$username,
					'password'=>$password_hash,
				]);

				$count = $statement->rowCount();
				$fetch = $statement->fetch(PDO::FETCH_OBJ);

				if ($count > 0) {
					$user_id = $fetch->id;
					$_SESSION['user_id'] = $user_id;
					header('Location: home.php');
				}
				else{
					echo '<div class="alert alert-warning">Invalid Username or Password</div>';
				}
			}
			else
			{
				echo '<div class="alert alert-warning">You must enter a username and password.</div>';
			}
		}
	?>
	<p></p>

	<div class="row">
		<div class="col-md-5" style="padding: 20px; border: 2px solid #c0c0c0; border-radius: 10px;">
			<form action="<?php echo $current_file; ?>" method="POST">
				<div class="form-group">
					<label for="">Username</label>
					<input type="text" name="username" class="form-control" maxlength="20">
				</div>
				<div class="form-group pt-3">
					<label for="">Password</label>
					<input type="password" name="password" class="form-control" maxlength="20">
				</div>
				<div class="form-group pt-4">
					<input type="submit" class="btn btn-dark w-100" value="Log In">
				</div>

				<div class="pt-3">
					<p>Not yet have an account ? <a href="register.php">Register</a></p>
				</div>

			</form>
		</div>
	</div>
</div>
<?php

	include('footer.php');

?>
