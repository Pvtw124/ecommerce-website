<html>
    <head>
        <title>Update Category</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
        <?php include('partials/menu.php'); ?>
        <div class="main-content">
            <div class="wrapper">
                <h1>Update Category</h1>
                <br/>
                <br/>
                <?php
                    //1. get id of selected category 
                    $category_id=$_GET['category_id'];
                    //2. create sql query to get admin information
                    $sql="SELECT * FROM Categories WHERE category_id=$category_id";
                    //3. execute query
                    try{
                        $res = $conn->query($sql);
                        $count = $conn->query("SELECT COUNT(*) FROM Categories WHERE category_id=$category_id")->fetchColumn();
                        if($count==1){ //this makes sure they are updating an existing category 
                            //get details
                            $row = $res->fetch();
                            $name = $row['name'];
                            $current_image = $row['image'];
                            $active = $row['active'];
                            echo $current_image;
                        }else{
                            //redirect to category page
                            header('location:'.URL.'admin/manage-category.php');
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
                            <td>Current Image: </td>
                            <td>
                            <?php
                                if($current_image != ""){
                                    //display image if exists
                                    ?>
                                        <img src="<?php echo URL; ?>images/category/<?php echo $current_image ?>" width="150px">
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
                            <td>Active: </td>
                            <td>
                                <input <?php if($active==1){echo "checked";} ?> type="radio" name="active" value=1> Yes
                                <input <?php if($active==0){echo "checked";} ?> type="radio" name="active" value=0> No
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
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
                        $category_id = $_POST['category_id'];
                        $name = $_POST['name'];
                        $active = $_POST['active'];
                        $new_image = $_FILES['new_image']['name'];
                        $current_image = $_POST['current_image'];
                        //update image if selected
                        if($new_image!=""){
                                //auto rename image
                                $ext = end(explode('.', $new_image));
                                $new_image = "Category_".time().'.'.$ext; // e.g. Food_Category_283.jpg

                                $source = $_FILES['new_image']['tmp_name'];
                                $destination = "../images/category/".$new_image;
                                $upload = move_uploaded_file($source, $destination);
                                //check if image uploaded
                                if($upload==false){
                                        //stop if image doesn't upload
                                        $_SESSION['upload'] = "<div class='error'>Failed to Upload image</div>";
                                        header("location".URL."admin/add-category.php");
                                        die();
                                }
                                //remove current image
                                $remove_path = "../images/category/".$current_image;
                                $remove = unlink($remove_path);
                                //check if remove worked
                                if($remove==false){
                                        //failed to remove image
                                        $_SESSION['remove'] = "<div class='error'>Failed To Remove Current Image</div>";
                                        header("location:".URL."admin/manage-category.php");
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
                        $sql = "UPDATE Categories SET name = ?, active = ?, image = ? WHERE category_id = ?";
                        //execute query
                        try {
                            $statement = $conn->prepare($sql);
                            $statement->execute([$name, $active, $image, $category_id]);
                            $error = $statement->errorCode();
                            if($error == 00000){
                                $_SESSION['update'] = "<div class='success'>Category Updated Successfully</div>";
                                //redirect to manage category 
                                header('location:'.URL.'admin/manage-category.php');
                            }else{ 
                                $_SESSION['update'] = "<div class='error'>Failed to Update Category</div>";
                                //redirect to manage category 
                                header('location:'.URL.'admin/manage-category.php');
                            }
                        }
                        catch (PDOException $e) { $_SESSION['delete'] = $e->getMessage(); }	
                }
        ?>
        <?php include('partials/footer.php'); ?>
    </body>
</html>
