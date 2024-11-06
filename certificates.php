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
			<div class="col-md-5">
                <h4 class="fw-bold">Add a New Certificate</h4>

                <form method="POST" action="addCertificates.php" enctype="multipart/form-data">
                    <div class="mb-2">
                        <label for="full_name">Full Name.</label>
                        <input type="text" name="full_name" id="full_name" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label for="cert_no">Matriculation No.</label>
                        <input type="text" name="cert_no" id="cert_no" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label for="faculty_info">Faculty Info.</label>
                        <textarea name="faculty_info" id="faculty_info" class="form-control" placeholder="e.g. Faculty of Computing, Department of Software Engineering, B.Sc. Software Engineering"></textarea>
                    </div>
                    <div class="mb-2">
                        <label for="grade">Grade</label>
                        <textarea name="grade" id="grade" class="form-control" placeholder="e.g. Second Class (Upper Division)"></textarea>
                    </div>
                    <div class="mb-2">
                        <label for="year_of_admission">Year of Admission</label>
                        <input type="date" name="year_of_admission" id="year_of_admission" class="form-control">
                    </div>
                     <div class="mb-2">
                        <label for="year_of_graduation">Year of Graduation</label>
                        <input type="date" name="year_of_graduation" id="year_of_graduation" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="passport">Passport</label>
                        <input type="file" name="passport" id="passport" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label for="statement">Statement of Result/Orginal Certificate</label>
                        <input type="file" name="statement" id="statement" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label for="statement">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="active" selected>Active</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <button type="submit" class="btn btn-dark w-100">Add a Certificate</button>
                    </div>
                </form>
            </div>

            <div class="col-md-7">
                <h4 class="fw-bold">List of Certificates</h4>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Cert. No.</th>
                                <th>Graduate</th>
                                <th>Faculty</th>
                                <th>Grade</th>
                                <th>Years</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            try {
                                $query = "SELECT * FROM certificates";
                                $statement = $con->prepare($query);
                                $statement->execute();
                                $certificates = $statement->fetchAll(PDO::FETCH_OBJ);

                                foreach ($certificates as $certificate) {
                                    ?>
                                    <tr>
                                        <td class="fw-bolder"><?php echo htmlspecialchars($certificate->cert_no); ?></td>
                                        <td>
                                            <?php echo htmlspecialchars($certificate->full_name); ?>
                                            <?php echo htmlspecialchars($certificate->matric_no); ?>
                                        </td>
                                        <td>
                                            <i><?php echo htmlspecialchars($certificate->faculty_info); ?></i>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($certificate->grade); ?>
                                        </td>
                                        <td>
                                            <b>Year of Admission <br>
                                                <?php echo htmlspecialchars(date('d-m-Y', strtotime($certificate->year_of_admission))); ?>
                                            </b>
                                            <br>
                                            <b>Year of Graduation <br>
                                                <?php echo htmlspecialchars(date('d-m-Y', strtotime($certificate->year_of_graduation))); ?>
                                            </b>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php echo $certificate->status == 'active' ? 'primary' : 'secondary'; ?>">
                                                <?php echo ucfirst($certificate->status); ?>
                                            </span>
                                            <a href="deleteOperation.php?type=certs&&id=<?php echo $certificate->id; ?>" class="btn btn-danger btn-sm mt-2">Delete</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            ?>
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