<html>
    <head>
        <title>Admin Homepage</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
            <?php include("partials/menu.php"); ?>
            <?php
               $res = $conn->query("SELECT * FROM Dashboard");
               foreach($res as $row){
                  $earnings = $row['earnings'];
                  $num_sales = $row['num_sales'];
                  $num_categories = $row['num_categories'];
                  $num_products = $row['num_products'];
               }
               //I created a view, which replaces this code
               /*
                $earnings = $conn->query("SELECT SUM(total) FROM Orders")->fetchColumn();
                $num_sales = $conn->query("SELECT COUNT(*) FROM Orders")->fetchColumn();
                $num_categories = $conn->query("SELECT COUNT(*) FROM Categories")->fetchColumn();
                $num_products = $conn->query("SELECT COUNT(*) FROM Products")->fetchColumn();
               */


            ?>
            <!-- Main Content Start -->
            <div class="main-content">
                <div class="wrapper">
                    <h1>Dashboard</h1>
                    <?php
                        if(isset($_SESSION['login'])){
                            echo $_SESSION['login'];
                            unset($_SESSION['login']);
                        }
                    ?>
                
                    <br/>
                    <br/>
                    <div class="col-4 text-center">
                        <h1 class="inherit-color">$<?php echo $earnings ?></h1>
                        <br/>
                        Total Earnings 
                    </div>
                    <div class="col-4 text-center">
                        <h1 class="inherit-color"><?php echo $num_sales; ?></h1>
                        <br/>
                        Total Sales 
                    </div>
                    <div class="col-4 text-center">
                        <h1 class="inherit-color"><?php echo $num_categories; ?></h1>
                        <br/>
                        Categories 
                    </div>
                    <div class="col-4 text-center">
                        <h1 class="inherit-color"><?php echo $num_products; ?></h1>
                        <br/>
                        Products 
                    </div>
                    <div class="clearfix">
                    <br/>
                    <br/>
                    <a href='export.php' class='btn-secondary'>Download Database</a>
                    </div>		
                </div>
            </div>
            <!-- Main Content End -->
            <?php include("partials/footer.php"); ?>
    </body>
</html>

