<?php
    include("../config/constants.php");
    include("partials/authorize.php");

    $order_id = $_GET['order_id'];
    $sql = "UPDATE Orders SET
                status = 'Done' 
                WHERE order_id=$order_id";


    try {
        $conn->query($sql);
        $error = $conn->errorCode();
        if($error == 00000) {
        $_SESSION['delete'] = "<div class='success'>Order Deleted Successfully</div>";
        header("location:".URL."admin/manage-order.php");
        }
        else{
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Order</div>";
            header("location:".URL."admin/manage-order.php");
        }		
    }
    catch (PDOException $e) { echo $e->getMessage(); }
?>


