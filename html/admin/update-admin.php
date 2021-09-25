<html>
	<head>
		<title>Update Admin</title>
		<link rel="stylesheet" href="../css/admin.css">
	</head>
	<body>
		<?php include('partials/menu.php'); ?>
		<div class="main-content">
			<div class="wrapper">
				<h1>Update Admin</h1>
				<br/>
				<br/>
				<?php
					//1. get id of selected admin
					$admin_id=$_GET['admin_id'];
					//2. create sql query to get admin information
					$sql="SELECT * FROM Admins WHERE admin_id=$admin_id";
					//3. execute query
					try {
						$res = $conn->query($sql);
						$count = $conn->query("SELECT COUNT(*) FROM Admins WHERE admin_id=$admin_id")->fetchColumn();
						if($count==1){ //this makes sure they are updating an existing admin
							//get details
							//echo "<div class='success'>Admin Available</div>";
							$row = $res->fetch();
							$full_name = $row['full_name'];
							$username = $row['username'];
						}
						else{
							//redirect to admin page
							header('location:'.URL.'admin/manage-admin.php');
						}	
					}
					catch (PDOException $e) { echo "failed to execute query."; }	
				?>
				<form action="" method="POST">
					<table class="tbl-30">
						<tr>
							<td>Full Name: </td>
							<td>
								<input type="text" name="full_name" value="<?php echo $full_name; ?>">
							</td>
						</tr>
						<tr>
							<td>Username: </td>
							<td>
								<input type="text" name="username" value="<?php echo $username; ?>">
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
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
				$admin_id = $_POST['admin_id'];
				$full_name = $_POST['full_name'];
				$username = $_POST['username'];
				//Create sql query to update admin
				$sql = "UPDATE Admins SET full_name = ?, username = ? WHERE admin_id = ?";
				//execute query
				try {
					$statement = $conn->prepare($sql);
                                        $statement->execute([$full_name, $username, $admin_id]);
					$error = $statement->errorCode();
					if($error == 00000){
						$_SESSION['update'] = "<div class='success'>Admin Updated Successfully</div>";
						//redirect to manage admin
						header('location:'.URL.'admin/manage-admin.php');
					}
					else { 
						$_SESSION['delete'] = "<div class='error'>Failed to Update Admin</div>";
						//redirect to manage admin
						header('location:'.URL.'admin/manage-admin.php');
					}
				}
				catch (PDOException $e) { $_SESSION['delete'] = $e->getMessage(); }	
			}
		?>
		<?php include('partials/footer.php'); ?>
	</body>
</html>
