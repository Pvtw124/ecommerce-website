<html>
    <head>
        <title>View Order</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
        <?php include("partials/menu.php"); ?>
        <div class="main-content">
            <div class="wrapper">
                <h1>View Order</h1>
                <br/>
                <br/>
                <?php
                    if(isset($_GET['order_id'])){
                        $order_id = $_GET['order_id'];
                        $sql = "SELECT * FROM Orders WHERE order_id=$order_id";

                        $res = $conn->query($sql);
                        $count = $conn->query("SELECT COUNT(*) FROM Orders WHERE order_id=$order_id")->fetchColumn();
                        if($count>0){
                            $x = 1;
                            foreach($res as $row){
                                $order_id = $row['order_id'];
                                $first_name = $row['first_name'];
                                $last_name = $row['last_name'];
                                $email = $row['email'];
                                $date = $row['date'];
                                $street = $row['street'];
                                $city = $row['city'];
                                $state = $row['state'];
                                $zip = $row['zip'];
                                $total = $row['total'];
                                ?>
                            <table>
                                <tr>
                                    <td><?php $date_array = explode(' ', $date); echo $date_array[0]; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $first_name; ?> <?php echo $last_name; ?>, <?php echo $email; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $street ?>, <?php echo $city; ?> <?php echo $state; ?>, <?php echo $zip ?></td>
                                </tr>
                                <tr>
                                    <td>Total: $<?php echo $total; ?></td>
                                </tr>
                                <?php
                                $sql2 = "SELECT * FROM Order_Item WHERE order_id=$order_id";
                                $res2 = $conn->query($sql2);
                                $count2 = $conn->query("SELECT COUNT(*) FROM Order_Item WHERE order_id=$order_id")->fetchColumn();
                                if($count2>0){
                                    foreach($res2 as $row2){
                                        $order_id = $row2['order_id'];
                                        $order_item_id = $row2['order_item_id'];
                                        $product_id = $row2['product_id'];
                                        $quantity = $row2['quantity'];

                                        $sql3 = "SELECT * FROM Products WHERE product_id=$product_id";
                                        $res3 = $conn->query($sql3);
                                        foreach($res3 as $row3){
                                            $name = $row3['name'];
                                            $image = $row3['image'];
                                            $price = $row3['price'];
                                            $category_id = $row3['category_id'];
                                            ?>
                                            <tr>
                                                <td><?php echo $quantity; ?> '<?php echo $name; ?>' at $<?php echo $price; ?> each.</td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </table>
                                    <?php
                            }
                        }
                        else{
                        echo "<tr><td colspace='12' class='error'>Orders not Available</td></tr>";
                        }
                    }

                ?>
            </div>
        </div>
        <?php include("partials/footer.php"); ?>
    </body>


</html>
