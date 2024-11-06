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

    if ($role == 'user') {
        header('Location: logout.php');
    }

?>
<title>Certificate Verification System</title>

<div class="container pt-5 mb-5">
	<?php include('nav.php') ?>

	<div class="container mt-5 mb-5">
		<div class="row">

            <div class="col-md">
                <h3 class="fw-bold">Users</h3>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>First Name</th>
                            <th>Surname</th>
                            <th>Username</th>                            
                            <th>Role</th>
                            <th>Date Joined</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold">Abdurrahim</td>
                                <td class="fw-bolder">Yahya Muazu</td>
                                <td>aymmuazu</td>
                                <td>
                                    <span class="badge bg-primary">USER</span>                                  
                                </td>
                                <td>01-01-2024</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
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