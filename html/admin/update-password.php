<html>
	<head>
		<title>Update Password</title>
		<link rel="stylesheet" href="../css/admin.css">
	</head>
	<body>
		<?php include ('partials/menu.php'); ?>
		<div class="main-content">
			<div class="wrapper">
				<h1>Change Password</h1>
				<br/>
				<br/>
				<?php
					//1. get id of selected admin
					if(isset($_GET['admin_id'])){
						$admin_id=$_GET['admin_id'];
					}
					//2.
				?>
				<form action="" method="POST">
					<table class="tbl-30">
						<tr>
							<td>Current Password: </td>
							<td> <input type="password" name="current_password" placeholder="Current Password">
							</td>
						</tr>
						<tr>
							<td>New Password: </td>
							<td>
								<input type="password" name="new_password" placeholder="New Password">
							</td>
						</tr>
						<tr>
							<td>Confirm Password: </td>
							<td>
								<input type="password" name="confirm_password" placeholder="Confirm Password">
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
			//Check whether submit button was clicked
			if(isset($_POST['submit'])){
				//get data from form
				$admin_id = $_POST['admin_id'];
				$current_password = md5($_POST['current_password']);
				$new_password = md5($_POST['new_password']);
				$confirm_password = md5($_POST['confirm_password']);
				//check whether admin_id and current_password exist
				$sql = "UPDATE Admins SET password='$new_password' WHERE admin_id=$admin_id";
				try{
					$error = $conn->errorCode();
					$count = $conn->query("SELECT COUNT(*) FROM Admins WHERE admin_id=$admin_id AND password = '$current_password'")->fetchColumn();
					if($count == 1){
						//user found, now check whether new_password and confirm_password match
						if($new_password == $confirm_password){
							//Update password
							$conn->query($sql);
							$error = $conn->errorCode();
							if($error == 00000){
								$_SESSION['update-password'] = "<div class='success'>Password Changed Successfully</div>";
								header("location: ".URL."admin/manage-admin.php");
							}
							else {

							}
								
						}
						else {
							//passwords did not match; redirect to manage admin page with error message
							$_SESSION['update-password'] = "<div class='error'>Passwords Did Not Match</div>";
							header("location: ".URL."admin/manage-admin.php");
						}	
					}
					else{
						//user not found, set message and redirect
						$_SESSION['update-password'] = "<div class='error'>Incorrect Password</div>";
						header("location: ".URL."admin/manage-admin.php");
					}
				}
				catch(PDOException $e) { echo "catch block"; }	
				
				//check whether new_password and confirm_password match

				//change password if all above is true
			}
		?>		
		<?php include('partials/footer.php'); ?>
	</body>
</html>



