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

    $curl = curl_init();
    $reference = isset($_GET['reference']) ? $_GET['reference'] : '';
    if(!$reference){
        header('Location: home.php');
    }
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "accept: application/json",
            "authorization: Bearer ".$secretKey."",
            "cache-control: no-cache"
        ],
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    if($err){
        header('Location: home.php');
    }

    $tranx = json_decode($response);

    if(!$tranx->status){
        header('Location: home.php');
    }
    if('success' == $tranx->data->status){
        $metacert_id = $tranx->data->metadata->cert_id;
        $metauser_id = $tranx->data->metadata->user_id;

        $query = "SELECT * FROM payments WHERE invoice_no=:invoice_no";
        $statement = $con->prepare($query);
        $statement->bindValue(':invoice_no', $reference);
        $statement->execute();
        $payments_count = $statement->rowCount();
        $payments = $statement->fetch(PDO::FETCH_OBJ);

        $date = date('Y-m-d h:i:s');

        if ($payments_count <= 0) {

            // Prepare the SQL insert query
            $query = "INSERT INTO `payments` (`user_id`, `cert_id`, `invoice_no`, `status`, `created_at`, `updated_at`) 
                    VALUES (:user_id, :cert_id, :invoice_no, :status, :created_at, :updated_at)";
            $statement = $con->prepare($query);

            $status = 'paid';             
            $date = date('Y-m-d H:i:s');

            // Bind the parameters to the statement
            $statement->bindValue(':user_id', $metauser_id, PDO::PARAM_INT);
            $statement->bindValue(':cert_id', $metacert_id, PDO::PARAM_INT);
            $statement->bindValue(':invoice_no', $reference, PDO::PARAM_STR);
            $statement->bindValue(':status', $status, PDO::PARAM_STR);
            $statement->bindValue(':created_at', $date, PDO::PARAM_STR);
            $statement->bindValue(':updated_at', $date, PDO::PARAM_STR);
            // Execute the statement
            $statement->execute();
        }

        $query  = "SELECT * FROM certificates WHERE id=:cert_no AND status='active'";
        $statement = $con->prepare($query);
        $statement->bindValue(':cert_no', $metacert_id);
        $statement->execute();
        $cert_no_count = $statement->rowCount();
        $certificatedata = $statement->fetch(PDO::FETCH_OBJ);
        
?>
<title>Certificate Verification System</title>

<div class="container pt-5 mb-5">
	<h3 class="mb-4 fw-bold">Welcome <?= $firstname; ?>, <span class="badge bg-dark"><?= ucwords($role) ?></span></h3>

	<div class="container mt-5 mb-5">
		<div class="row">
			<div class="col-md-5 card bg-dark text-white">
                <div class="card-body">
                    <h2 class="fw-bold">Easy Certificate Verification System</h2>
                    <hr />
                    <h5 class="text-white fw-bold">Payment Verified Successful,</h5>
                    <span>You have successfully paid <b>N500</b> for certificate Verification, look at the right side of the page for vertification information. </span>


                    <a href="home.php" class="btn bg-white text-dark">Go Back Home</a>
                </div>
            </div>

            <div class="col-md">
                <?php
                    if ($cert_no_count <= 0) {
                ?>
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h4 class="fw-bold">Oooops, Something went wrong.</h4>
                            <i>No, information found in such certificate, try again please.</i>
                        </div>
                    </div>
                <?php
                    }else{
                ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-success">Verified Successfully.</div>
                            <table class="table table-bordered">
                                <tr>
                                    <td>Cert. No</td>
                                    <td><?= $certificatedata->cert_no ?></td>
                                </tr>
                                <tr>
                                    <td>Full Name</td>
                                    <td><?= $certificatedata->full_name ?></td>
                                </tr>
                                <tr>
                                    <td>Matric No.</td>
                                    <td><?= $certificatedata->matric_no ?></td>
                                </tr>
                                <tr>
                                    <td>Faculty</td>
                                    <td><?= $certificatedata->faculty_info ?></td>
                                </tr>
                                <tr>
                                    <td>Grade</td>
                                    <td><?= $certificatedata->grade ?></td>
                                </tr>
                                <tr>
                                    <td>Years</td>
                                    <td>
                                        <span>Year of Admission: <b><?= $certificatedata->year_of_admission ?></b> <br /></span>
                                        <span>Year of Graduation: <b><?= $certificatedata->year_of_graduation ?></b> <br /></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Document</td>
                                    <td>
                                        <a href="<?= $certificatedata->passport ?>" class="btn btn-dark btn-sm">View Graduate Passport</a>
                                        <a href="<?= $certificatedata->statement ?>" class="btn btn-dark btn-sm">View Graduate Result/Certificate</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                <?php
                    }
                ?>

            </div>
		</div>
	</div>

	<hr>
    <a href="logout.php" class="btn fw-bold btn-danger">Log Out</a>
</div>

<?php
    }
	include('footer.php');
}

else
{
	include 'login.php';
}	

?>