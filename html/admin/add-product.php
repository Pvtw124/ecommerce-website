<html>
    <head>
        <title>Add Product</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
        <?php include('partials/menu.php'); ?>
        <div class="main-content">
            <div class="wrapper">
                <h1>Add Products</h1>
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
                <!-- Add Product form starts -->
                <form action="" method="POST" enctype="multipart/form-data">
                    <table class="tbl-30">
                        <tr>
                            <td>Name: </td>
                            <td>
                                <input type="text" name="name" placeholder="Product name">
                            </td>
                        </tr>
                        <tr>
                            <td>Description: </td>
                            <td>
                                <input type="text" name="description" placeholder="Product Description">
                            </td>
                        </tr>
                        <tr>
                            <td>Price: </td>
                            <td>
                                <input type="text" name="price" placeholder="Product Price">
                            </td>
                        </tr>
                        <tr>
                            <td>Image: </td>
                            <td>
                                <input type="file" name="image">
                            </td>
                        </tr>
                            <td>Category: </td>
                            <td>
                                <select name="category_id">
                                    <?php
                                        //display categories
                                        $sql = "SELECT * FROM Categories WHERE active=1";
                                        $res = $conn->query($sql);
                                        $count = $conn->query("SELECT COUNT(*) FROM Categories WHERE active=1")->fetchColumn();
                                        if($count>0){
                                            foreach($res as $row){
                                                $category_id = $row['category_id'];
                                                $name = $row['name'];
                                                ?>
                                                <option value="<?php echo $category_id; ?>"><?php echo $name; ?></option>
                                                <?php
                                            }
                                        }else{
                                            ?>
                                            <option value="0">No Category Found</option>
                                            <?php
                                        }
                                    ?>
                                </select>
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
                        </tr>
                    </table>
                </form>
        <!-- Add Product form ends -->
        <?php
                //check whether submit button is pressed
                if(isset($_POST["submit"])){
                        $name = $_POST['name'];
                        $description = $_POST['description'];
                        $price = $_POST['price'];
                        $category_id = $_POST['category_id'];
                        if(isset($_POST['active'])){
                                        $active=$_POST['active'];
                                }
                                else {
                                        $active=0;
                                }
                        //check if image is selected and set value for image name
                        if(!$_FILES['image']['name']==""){
                                //upload image
                                $image_name = $_FILES['image']['name'];
                                //auto rename image
                                $ext = end(explode('.', $image_name));
                                $image_name = "Product_".time().'.'.$ext; // e.g. Food_Category_283.jpg
                                $source = $_FILES['image']['tmp_name'];
                                $destination = "../images/product/".$image_name;
                                $upload = move_uploaded_file($source, $destination);
                                //check if image uploaded
                                if($upload==false){
                                        //stop if image doesn't upload
                                        $_SESSION['upload'] = "<div class='error'>Failed to Upload image</div>";
                                        header("location".URL."admin/add-product.php");
                                        die();
                                }	
                        }
                        else{
                                //don't upload image and set image name value as blank
                                $image_name="";
                        }
                        //insert into SQL database
                        $data = ['category_id' => $category_id, 'name' => $name, 'description' => $description, 'image' => $image_name, 'price' => $price, 'active' => $active];
                        $sql = "INSERT INTO Products (category_id, name, description, image, price, active)
                                    VALUES (:category_id, :name, :description, :image, :price, :active)";
                        
                        try{
                            $statement = $conn->prepare($sql);
                            $statement->execute($data);
                            $error = $conn->errorCode();
                            if($error==00000){
                                $_SESSION['add'] = "<div class='success'>Product Added Successfully</div>";
                                header("location:".URL."admin/manage-product.php");
                            }
                            else {
                                $_SESSION['add'] = "<div class='error'>Failed to Add Product</div>";
                                header("location:".URL."admin/add-product.php");
                            } 	
                        }
                        catch (PDOException $e) {
                            echo "catch block";
                        } 
                    }
                ?>
            </div>
        </div>
        <?php include('partials/footer.php'); ?>
    </body>
</html>


