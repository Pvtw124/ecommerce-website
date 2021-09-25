<?php
	include('../config/constants.php');	
	//check if category_id and image is set or not
	if(isset($_GET['category_id']) && isset($_GET['image'])){
		//get values and delete
		$category_id = $_GET['category_id'];
		$image = $_GET['image'];
		//remove image file if available
		if($image != ""){
			$path = "../images/category/".$image;
			$remove = unlink($path);
			if($remove==false){
				//failed to remove
				$_SESSION['remove'] = "<div class='error'>Failed To Remove Category Image</div>";
				header('location:'.URL.'admin/manage-category.php');
				die();	
			}
		}	
		//delete data from database
		$sql = "DELETE FROM Categories WHERE category_id=$category_id";
		$conn->query($sql);
		$error = $conn->errorCode();
		if($error==00000){
			$_SESSION['remove'] = "<div class='success'>Successfully Deleted Category</div>";
			header("location:".URL."admin/manage-category.php");
		}
		else{
			$_SESSION['remove'] = "<div class='error'>Failed To Delete Category</div>";
			header("location:".URL."admin/manage-category.php");
		}
	}
	else{
		//redirect to manage category page
		header('location:'.URL.'admin/manage-category.php');	
	}	
?>
