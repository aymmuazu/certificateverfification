<?php
require 'connect.php';
ob_start();
session_start(); 
$current_file = $_SERVER['SCRIPT_NAME'];

if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']))
{
	$http_referer = $_SERVER['HTTP_REFERER'];
}
function loggedin()
{
	if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']))
	{
		return true;
	}
	else
	{
		return false;
	}
}


function getuserfield($field)
{
	global $con;

	$query = $con->query("SELECT ".$field." FROM users WHERE id='".$_SESSION['user_id']."'");
	$query->execute();
	$fetch = $query->fetch();

	$return_field = $fetch[$field];

	return $return_field;	
}

$secretKey = "sk_test_950b93575f966750d4e43506bd4ad60ae2c97b66";

?>
