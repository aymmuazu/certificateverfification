<?php

$dsn = 'mysql:dbname=certificateverification;host=localhost';
$user = 'root';
$password = 'root';
 
try
{
	$con = new PDO($dsn,$user,$password);
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
	echo "PDO error".$e->getMessage();
	die();
}
?>