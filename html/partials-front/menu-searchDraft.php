<?php include("config/constants.php"); ?>

    <!-- Navbar Section Starts Here -->

<div class="logo">
<ul>
    <li>
        <a href="<?php echo URL; ?>">StickersformentalHealth</a>
    </li>
</ul>
</div>
<div class="search-cart">
<ul>
    <li>
        <a href="<?php echo URL; ?>cart.php"><i class="fas fa-shopping-bag"></i></a>
    </li>
    <li>
        <!-- Search Section -->
        <section class="search">
            <form action="<?php echo URL; ?>search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Products.." required>
            </form>
        </section>
        <!-- End Search Section -->       
    </li>
</ul>
</div>

    <!-- Navbar Section Ends Here -->

<header class="site-header sticky-top py-1">
    <nav class="container d-flex flex-column flex-md-row justify-content-between">
        <a class="py-2" href="#" aria-label="Product">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="d-block mx-auto" role="img" viewBox="0 0 24 24"><title>Product</title><circle cx="12" cy="12" r="10"/><path d="M14.31 8l5.74 9.94M9.69 8h11.48M7.38 12l5.74-9.94M9.69 16L3.95 6.06M14.31 16H2.83m13.79-4l-5.74 9.94"/></svg>
        </a>
        <a class="py-2 d-none d-md-inline-block" href="<?php echo URL; ?>">Stickersformentalhealth</a>
        <a class="py-2 d-none d-md-inline-block" href="#">Search</a>
        <section class="search">
            <form action="<?php echo URL; ?>search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Products.." required>
            </form>
        </section>
        <a class="py-2 d-none d-md-inline-block" href="#">Cart</a>
    </nav>
</header>



