        <?php ob_start(); include("partials-front/navbar.php"); ?>
        <?php
        $product_array = explode(' ', $_SESSION['Cart'], 1000); 
        $product_id_array = array();  
        $quantity_array = array();
        foreach($product_array as $product){
            $temp = explode(',', $product);
            array_push($product_id_array, array_shift($temp));
            array_push($quantity_array, array_shift($temp));
        }
		//split product ids in Cart by space and add them to array 
                //query Products to pull up information for product in Cart

		/*
			Quantity
			1. display quantity, but add an update button 
                        2. on click update button, load update-quantity.php, which is cart.php except there is a text box where
                           the number used to be 
			3. hit submit, new quantity is added to session variable
		*/
            $index = 0;
            if(isset($_SESSION['Cart']) && $_SESSION['Cart'] != ''){
                foreach($product_id_array as $product_id){
                    $sql = "SELECT * FROM Products WHERE product_id = $product_id";
                    try{
                        $res = $conn->query($sql);
                        foreach($res as $row){
                            $name = $row['name'];
                            $price = $row['price'];
                            $image = $row['image'];
                            ?>
                                <form action="" method="POST"> 
                                <table>
                                <tr>
                                    <td>
                                        <?php
                                        //check if image is available
                                        if($image==""){
                                            echo "<div class='error'>Image not Available</div>";	
                                        }
                                        else{
                                            ?>
                                            <img src="<?php echo URL; ?>images/product/<?php echo $image; ?>" alt="Product img" width="75px">
                                            <?php
                                        }	
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td> Index: </td>
                                    <td> <?php echo $index; ?> </td>
                                </tr>
                                <tr>
                                    <td>Name: </td>
                                    <td> <?php echo $name; ?> </td>
                                </tr>
                                <tr>
                                    <td>Price: </td>
                                    <td> $<?php echo $price; ?> </td>
                                </tr>
                                <tr>
                                    <td>Quantity: </td>
                                    <?php
                                    if(isset($_GET['index'])){
                                        $selected_index = $_GET['index'];
                                        if($index==$selected_index){
                                        ?>
                                            <td><input name="quantity" type=number value=<?php echo $quantity_array[$index]; ?>></td>
                                            <td>
                                            <input type="submit" name="submit" value="Submit">
                                            </td>
                                        <?php
                                        }
                                        else{
                                        ?>
                                            <td> <?php echo $quantity_array[$index]; ?> </td>
                                        <?php
                                        }
                                    }else{
                                        header('location:'.URL.'cart.php');
                                    }
                                   
                                    ?>
                                </tr>
                                <?php $index++; ?>
                            </table>
                            </form>
                            <?php
                        }
                    }
                        catch (PDOException $e){
                                echo "catch block error";
                        }
                }
            }else{
                echo "Nothing in Cart";
            }
        
        if(isset($_POST['submit'])){
            $quantity_array[$selected_index] = $_POST['quantity'];
            $product_array[$selected_index] = $product_id_array[$selected_index].",".$quantity_array[$selected_index];
            $_SESSION['quantity-print'] = $product_array;
            
            //take product_array at $selectedindex and replace with $product_id,$quantity
            $_SESSION['Cart'] = implode(' ', $product_array); 
            header('location:'.URL.'cart.php');
            exit();
        }
        ?>
        <?php include("partials-front/footer.php"); ?>













