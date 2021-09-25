<?php include("partials-front/navbar.php"); ?>

<!-- Product Section Start -->
<main>

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

<section class="py-5 text-center container">
    <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
            <h1 class="fw-light">All Products</h1>
            <p class="lead text-muted">Beautifully creative designs.</p>
        </div>
    </div>
</section>

<div class="album py-5 bg-light">
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        
        <?php
            $sql = "SELECT * FROM Products WHERE active=1";
            try{
                $res = $conn->query($sql);
                $count = $conn->query('SELECT COUNT(*) FROM Products WHERE active=1')->fetchColumn();
                if($count>0){
                    foreach($res as $row){
                        $product_id = $row["product_id"];
                        $name = $row["name"];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image = $row["image"];

            ?>
            <a href="select-product.php?product_id=<?php echo $product_id; ?>" class="no-text-decoration">
            <div class="col">
                <div class="card shadow-sm">
                    <!--<svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>-->
                <img src="images/product/<?php echo $image; ?>" class="card-img-top">

                    <div class="card-body">
                        <p class="card-text"><?php echo $name; ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <!--
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                            </div>
                            -->
                            <small class="text-muted">$<?php echo $price; ?></small>
                        </div>
                    </div>
                </div>
            </div>
            </a>
            <?php
                    }
                }
            }
            catch(PDOException $e) { echo "catch block error"; }
            ?>

        </div>
    </div>
</div>


</main>
<!-- Product Section End -->

<?php include("partials-front/footer.php"); ?>
