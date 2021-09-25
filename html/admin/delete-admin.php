<?php
	//include constants
	include("../config/constants.php");
	
	//1. get ID of admin to be deleted
	$admin_id = $_GET['admin_id'];
	//2. create query to delete admin
	$sql = "DELETE FROM Admins WHERE admin_id=$admin_id";

	//Execute the query
	try {
		$conn->query($sql);
		$error = $conn->errorCode();
		if($error == 00000) {
		//update session variable message
		$_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully</div>";
		//redirect to manage admin
		header("location:".URL."admin/manage-admin.php");
		}
		else{
			$_SESSION['delete'] = "<div class='error'>Failed to Delete Admin</div>";
			header("location:".URL."admin/manage-admin.php");
		}		
	}
	catch (PDOException $e) { echo $e->getMessage(); }
	//3. redirect to manage admin page with (success/error) message


?>
