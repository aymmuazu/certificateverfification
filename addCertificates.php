<?php

require 'core.inc.php';

try {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $full_name = $_POST['full_name'] ?? '';
        $matric_no = $_POST['cert_no'] ?? '';
        $faculty_info = $_POST['faculty_info'] ?? '';
        $grade = $_POST['grade'] ?? '';
        $year_of_admission = $_POST['year_of_admission'] ?? '';
        $year_of_graduation = $_POST['year_of_graduation'] ?? '';
        $status = $_POST['status'] ?? 'active';
        $current_datetime = date('Y-m-d H:i:s');
        $passportPath = '';
        $statementPath = '';

        if (isset($_FILES['passport']) && $_FILES['passport']['error'] === UPLOAD_ERR_OK) {
            $passportPath = 'uploads/' . basename($_FILES['passport']['name']);
            move_uploaded_file($_FILES['passport']['tmp_name'], $passportPath);
        }

        if (isset($_FILES['statement']) && $_FILES['statement']['error'] === UPLOAD_ERR_OK) {
            $statementPath = 'uploads/' . basename($_FILES['statement']['name']);
            move_uploaded_file($_FILES['statement']['tmp_name'], $statementPath);
        }

        function random18() {
            $number = "";
            for($i=0; $i<6; $i++) {
                $min = ($i == 0) ? 1:0;
                $number .= mt_rand($min,8);
            }
            return $number;
        }

        $cert_no = 'CERT/'.date('y').random18().'SF';

        $query = "INSERT INTO `certificates` (
                    `cert_no`, `full_name`, `matric_no`, `faculty_info`, 
                    `grade`, `year_of_admission`, `year_of_graduation`, 
                    `passport`, `statement`, `status`, `created_at`, `updated_at`
                  ) VALUES (
                    :cert_no, :full_name, :matric_no, :faculty_info, 
                    :grade, :year_of_admission, :year_of_graduation, 
                    :passport, :statement, :status, :created_at, :updated_at
                  )";
        $statement = $con->prepare($query);

        $statement->bindValue(':cert_no', $cert_no);
        $statement->bindValue(':full_name', $full_name);
        $statement->bindValue(':matric_no', $matric_no);
        $statement->bindValue(':faculty_info', $faculty_info);
        $statement->bindValue(':grade', $grade);
        $statement->bindValue(':year_of_admission', $year_of_admission);
        $statement->bindValue(':year_of_graduation', $year_of_graduation);
        $statement->bindValue(':passport', $passportPath);
        $statement->bindValue(':statement', $statementPath);
        $statement->bindValue(':status', $status);
        $statement->bindValue(':created_at', $current_datetime);
        $statement->bindValue(':updated_at', $current_datetime);

        if ($statement->execute()) {
            echo '<script>alert("Certificate added successfully!"); window.location.href="certificates.php";</script>';
        } else {
            echo '<script>alert("Failed to add certificate."); window.location.href="certificates.php";</script>';
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
