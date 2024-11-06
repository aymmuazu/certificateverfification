<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-form {
            width: 300px;
            padding: 15px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="login-form">
		<?php 
			if(isset($_POST['username']) && isset($_POST['password']))
			{
				$username = $_POST['username'];
				$password = $_POST['password'];
				
				if(!empty($username) && !empty($password))
				{
					$password_hash = md5($password);
					$query = "SELECT id FROM users WHERE username='".mysqli_real_escape_string($mysql_connect, $username)."' AND password='".mysqli_real_escape_string($mysql_connect, $password_hash)."'";
					if($query_run = mysqli_query($mysql_connect, $query))
					{
						$query_run = mysqli_query($mysql_connect, $query);
						
						$query_num_rows = mysqli_num_rows($query_run);
						if($query_num_rows==0)
						{
							echo '<div class="alert alert-warning">Invalid username/password.</div>';
						}
						else if($query_num_rows==1)
						{
							$query_row = mysqli_fetch_assoc($query_run);
							$user_id = $query_row['id'];
							$_SESSION['user_id'] = $user_id;
							header('Location: index.php');
						}
					}
				}
				else
				{
					echo '<div class="alert alert-warning">You must enter a username and password.</div>';
				}
			}
			?>

        <h2 class="text-center">Login</h2>
        <form method="POST" action="<?php echo $current_file; ?>">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" class="form-control" id="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
            </div>
            <div class="form-group text-center">
                <button type="submit" name="submit" class="btn btn-primary btn-block">Login</button>
				<p></p>
				Don't have an acccount? <a href="register.php">Register</a>
            </div>
        </form>
    </div>
</body>
</html>
