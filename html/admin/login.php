<?php include("../config/constants.php"); ?>

<html>
	<head>
		<title>Admin Login</title>
		<link rel="stylesheet" href="../css/admin.css">
	</head>
	<body>
		<div class="login">
			
			<h1 class="text-center">Login</h1>
			<br/>
			<?php
				if(isset($_SESSION['login'])){
					echo $_SESSION['login'];
					unset($_SESSION['login']);
				}
				if(isset($_SESSION['no-user'])){
					echo $_SESSION['no-user'];
					unset($_SESSION['no-user']);
				}
			?>	
			<br/>	
			<!--Login Form Starts Here -->
			<form action="" method="POST">
				<tr>	
					<td>Username: </td>
					<td>
						<input type="text" name="username" placeholder="Enter username">
					</td>
				</tr>
				<tr>
					<td>Password: </td>
					<td>
						<input type="password" name="password" placeholder="Enter password">
					</td>
				</tr>
				<tr>
					<td>	
						<input type="submit" name="submit" value="Login" class="btn-secondary">
					</td>
				</tr>
			</form>
			<!--Login Form Ends Here -->
		</div>
	</body>
</html>

<?php
	//check if button is clicked
	if(isset($_POST['submit'])){
		//get data from login form
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		try{
			$statement = $conn->prepare("SELECT COUNT(*) FROM Admins WHERE username = ? AND password = ?");
                        $statement->execute([$username, $password]);
                        $count = $statement->fetchColumn();
			if($count[0]==1) {
				//login successful
				$_SESSION['login'] = "<div class='success'>Login Successful</div>";
				$_SESSION['user'] = $username; //gets unset on logout
				header("location: ".URL."admin/");
			}
			else if ($count==0) {
				$_SESSION['login'] = "<div class='error'>Username Or Password Did Not Match</div>";
			} 
			else {
				$_SESSION['login'] = "<div class='error'>Unknown Error</div>";
			}
		}
		catch (PDOException $e) { echo 'catch block entered'; } 
	}	
?>
