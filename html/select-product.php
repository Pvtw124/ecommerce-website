<?php include("partials-front/navbar.php"); ?>
<br/>

<?php
    if(isset($_SESSION['add-item'])){
        echo $_SESSION['add-item'];
        unset($_SESSION['add-item']);
    }
    if(isset($_SESSION['list-item'])){
        echo $_SESSION['list-item'];
        unset($_SESSION['list-item']);
    }
?>

<?php
    //get product information
    if(isset($_GET['product_id'])){
        $product_id = $_GET['product_id'];
        $sql = "SELECT * FROM Products WHERE product_id=$product_id";
        $res = $conn->query($sql);
        $count = $conn->query("SELECT COUNT(*) FROM Products WHERE product_id=$product_id")->fetchColumn();
        if($count==1){
            foreach($res as $row){
                $name = $row['name'];
                $description = $row['description'];
                $price = $row['price'];
                $image = $row['image'];
                }
            }else{
                    header('location:'.URL);
            }
    }else{
        header('location:'.URL);
    }
?>	

<!-- Display Product -->
<div class="container" style="min-height: 70%;">
    <div class="row">
        <div class="col">
        <?php
            //check if image is available
            if($image==""){
                echo "<div class='error'>Image not Available</div>";	
            }
            else{
                ?>
                <img src="<?php echo URL; ?>images/product/<?php echo $image; ?>" alt="Product img" style = "width: 100%; min-width: 20rem;">
                <?php
            }	
        ?>
        </div>
        <div class="col">
            <div class="card align-items-center" style="padding-top: 2rem; padding-bottom: 2rem;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $name; ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted">$<?php echo $price; ?></h6>
                    <p class="card-text"><?php echo $description; ?>.</p>
                    <a href="add-product.php?product_id=<?php echo $product_id; ?>"><button class="add-cart-btn">Add to Cart</button></a>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Display Product End -->
<?php include("partials-front/footer.php"); ?>





