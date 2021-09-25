<html>
    <head>
        <title>Manage Orders</title>
        <link rel = "stylesheet" href="../css/admin.css">
    </head>
    <body>
        <?php include("partials/menu.php"); ?>
        <div class="main-content">
            <div class="wrapper">
                <h1>Manage Orders</h1>
                <br/>
                <br/>
                <?php
                    if(isset($_SESSION['delete'])){
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }
                ?>
                <table class="tbl-full">
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>State</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>

                <?php
                    $sql = "SELECT * FROM Orders WHERE status='Ordered'";
                    $res = $conn->query($sql);
                    $count = $conn->query("SELECT COUNT(*) FROM Orders WHERE status='Ordered'")->fetchColumn();
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
                            <tr>
                                <td><?php echo $x++; ?></td>
                                <td><?php echo $first_name; ?> <?php echo $last_name; ?></td>
                                <td><?php $date_array = explode(' ', $date); echo $date_array[0]; ?></td>
                                <td><?php echo $state; ?></td>
                                <td>$<?php echo $total; ?></td>
                                <td colspan="2">
                                    <a href="<?php echo URL; ?>admin/view-order.php?order_id=<?php echo $order_id; ?>" class="btn-secondary">View</a>
                                    <a href="<?php echo URL; ?>admin/delete-order.php?order_id=<?php echo $order_id; ?>" class="btn-secondary">Archive</a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    else{
                    echo "<tr><td colspace='12' class='error'>Orders not Available</td></tr>";
                    }
                    ?>
                </table>

            </div>
        </div>
        <?php include("partials/footer.php"); ?>
    </body>
</html>
