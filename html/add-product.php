<html>
    <head>
        <title>Order</title>
        <link rel="stylesheet" href="css/front.css">
    </head>
    <body>
        <?php include("config/constants.php"); ?>
        <?php
        if(isset($_GET['product_id'])){
            $product_id = $_GET['product_id'];
        }
        else{
            $_SESSION['add-item'] = "<div class='alert alert-danger'>product_id not set</div>";
            header('location:'.URL."select-product.php?product_id=$product_id");
        }
        ?>
            <!--
            1. store item in session
            2. display items in session on cart.php
            3. when a user checks out, create an order with the provided information
            4. add all items from session to order_item table with the order_id
            5. on checkout, add all order_items to cart
            -->
        <?php
        //add product to cart 
        if(isset($_SESSION['Cart']) && $_SESSION['Cart'] != ''){
            $_SESSION['Cart'] .= " ".$product_id.","."1";
            $_SESSION['add-item'] = "<div class='alert alert-success'>Product added to cart!</div>";
            header('location:'.URL."select-product.php?product_id=$product_id");
        }
        else{
            $_SESSION['Cart'] = $product_id.","."1";
            $_SESSION['add-item'] = "<div class='alert alert-success'>Product added to cart!</div>";
            header('location:'.URL."select-product.php?product_id=$product_id");
        }
        ?>
    </body>
</html>
