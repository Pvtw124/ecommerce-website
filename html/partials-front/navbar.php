<?php include("config/constants.php"); ?>
<?php include("partials-front/head.php"); ?>

<?php
    if(isset($_SESSION['Cart'])){
        $product_array = explode(' ', $_SESSION['Cart']); 
        $product_id_array = array();  
        $quantity_array = array();
        foreach($product_array as $product){
            $temp = explode(',', $product);
            array_push($product_id_array, array_shift($temp));
            array_push($quantity_array, array_shift($temp));
        }
        foreach($quantity_array as $quantity){
        $cart_length += $quantity;
        }
        if($product_array[0]==""){
            $cart_length=0;
        }
    }
?>

<header class="navbar sticky-top py-3 border-bottom">
    <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">
        <a href="<?php echo URL; ?>" class="d-flex align-items-center col-lg-4 mb-2 mb-lg-0 link-dark text-decoration-none" aria-expanded="false">
            <p class="bold">Stickersformentalhealth</p>
        </a>

        <style>
            .align-test{
                padding-bottom: 1.2rem;
            }
            .test33{
                background-color:red;
            }
        </style>

        <div class="d-flex align-items-center">
            <form action="<?php echo URL; ?>search.php" method="POST" class="w-100 me-3">
                <input type="search" name="search" class="form-control" placeholder="Search...">
            </form>
            <div class="flex-shrink-0 align-test">
                <a class="flex-container" style="display: flex;" href="<?php echo URL; ?>cart.php" class="d-block link-dark text-decoration-none" aria-expanded="false">
                   <img class="flex-child" style="flex: 1;" src="images/icons/bag.svg" alt="mdo" width="28" height="28"><?php if($cart_length > 0) {?><div style="padding-left: 5px;" class="flex-child cart-count"><?php echo $cart_length; ?></div><?php } ?>
                </a>
            </div>
        </div>
    </div>
</header>

<body>
