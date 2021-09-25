<?php include('partials-front/navbar.php'); ?>
<!-- Product Search Section -->

<main>


<?php
$search = $_POST['search'];
?>

<section class="py-5 text-center container">
    <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
            <h1 class="fw-light">Products Matching '<?php echo $search; ?>'</h1>
            <p class="lead text-muted">Beautifully creative designs.</p>
        </div>
    </div>
</section>

<?php $search = "%$search%"; ?>

<div class="album py-5 bg-light">
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        
        <?php
            $sql = "SELECT * FROM Products WHERE name LIKE :search OR description LIKE :search";
            try{
                $statement = $conn->prepare($sql);
                $statement->bindValue(':search', $search); 
                $statement->execute();
                $results = $statement->fetchAll(PDO::FETCH_ASSOC);
                $count = $statement->rowCount();
                if($count > 0){
                    foreach($results as $row){
                        $product_id = $row["product_id"];
                        $name = $row["name"];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image = $row["image"];

            ?>
            <a href="select-product.php?product_id=<?php echo $product_id; ?>" class="no-text-decoration">
            <div class="col">
                <div class="card shadow-sm">
                <img src="images/product/<?php echo $image; ?>" class="card-img-top">

                    <div class="card-body">
                        <p class="card-text"><?php echo $name; ?></p>
                        <div class="d-flex justify-content-between align-items-center">
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



<?php include('partials-front/footer.php'); ?>
