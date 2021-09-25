<?php
	//check whether user is logged in
	if(!isset($_SESSION['user'])){
		//user is not logged in
		$_SESSION['no-user'] = "<div class='error'>Please login to access Admin Controls</div>";
		header("location:".URL."admin/login.php");
	}	
?>
