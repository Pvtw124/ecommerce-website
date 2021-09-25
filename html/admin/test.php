<html>
    <head>
        <title>Manage Products</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
        <?php include("partials/menu.php"); ?>
        <div class="main-content">
            <div class="wrapper">
                <h1>Manage Products</h1>
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
                    if(isset($_SESSION['update'])){
                            echo $_SESSION['update'];
                            unset($_SESSION['update']);
                    }	
                ?>
                <br/>
                <!-- Button to Add Admin -->
                <a href="<?php echo URL; ?>admin/add-product.php" class="btn-primary">Add Product</a>
                <br/>
                <br/>
                <table class="tbl-full">
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                    <?php //diplay admins
                    //*****---------****************************
                    //try a join here with products and categories
                    /*
                        $sql = """SELECT Products.name, product_id, description, price, Products.image, Products.active
                                  FROM Products INNER JOIN Categories ON Products.category_id = Categories.category_id"""; 
                    */
                        //query to get admins
                        $sql = "SELECT * FROM Products";
                        try {
                            $res = $conn->query($sql);
                            $count = $conn->query('SELECT COUNT(*) FROM Products')->fetchColumn();
                            $x = 0;
                            if($count>0){
                                foreach($res as $row){
                                    $product_id = $row["product_id"];
                                    $name = $row["name"];
                                    $description = $row["description"];
                                    $price = $row["price"];
                                    $image = $row["image"];
                                    $category_id = $row["category_id"];
                                    $active = $row["active"];
                                    ++$x;	
                                    
                                    //find name of category
                                    if(empty($category_id)){
                                        $category_name="NULL";
                                    }else{
                                        $sql = "SELECT name FROM Categories WHERE category_id=$category_id";
                                        $res2 = $conn->query($sql);
                                        $count2 = $conn->query("SELECT COUNT(name) FROM Categories WHERE category_id=$category_id")->fetchColumn();
                                        if($count2>0){
                                            foreach($res2 as $row2){
                                                if($row2['name']==NULL){
                                                    $category_name = "<div class='error'>Not Available</div>";
                                                }
                                                else{
                                                    $category_name = $row2['name'];
                                                }
                                            }
                                        }else{
                                            $category_name = "";
                                        }
                                    }
                                    //Display the values in our tables
                                    ?>
                                    <tr>
                                        <td><?php echo $x . '.'; ?></td>
                                        <td><?php echo $name; ?></td>
                                        <td><?php echo $description; ?></td>
                                        <td>$<?php echo $price; ?></td>
                                        <td>
                                            <?php
                                                if($image!=""){
                                                    ?>
                                                    <img src="<?php echo URL; ?>images/product/<?php echo $image; ?>" width="100px">
                                                    <?php		
                                                }
                                                else{
                                                    ?>
                                                    <div class='error'>No Image Available</div>
                                                    <?php		
                                                } 
                                             ?>
                                        </td>
                                        <td><?php echo $category_name; ?></td>
                                        <td><?php if($active==1) echo "Yes"; else echo "No"; ?></td>
                                        <td colspan="2">
                                            <a href="<?php echo URL; ?>admin/update-product.php?product_id=<?php echo $product_id; ?>&image=<?php echo $image; ?>" class="btn-secondary">Update</a>
                                            <a href="<?php echo URL; ?>admin/delete-product.php?product_id=<?php echo $product_id; ?>&image=<?php echo $image; ?>" class="btn-secondary">Delete</a>
                                        </td>
                                    </tr>
                                <?php
                                }	
                            }else{
                                ?>
                                    <tr>
                                        <td>
                                            <div class="error">No Products Added</div>
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
