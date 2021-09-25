<?php include("config/constants.php"); ?>
<?php
    $product_array = explode(' ', $_SESSION['Cart']); 
    $product_id_array = array();  
    $quantity_array = array();
    foreach($product_array as $product){
        $temp = explode(',', $product);
        array_push($product_id_array, array_shift($temp));
        array_push($quantity_array, array_shift($temp));
        }
?>
<?php 
    if(isset($_GET['index'])){
        $index = $_GET['index'];
    }
    else{
        header('location:'.URL.'cart.php');
    }

    $selected_quantity = intval($quantity_array[$index]);
    $selected_quantity++;
    $quantity_array[$index] = $selected_quantity;
    $product_array[$index] = $product_id_array[$index].",".$quantity_array[$index];

    $_SESSION['Cart'] = implode(' ', $product_array);
    header('location:'.URL.'cart.php');
?>
