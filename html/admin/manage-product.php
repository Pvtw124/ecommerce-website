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
               $sql = "SELECT Products.name A,
                              Categories.name B,
                              product_id,
                              description,
                              price,
                              Products.image,
                              Products.active
                        FROM Products
                        LEFT JOIN Categories
                        ON Products.category_id = Categories.category_id";
               $res = $conn->query($sql);
               $x = 0;
               foreach($res as $row){
                  $name = $row['A'];
                  $category_name = $row['B'];
                  $product_id = $row['product_id'];
                  $description = $row['description'];
                  $price = $row['price'];
                  $image = $row['image'];
                  $active = $row['active'];
                  ++$x;

                  if(empty($category_name)) $category_name="Not Set";

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
            ?>
         </table>
      </div>
   </div>
   <?php include("partials/footer.php"); ?>
</body>
</html>
