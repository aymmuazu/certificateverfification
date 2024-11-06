<?php
	require 'core.inc.php';
	include('header.php');
?>

<title>Register - Auth</title>

<div class="container pt-5 mb-5">
	<h2 class="mb-4 fw-bolder">Registration System</h2>

<?php 

if(!loggedin())
{
	if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['password_confirm'])&&isset($_POST['firstname'])&&isset($_POST['surname']))
	{
		$username = trim($_POST['username']);
		
		$password = trim($_POST['password']);
		$password_again = trim($_POST['password_confirm']);
		
		$firstname = trim($_POST['firstname']);
		$surname = trim($_POST['surname']);
		if(!empty($username)&&!empty($password)&&!empty($password_again)&&!empty($firstname)&&!empty($surname))
		{
			if(strlen($username)>30||strlen($firstname)>30||strlen($surname)>30)
			{
				echo '<div class="alert alert-warning">Please adhere to maxlength of fields.</div>';
			}
			else
			{
				if($password!=$password_again)
				{
					echo '<div class="alert alert-warning">Passwords do not match.</div>';
				}
				else
				{
					$password_hash = md5($password);

					$query = "SELECT username FROM users WHERE username = :username";
					$statement = $con->prepare($query);
					$statement->execute(['username'=>$username]);
					$count = $statement->rowCount();
					$fetch = $statement->fetch(PDO::FETCH_OBJ);
					
					if($count > 0)
					{
						echo '<div class="alert alert-warning">The username '.$fetch->username.' already exists.</div>';
					}
					else
					{

						$query = "INSERT INTO users (username,`password`,firstname,surname,role, created_at) 
									VALUES(:username, :pass, :firstname, :surname, :role, :created_at)";
						try {
							$time = time();
							$statement = $con->prepare($query);
							$params = [
								':username' => $username,
								':pass' => $password_hash,
								':firstname' => $firstname,
								':surname' => $surname,
								':role' => 'user',
								':created_at' => date('Y-m-d h:m::s')
							];

							$statement->execute($params);
							header('Location: register_success.php');

						} catch (PDOException $e) {
							//$errors[] = $e->getMessage();
							echo '<div class="alert alert-warning">Something went wrong try again please.</div>';
						}
					}
				}
			}
		}
		else
		{
			echo '<div class="alert alert-warning">All fields are required.</div>';
		}
	}
?>

<p></p>
	<div class="col-md-5" style="padding: 20px; border: 2px solid #c0c0c0; border-radius: 10px;">

<form action="register.php" method="POST">
	<div class="form-group">
		<label for="">Username</label>
		<input type="text" name="username" class="form-control" maxlength="20">
	</div>
	<div class="form-group pt-3">
		<label for="">Password</label>
		<input type="password" name="password" class="form-control" maxlength="20">
	</div>
	<div class="form-group pt-3">
		<label for="">Confirm Password</label>
		<input type="password" name="password_confirm" class="form-control" maxlength="20">
	</div>
	<div class="form-group pt-3">
		<label for="">First Name</label>
		<input type="text" name="firstname" class="form-control" maxlength="20">
	</div>
	<div class="form-group pt-3">
		<label for="">Surname</label>
		<input type="text" name="surname" class="form-control" maxlength="20">
	</div>

	<div class="form-group pt-4">
		<input type="submit" class="btn btn-dark w-100" value="Register">
	</div>

	<p class="pt-4">
		Already have an account ? <a href="home.php">Login</a>
	</p>
</form>

<?php
}
else if(loggedin())
{
	echo 'You\'re already registered and logged in.';
}
?>

</div>
</div>
<?php

	include('footer.php');

?>
