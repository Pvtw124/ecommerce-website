<html>
    <head>
        <title>Stickersformentalhealth</title>
        <?php include("partials-front/header.php"); ?>
    </head>
    <body>
        <div class="container">
                <?php include("partials-front/menu-search.php"); ?>
                <?php
                    if(isset($_SESSION['checkout'])){
                        echo $_SESSION['checkout'];
                        unset($_SESSION['checkout']);
                    }
                ?>
            
            <div class="by-product">
                <div class='bottom-left'>
                    <a href='products.php'><button class="btn rectangle inverted">ALL PRODUCTS</button></a>
                </div>
            </div>

            <div class='between'>
                <div class='message'>
                    <p>stickersformentalhealth is on a mission to...</p>
                </div>
                <div class='category-label'>Shop By Category</div>
            </div>
         
            <div class="by-category">

                <div class="scroll-wrapper">
                    <div class="item">box-1</div>
                    <div class="item">box-2</div>
                    <div class="item">box-3</div>
                    <div class="item">box-4</div>
                    <div class="item">box-5</div>
                    <div class="item">box-6</div>
                </div>
            </div>
           <!-- <div class="by-category-1">
                <div class='bottom-center'>
                    <a href='categories.php'><button class='btn rectangle'>CATEGORY 1</button></a>
                </div>
            </div>
            
            <div class="by-category-2">
                <div class='bottom-center'>
                    <a href='categories.php'><button class='btn rectangle'>CATEGORY 2</button></a>
                </div>
            </div>
            -->
            <div class="footer"> 
            <?php include("partials-front/footer.php"); ?>
            </div>
        </div>
    </body>
</html>
