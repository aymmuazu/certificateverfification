<?php

require 'connect.php';

$query = "SELECT * FROM users WHERE role='user'";
$statement = $con->prepare($query);
$statement->execute();
$users = $statement->fetchAll(PDO::FETCH_OBJ);
$users_count = $statement->rowCOunt();


if (loggedin()) {

    $query = "SELECT * FROM payments";
    $statement = $con->prepare($query);
    $statement->execute();
    $payments = $statement->fetchAll(PDO::FETCH_OBJ);
    $payments_count = $statement->rowCOunt();

    $query = "SELECT * FROM certificates";
    $statement = $con->prepare($query);
    $statement->execute();
    $certificates = $statement->fetchAll(PDO::FETCH_OBJ);
    $certificates_count = $statement->rowCOunt();
  
}

