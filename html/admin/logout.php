<?php
	include("../config/constants.php");
	// Destroy the session
	session_destroy(); //unsets $_SESSION['user'], logging you out
	// Redirect to login page
	header('location:'.URL.'admin/login.php');
?>
