<html>
	<head>
		<title>Manage Categories</title>
		<link rel="stylesheet" href="../css/admin.css">
	</head>
	<body>
		<?php include("partials/menu.php"); ?>
		<div class="main-content">
			<div class="wrapper">
				<h1>Manage Categories</h1>
				<br/>
				<?php
					if(isset($_SESSION['add'])){
						echo $_SESSION['add'];
						unset($_SESSION['add']);
					}
					if(isset($_SESSION['remove'])){
						echo $_SESSION['remove'];
						unset($_SESSION['remove']);
					}
					if(isset($_SESSION['test'])){
						echo $_SESSION['test'];
						unset($_SESSION['test']);
					}
					if(isset($_SESSION['test2'])){
						echo $_SESSION['test2'];
						unset($_SESSION['test2']);
					}			
				?>
				<br/>
				<!-- Button to Add Admin -->
				<a href="<?php echo URL; ?>admin/add-category.php" class="btn-primary">Add Category</a>
				<br/>
				<br/>
				<table class="tbl-full">
					<tr>
						<th>No.</th>
						<th>Name</th>
						<th>Image</th>
						<th>Active</th>
						<th>Actions</th>
					</tr>
					<?php //diplay admins
						//query to get admins
						$sql = "SELECT * FROM Categories";
						try {
							$res = $conn->query($sql);
							$count = $conn->query('SELECT COUNT(*) FROM Categories')->fetchColumn();
							$x = 0;
							if($count>0){
								foreach($res as $row){
									$category_id = $row["category_id"];	
									$name = $row["name"];
									$image = $row["image"];
									$active = $row["active"];
									++$x;	
									//Display the values in our tables
									?>
									<tr>
										<td><?php echo $x . '.'; ?></td>
										<td><?php echo $name; ?></td>
										<td>
											<?php
												if($image!=""){
													?>
													<img src="<?php echo URL; ?>images/category/<?php echo $image; ?>" width="100px">
													<?php		
												}
												else{
													?>
													<div class='error'>No Image Available</div>
													<?php		
												} 
											 ?>
										</td>
										<td><?php if($active==1) echo "Yes"; else echo "No"; ?></td>
										<td>
											<a href="<?php echo URL; ?>admin/update-category.php?category_id=<?php echo $category_id; ?>&image=<?php echo $image; ?>" class="btn-secondary">Update</a>
											<a href="<?php echo URL; ?>admin/delete-category.php?category_id=<?php echo $category_id; ?>&image=<?php echo $image; ?>" class="btn-secondary">Delete</a>
										</td>
									</tr>
				
									<?php
								}	
							}
							else{
								?>
									<tr>
										<td>
											<div class="error">No Categories Added</div>
										</td>
									</tr>	
								<?php
							}
						}
						catch (PDOException $e) { echo "did not execute."; }
					?>
				</table>
			</div>
		</div>
		<?php include("partials/footer.php"); ?>
	</body>
</html>
