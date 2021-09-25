
<div style="background-color: #F8F9FA;">
<?php include("partials-front/navbar.php"); ?>
<br/>
<?php
        if(isset($_SESSION['Cart']) && $_SESSION['Cart'] != ''){
                $total = 0.00;
                $total_quantity = 0;
                $product_array = explode(' ', $_SESSION['Cart']);
                $product_id_array = array();  
                $quantity_array = array();
                foreach($product_array as $product){
                    $temp = explode(',', $product);
                    array_push($product_id_array, array_shift($temp));
                    array_push($quantity_array, array_shift($temp));
                }
                $index = 0;
                foreach($product_id_array as $product_id){
                        $quantity = $quantity_array[$index]; 
                        $sql = "SELECT * FROM Products WHERE product_id=$product_id";
                        try{
                                $res = $conn->query($sql);
                                $error = $conn->errorCode();
                                if($error==00000){
                                        foreach($res as $row){
                                                $price = $row['price'];
                                                $total += $price * $quantity;
                                                $total_quantity += $quantity;
                                        }
                                }
                                else{
                                        echo "SQL error code";
                                }
                        }
                        catch (PDOException $e){
                                echo "catch block error";
                        }
                $index++;
                }
                $tax_rate = 0.04; //New York State sales tax
                $tax = $total*$tax_rate;
                $grand_total = $total+$tax;
        }
?>


<div class="container" style="min-height: 75%;">
    <div class="row">

<?php
   $index = 0;
    if(isset($_SESSION['Cart']) && $_SESSION['Cart'] != ''){
        ?>
        <?php
        $item_amount = count($product_id_array);
        ?>
        <div class="col">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h5 class="card-title d-flex justify-content-between">Subtotal (<?php echo $total_quantity ?> items): <p class="card-text">$<?php echo $total?></p></h5>
                    <br/>
                    <a href="checkout.php"><button class="btn-rectangle long inverse-color no-text-decoration">Checkout</button></a>
                </div>
            </div>
        </div>
        <div class="col">
        <?php
        foreach($product_id_array as $product_id){
            $sql = "SELECT * FROM Products WHERE product_id = $product_id";
            try{
                $res = $conn->query($sql);
                foreach($res as $row){
                    $name = $row['name'];
                    $price = $row['price'];
                    $image = $row['image'];
                    ?>

            <div class="card shadow-sm mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        <?php
                        if($image==""){
                            echo "<div class='error'>Image not Available</div>";	
                        }
                        else{
                            ?>
                            <img src="<?php echo URL; ?>images/product/<?php echo $image; ?>" alt="Product img" width="100%">
                            <?php
                        }	
                        ?>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <p class="card-title"><?php echo $name; ?></p>
                            <p class="card-text"><small class="text-muted">$<?php echo $price; ?></small></p>
                            <p class="card-text">
                                <div class="quantity-box d-flex justify-content-between">
                                    <a class="quantity-change no-text-decoration" href="minus-quantity.php?index=<?php echo $index; ?>">-</a><p><?php echo $quantity_array[$index]; ?></p><a class="quantity-change no-text-decoration" href="plus-quantity.php?index=<?php echo $index; ?>">+</a>
                                </div>
                            </p>
                            <!--
                            <a href="<?php echo URL; ?>update-quantity.php?index=<?php echo $index; ?>"><p class="card-text"><small class="text-muted">qty: <?php echo $quantity_array[$index]; ?></small></p></a>
                            -->
                            <a href="<?php echo URL; ?>delete-product.php?index=<?php echo $index++; ?>" style="color: grey;">remove</a>
                        </div>
                    </div>
                </div>
            </div>
                        <?php
                                }
                            }
                                catch (PDOException $e){
                                        echo "catch block error";
                                }
                        }
                        ?>
        <?php
            }else{
                ?>
                    <div class="alert alert-danger">Nothing in cart.</div>
                <?php
            }
        ?>

        </div>
    </div>
</div>
<?php include("partials-front/footer.php"); ?>

</div>
