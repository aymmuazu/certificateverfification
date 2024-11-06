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


    try {
     
        $query = "SELECT id, user_id, cert_id, invoice_no, status, created_at, updated_at FROM payments WHERE user_id=:user_id";
        $statement = $con->prepare($query);
        $statement->bindValue(':user_id', $userId);
        $statement->execute();
        $payments = $statement->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

?>
<title>Certificate Verification System</title>

<div class="container pt-5 mb-5">
	<h3 class="mb-4 fw-bold">Welcome <?= $firstname; ?>, <span class="badge bg-dark"><?= ucwords($role) ?></span></h3>
    <a href="home.php" class="btn btn-dark fw-bold">< Go Back </a>
    <hr>
	<div class="container mt-2 mb-2">
		<div class="row">
			<h3 class="mb-4 fw-bolder">My Payments</h3>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Payee</th>
                        <th>Certificate</th>
                        <th>Invoice No</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payments as $payment): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($payment->id); ?></td>
                            <td>
                                <?php 
                                    $query = "SELECT * FROM users WHERE id=:id";
                                    $statement = $con->prepare($query);
                                    $statement->bindValue(':id', $payment->user_id);
                                    $statement->execute();
                                    $user = $statement->fetch(PDO::FETCH_OBJ);
                                    echo '<b>'.$user->firstname.''.$user->surname.'</b> <br />';
                                    echo '<b>'.$user->username.'</b>';
                                ?>
                            </td>
                            <td>
                                <?php
                                    $query = "SELECT * FROM certificates WHERE id=:id";
                                    $statement = $con->prepare($query);
                                    $statement->bindValue(':id', $payment->cert_id);
                                    $statement->execute();
                                    $cert = $statement->fetch(PDO::FETCH_OBJ);
                                    if ($cert) {
                                        echo '<b>'.$cert->cert_no.'</b>';   
                                    }else{
                                        echo '<b class="text-danger">No certificate available.</b>';
                                    }
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($payment->invoice_no); ?></td>
                            <td><span class="badge bg-dark"><?php echo strtoupper($payment->status); ?></span></td>
                            <td><?php echo htmlspecialchars($payment->created_at); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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