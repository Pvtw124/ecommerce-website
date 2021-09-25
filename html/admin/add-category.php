<html>
	<head>
		<title>Add Category</title>
		<link rel="stylesheet" href="../css/admin.css">
	</head>
	<body>
		<?php include('partials/menu.php'); ?>
		<div class="main-content">
			<div class="wrapper">
				<h1>Add Category</h1>
				<br/>
				<?php
					if(isset($_SESSION['add'])){
						echo $_SESSION['add'];
						unset($_SESSION['add']);
					}	
					if(isset($_SESSION['upload'])){
						echo $_SESSION['upload'];
						unset($_SESSION['upload']);
					}

				?>
				<br/>
				<!-- Add Category form starts -->
				<form action="" method="POST" enctype="multipart/form-data">
					<table class="tbl-30">
						<tr>
							<td>Name: </td>
							<td>
								<input type="text" name="name" placeholder="Category name">
							</td>
						</tr>
						<tr>
							<td>Image: </td>
							<td>
								<input type="file" name="image">
							</td>
						</tr>

						<tr>
							<td>Active: </td>
							<td>
								<input type="radio" name="active" value=1> Yes
								<input type="radio" name="active" value=0> No
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="submit" name="submit" value="Submit" class="btn-secondary">
								
							</td>
					</table>
				</form>
				<!-- Add Category form ends -->
				<?php
					//check whether submit button is pressed
					if(isset($_POST["submit"])){
						$name = $_POST['name'];
						//check whether radio is clicked
						if(isset($_POST["active"])){
							$active = $_POST['active'];
						}
						else {
							$active = 1;
						}
						//check if image is selected and set value for image name
						if(!$_FILES['image']['name']==""){
							//upload image
							$image_name = $_FILES['image']['name'];
							//auto rename image
							$ext = end(explode('.', $image_name));
							$image_name = "Category_".time().'.'.$ext; // e.g. Food_Category_283.jpg

							$source = $_FILES['image']['tmp_name'];
							$destination = "../images/category/".$image_name;
							$upload = move_uploaded_file($source, $destination);
							//check if image uploaded
							if($upload==false){
								//stop if image doesn't upload
								$_SESSION['upload'] = "<div class='error'>Failed to Upload image</div>";
								header("location".URL."admin/add-category.php");
								die();
							}	
						}
						else{
							//don't upload image and set image name value as blank
							$image_name="";
							$_SESSION['upload'] = "image not set";
						}

						//insert SQL category into database
						$sql = "INSERT INTO Categories SET name=?, image=?, active=?";
						try {
							$statement = $conn->prepare($sql);
                                                        $statement->execute([$name, $image_name, $active]);
							$error = $statement->errorCode();
							if($error==00000) {
								//executed successfully
								$_SESSION['add'] = "<div class='success'>Category Added Successfully</div>";
								header("location:".URL."admin/manage-category.php");
							}
							else if($error==23000) {
								$_SESSION['add'] = "<div class='error'>A Category With That Name Already Exists</div>";
								header("location:".URL."admin/add-category.php");
							} 
							else {
								//failed to add category
								$_SESSION['add'] = "<div class='error'>Failed to Add Category</div>";
								header("location:".URL."admin/add-category.php");
							}
						}
						catch (PDOException $e) { echo "catch block"; }
					}

				?>
			</div>
		</div>
		<?php include('partials/footer.php'); ?>
	</body>
</html>


