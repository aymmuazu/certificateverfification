<?php 

require 'core.inc.php';

$id = $_GET['id'];

$type = $_GET['type'];

switch ($type) {
    case 'users':
        $query  = "DELETE FROM users WHERE id=:id";
        $statement = $con->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        header('Location: students.php');
    break;

    case 'certs':
        $query  = "DELETE FROM certificates WHERE id=:id";
        $statement = $con->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        header('Location: certificates.php');
    break;
    
    default:
        header('Location: home.php');
        break;
}