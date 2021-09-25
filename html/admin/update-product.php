<html>
	<head>
		<title>Update Product</title>
		<link rel="stylesheet" href="../css/admin.css">
	</head>
	<body>
		<?php include('partials/menu.php'); ?>
		<div class="main-content">
			<div class="wrapper">
				<h1>Update Product</h1>
				<br/>
				<br/>
				<?php
					//1. get id of selected product 
					$product_id=$_GET['product_id'];
					//2. create sql query to get admin information
					$sql="SELECT * FROM Products WHERE product_id=$product_id";
					//3. execute query
					try {
						$res = $conn->query($sql);
						$count = $conn->query("SELECT COUNT(*) FROM Products WHERE product_id=$product_id")->fetchColumn();
						if($count==1){ //this makes sure they are updating an existing product 
							//get details
							$row = $res->fetch();
							$name = $row['name'];
							$description = $row['description'];
							$price = $row['price'];
							$current_image = $row['image'];
							$current_category = $row['category_id'];
							$active = $row['active'];
							echo $current_image;
						}
						else{
							//redirect to product page
							header('location:'.URL.'admin/manage-product.php');
						}	
					}
					catch (PDOException $e) { echo "failed to execute query."; }	
				?>
				<form action="" method="POST" enctype="multipart/form-data">
					<table class="tbl-30">
						<tr>
							<td>Name: </td>
							<td>
								<input type="text" name="name" value="<?php echo $name; ?>">
							</td>
						</tr>
						<tr>
							<td>Description: </td>
							<td>
								<input type="text" name="description" value="<?php echo $description; ?>">
							</td>
						</tr>
						<tr>
							<td>Price: </td>
							<td>
								<input type="text" name="price" value="<?php echo $price; ?>">
							</td>
						</tr>
						
						<tr>
							<td>Current Image: </td>
							<td>
								<?php
									if($current_image != ""){
										//display image if exists
										?>
											<img src="<?php echo URL; ?>images/product/<?php echo $current_image ?>" width="150px">
										<?php	
									}
									else{
										echo "<div class='error'>Image Not Available</div>";
									}	
								?>
							</td>
						</tr>
						<tr>
							<td>New Image: </td>
							<td>
								<input type="file" name="new_image">
							</td>
						</tr>
						<tr>
							<td>Category: </td>
							<td>
								<select name="category_id">
								<?php
									$sql = "SELECT * FROM Categories WHERE active=1";
									$res = $conn->query($sql);
									$count = $conn->query("SELECT COUNT(*) FROM Categories WHERE active=1")->fetchColumn();
									if($count>0){
										foreach($res as $row){
											$category_name = $row['name'];
											$category_id = $row['category_id'];
											?>
											<option <?php if ($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_name; ?></option>
											<?php
										}
									}else{
										echo "<option value='0'>Category Not Available</option>";
									}
?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Active: </td>
							<td>
								<input <?php if($active==1){echo "checked";} ?> type="radio" name="active" value=1> Yes
								<input <?php if($active==0){echo "checked";} ?> type="radio" name="active" value=0> No
							</td>
						</tr>
						<tr>
							<td colspan="3">
								<input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
								<input type="hidden" name="current_image" value="<?php echo $current_image ?>">
								<input type="submit" name="submit" value="Submit" class="btn-secondary">
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<?php
			//Check whether the submit button was clicked
			if(isset($_POST['submit'])){
				//Get values from form to update
				$product_id = $_POST['product_id'];
				$name = $_POST['name'];
				$description = $_POST['description'];
				$price = $_POST['price'];
				$active = $_POST['active'];
				$new_image = $_FILES['new_image']['name'];
				$current_image = $_POST['current_image'];
				$category_id = $_POST['category_id'];
				//update image if selected
				if($new_image!=""){
					//auto rename image
					$ext = end(explode('.', $new_image));
					$new_image = "Product_".time().'.'.$ext; // e.g. Food_Product_283.jpg

					$source = $_FILES['new_image']['tmp_name'];
					$destination = "../images/product/".$new_image;
					$upload = move_uploaded_file($source, $destination);
					//check if image uploaded
					if($upload==false){
						//stop if image doesn't upload
						$_SESSION['upload'] = "<div class='error'>Failed to Upload image</div>";
						header("location".URL."admin/add-product.php");
						die();
					}
					//remove current image
					$remove_path = "../images/product/".$current_image;
					$remove = unlink($remove_path);
					//check if remove worked
					if($remove==false){
						//failed to remove image
						$_SESSION['remove'] = "<div class='error'>Failed To Remove Current Image</div>";
						header("location:".URL."admin/manage-product.php");
						die();
					}
					//set image to new image
					$image = $new_image;	
				}
				else{
					//there is not a new image
					$image = $current_image;
				}
	
				//Create sql query to update admin
                                /*
				$sql = "UPDATE Products SET
				name = '$name',
				description = '$description',
				price = $price,
				active = $active,
				image = '$image',
				category_id = $category_id
				WHERE product_id = '$product_id'";
                                */

                                $sql = "UPDATE Products SET category_id=?, name=?, description=?, image=?, price=?, active=?
                                    WHERE product_id=?";
				//execute query
				try {
                                    $conn->prepare($sql)->execute([$category_id, $name, $description, $image, $price, $active, $product_id]);
                                    $error = $conn->errorCode();
                                    if($error == 00000){
                                            $_SESSION['update'] = "<div class='success'>Product Updated Successfully</div>";
                                            //redirect to manage product 
                                            header('location:'.URL.'admin/manage-product.php');
                                    }
                                    else { 
                                            $_SESSION['update'] = "<div class='error'>Failed to Update Product</div>";
                                            //redirect to manage product 
                                            header('location:'.URL.'admin/manage-product.php');
                                    }
				}
				catch (PDOException $e) { $_SESSION['delete'] = $e->getMessage(); }	
			}
		?>
		<?php include('partials/footer.php'); ?>
	</body>
</html>
