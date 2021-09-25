<html>
    <head>
        <title>Add Admin</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
        <?php include("partials/menu.php"); ?>
        <div class="main-content">
            <div class="wrapper">
                <h1>Add Admin</h1>
                <br/>
                <br/>
                <!-- Display Error Message -->
                <?php
                    if(isset($_SESSION['add'])){
                        echo $_SESSION['add'];
                        unset($_SESSION['add']);
                    }
                ?>
                
                <form action="" method="POST">
                    <table class="tbl-30">
                        <tr>
                            <td>Full Name: </td>
                            <td><input type="text" name="full_name" placeholder="Enter name"></td>
                        </tr>
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
                            <td colspan="2">
                                <input type="submit" name="submit" value="Submit" class="btn-secondary">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>	
        </div>
        <?php include("partials/footer.php"); ?>
        <?php
            //process the value from form and save it in database

            //check whether submit button is clicked or not
            if(isset($_POST['submit'])){
                //get data from form
                $full_name = $_POST['full_name'];	
                $username = $_POST['username'];
                $password = md5($_POST['password']); //md5 encrypts password
                
                //SQL update string
                $data = ['full_name' => $full_name, 'username' => $username, 'password' => $password];
                $sql = 'INSERT INTO Admins (full_name, username, password) VALUES (:full_name, :username, :password)';
            
                //execute update
                try {
                    $statement = $conn->prepare($sql);
                    $statement->execute($data);
                    $error = $statement->errorCode();
                    
                    if($error == 00000) {
                        $_SESSION['add'] = "<div class='success'>Admin added successfully $error</div>";
                        header("location:".URL.'admin/manage-admin.php');
                    }
                    else {
                        if($error == 23000) { $_SESSION['add'] = "<div class='error'>An admin with that username already exists.</div>"; }
                        else { $_SESSION['add'] = "Unknown error occured"; }
                        header("location:".URL.'admin/add-admin.php');
                    }	
                }
                catch(PDOException $e) {
                    echo 'Failed to add data';
                    header("location:".URL.'admin/add-admin.php');
                }
            }
        ?>
    </body>
</html>
