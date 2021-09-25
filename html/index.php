<?php include("partials-front/navbar.php"); ?>

<?php
    if(isset($_SESSION['checkout'])){
        echo $_SESSION['checkout'];
        unset($_SESSION['checkout']);
    }
?>

<main>
<!-- All Product Start -->
  <div class="all-products-img position-relative overflow-hidden p-3 p-md-5 text-center bg-light">
    <div class="btn-low col-md-5 p-lg-5 mx-auto my-5">
       <a href="<?php echo URL; ?>products.php"><button class="btn-rectangle short" >All Products</button></a>
    </div>
  </div>
<!-- All Products End -->

<!-- Carousel start -->
    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <?php
                $sql = "SELECT * FROM Categories";
                $res = $conn->query($sql);
                $count = $conn->query("SELECT COUNT(*) FROM Categories")->fetchColumn();
                if($count>0){
                    $x = 0;
                    foreach($res as $row){
                        ?>
                        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="<?php echo $x; ?>" class="active" aria-current="true" aria-label="Slide <?php echo $x; ?>"></button>
                        <?php
                    $x++;
                    }
                }
            ?>
        </div>


<!-- Categories Start -->
        <div class="carousel-header"><p><u>Shop By Category</u></p></div> 
        <div class="carousel-inner">
            <?php
            $sql = "SELECT * FROM Categories WHERE active=1";
            $res = $conn->query($sql);
            $count = $conn->query("SELECT COUNT(*) FROM Categories WHERE active=1")->fetchColumn();
            $x = 0;
            if($count>0){
            foreach($res as $row){
                $category_id = $row['category_id'];
                $name = $row['name'];
                $image = $row['image'];
            ?>
            <div class="carousel-item<?php if($x == 0){echo ' active';} ?>">
            <img src="images/category/<?php echo $image; ?>" class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false">
                <div class="container">
                    <div class="carousel-caption text-start test-pad">
                       <h1><?php echo $name; ?></h1>
                       <p><a href="<?php echo URL; ?>select-category.php?category_id=<?php echo $category_id; ?>"><button class="btn-rectangle long">Shop Now</button></a></p>
                    </div>
                </div>
            </div>
            <?php
            $x++;
            }
            }
            else{
                echo 'No Categories Available';
            }
            ?> 
        </div>
        
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>       
    
<!-- Categories End -->

</main>
      
<?php include("partials-front/footer.php"); ?>

