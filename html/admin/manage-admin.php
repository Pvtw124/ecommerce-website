<html>
	<head>
		<title>Manage Admin</title>
		<link rel="stylesheet" href="../css/admin.css">
	</head>
	<body>
		<?php include("partials/menu.php"); ?>
		<div class="main-content">
			<div class="wrapper">	
				<h1>Manage Admins</h1>
				<br/>
				<br/>
				<!-- Button to Add Admin -->
				<a href="add-admin.php" class="btn-primary">Add Admin</a>
				<br/>
				<br/> 
				<?php //display success
					if(isset($_SESSION['add'])){
						echo $_SESSION['add'];
						unset($_SESSION['add']);
					}

					if(isset($_SESSION['delete'])){
						echo $_SESSION['delete'];
						unset($_SESSION['delete']);
					}
					
					if(isset($_SESSION['update'])){
						echo $_SESSION['update'];
						unset($_SESSION['update']);
					}
					
					if(isset($_SESSION['update-password'])){
						echo $_SESSION['update-password'];
						unset($_SESSION['update-password']);
					}
				?>
	
				<table class="tbl-full">
					<tr>
						<th>No.</th>
						<th>Full Name</th>
						<th>Username</th>
						<th>Actions</th>
					</tr>
					<?php //diplay admins
						//query to get admins
						$sql = "SELECT * FROM Admins";
						try {
							$res = $conn->query($sql);
							$count = $conn->query('SELECT COUNT(*) FROM Admins')->fetchColumn();
							$x = 0;
							if($count>0){
								foreach($res as $row){
									$admin_id = $row["admin_id"];
									$full_name = $row["full_name"];
									$username = $row["username"];
									++$x;	
									//Display the values in our tables
									?>
									<tr>
										<td><?php echo $x . '.'; ?></td>
										<td><?php echo $full_name; ?></td>
										<td><?php echo $username; ?></td>
										<td>
											<a href="<?php echo URL; ?>admin/update-admin.php?admin_id=<?php echo $admin_id; ?>" class="btn-secondary">Update</a>
											<a href="<?php echo URL; ?>admin/delete-admin.php?admin_id=<?php echo $admin_id; ?>" class="btn-secondary">Delete</a>
											<a href="<?php echo URL; ?>admin/update-password.php?admin_id=<?php echo $admin_id?>" class="btn-secondary">Change Password</a>	
										</td>
									</tr>
				
									<?php
								}	
							}
							else{
							
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
