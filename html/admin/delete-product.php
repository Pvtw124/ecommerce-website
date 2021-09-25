<?php
	include('../config/constants.php');	
	//check if product_id and image is set or not
	if(isset($_GET['product_id']) && isset($_GET['image'])){
		//get values and delete
		$product_id = $_GET['product_id'];
		$image = $_GET['image'];
		//remove image file if available
		if($image != ""){
			$path = "../images/product/".$image;
			$remove = unlink($path);
			if($remove==false){
				//failed to remove
				$_SESSION['remove'] = "<div class='error'>Failed To Remove Product Image</div>";
				header('location:'.URL.'admin/manage-product.php');
				die();	
			}
		}	
		//delete data from database
		$sql = "DELETE FROM Products WHERE product_id=$product_id";
		$conn->query($sql);
		$error = $conn->errorCode();
		if($error==00000){
			$_SESSION['remove'] = "<div class='success'>Successfully Deleted Product</div>";
			header("location:".URL."admin/manage-product.php");
		}
		else{
			$_SESSION['remove'] = "<div class='error'>Failed To Delete Product</div>";
			header("location:".URL."admin/manage-product.php");
		}
	}
	else{
		//redirect to manage product page
		header('location:'.URL.'admin/manage-product.php');	
	}	
?>
