<?php 

require 'core.inc.php';
require 'connect.php';
require 'queries.php';

if(loggedin())
{
	include('header.php');

	$firstname = getuserfield('firstname');
	$surname = getuserfield('surname');
	$userId = getuserfield('id');
	$role = getuserfield('role');

?>
<title>Certificate Verification System</title>

<div class="container pt-5 mb-5">
	<h3 class="mb-4 fw-bold">Welcome <?= $firstname; ?>, <span class="badge bg-dark"><?= ucwords($role) ?></span></h3>

	<div class="container mt-5 mb-5">
		<div class="row">
			<?php
				switch ($role) {
					case 'user':
				?>
					<?php
						include('container.php');
					?>
				<?php
					break;
					case 'admin':
				?>
					<div class="col-md-5">
						<a href="certificates.php" class="btn btn-dark fw-bold w-100 btn-lg mb-2">Certificates (<?=$certificates_count?>)</a>
						<a href="payments.php" class="btn btn-primary fw-bold w-100 btn-lg mb-2">Payments (<?=$payments_count?>)</a>
						<a href="users.php" class="btn btn-dark fw-bold w-100 btn-lg mb-2">Users (<?=$users_count?>)</a>
					</div>
				<?php	
					break;
				}
			?>
		</div>
	</div>

	<hr>
    <a href="logout.php" class="btn fw-bold btn-danger">Log Out</a>
</div>

<?php
	include('footer.php');
}
else
{
	include 'login.php';
}	

?>