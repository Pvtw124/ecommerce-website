This file explains what all the files do in the project

html folder:
   
    index.php
        -homepage of website. Has links to products and categories. The only sql
        interaction here is in categories. There is a select statement on
        categories that pulls the name, category_id, and image path. For each
        tuple, a new html element is created that will act as a link to its
        respective category.
    
    products.php 
        -page that displays all products in the database. A select statement
        queries everything in products where active=1, meaning the website owner
        wants that product to be seen by the customer. HTML elements are
        dynamically created each tuple, and will link to select-product.php where
        you can see the description of the product and also add it to the cart.
    
    select-category.php
        -when you click a category on index.php, it directs you to 
        select-category.php where the correct category_id is in the GET method.
        Products are displayed just like in products.php, the only difference
        being category_id = <selected category_id>.
   
    search.php
        -when you enter a string into the searchbar found in 
        partials-front/navbar.php, an sql statement is executed:

        SELECT * FROM Products
            WHERE name LIKE :search 
            OR
            description LIKE :search;
        
        where ':search' is the string variable entered into the navbar.

    select-product.php
        -this page can be arrived at through products.php, select-category.php,
        or search.php. It takes product_id from the GET method, and displays
        only the information for that product. There is also an add to cart
        button. The add to cart button directs the user to add-item.php.
    
    add-product.php
        -adds the product_id from the GET method to $_SESSION['Cart'].
        $_SESSION['Cart'] also has a field for quantity, which default to 1 here.

    cart.php
        -this page queries sql for all products that match the product_id in
        $_SESSION['Cart']. Quantity is also displayed, and there are plug and
        minus buttons to increase or decrease the quantity. When you click these
        buttons, you are directed to plus-quantity or minus-quantity
        respectively. Lastly there is a proceed to checkout button that directs
        to checkout.php.

    plus-quantity.php & minus-quantity.php
        -these files update the quantity in $_SESSION['Cart'] by adding or
        subtracting 1 to the quantity value that matches the index of
        $_SESSION['Cart'] where the quantity button existed.

    checkout.php
        -this page allows the user to enter their address and user information.
        An sql select statement gets the price of each product in the cart,
        multiplies them by the quantity and sales tax, and adds them up to give
        you the total. Lastly, an sql statement enters all the product
        information to the Order_Items relation, and the user information to the
        Orders relation.


    partials-front folder:
        
        head.php, navbar.php, footer.php
            -these files are just html chunks that are repeated in each page, so
            I made php files for each which I can include with
            <?php include("file_path"); ?>. navbar.php includes constants.php
            which is an important file from the config folder.
    
    config folder:
	   
        constants.php
            -this file has the session_start() command, and defines all the
            variables that hold the database connection information. Lastly, it
            creates a PDO connection called $conn, which is used in every page to
            query the database.

    css folder:
            -holds css for admin pages and frontend pages

    images folder:
            -this is where icons and general images for the website are stored,
            and the category and product folders are where the image paths in the
            database lead to.

    admin folder:
        
        login.php
            -user will enter admin username and password on this page. An sql query,
            'SELECT COUNT(*) FROM Admins WHERE username = ? AND password = ?'
            verifies that a tuple with that information exists, and therefore it is
            a valid username and password. The username is added to a session
            variable, $_SESSION['user']. This represents the user being logged in,
            and is checked in authorize.php, which is included in menu.php.
      
        logout.php
            -logout is called when the admin clicks the logout link in menu.php.
            The session_destroy() method is called which ends all session variables,
            including $_SESSION['user'], meaning anytime you try to go to a page in
            the admin folder, you are redirected to login.php.
    
        index.php
            -this is a dashboard that gives statistics on the database. It queries
            'SELECT SUM(total) FROM Orders', and 'SELECT COUNT(*)' from orders,
            categories, and products.
        
        manage-admin.php, manage-category.php, manage-product.php, manage-order.php
            -all of these pages use 'SELECT * FROM' statements to query the needed
            information, and dynamically display them as elements in a table.
            manage-product queries both products and categories. Each has two
            actions, delete and update, which lead to update-...php and delete-...php.
            manage-order doesn't have an update action, but rather a view action

        update-admin.php, update-category.php, update-product.php, update-password.php
            -all of these pages use "UPDATE <table> SET <attributes>=? WHERE <id>=?"
            -all except update-password query the current information with
            "SELECT * FROM table WHERE id=?"

        add-admin.php, add-category.php, add-product.php
            -all of these pages use an insert statement,
            'INSERT INTO Admins (full_name, username, password)
                    VALUES (:full_name, :username, :password)'
            -it's worth noting, in add-admin, the password is encrypted with md5()

        delete-admin.php, delete-category.php, delete-product.php
            -all these pages use a delete statement, DELETE FROM <table> WHERE id=? 

        delete-order
            -delete order actually archives the order, by changing the status from
            'Ordered' to 'Done.' This stops it from being displayed on manage-order.php
            -"UPDATE Orders SET status = 'Done' WHERE order_id=$order_id";

        view-order.php
            -displays more information about orders.
            -first the order which has been selected is queried,
            "SELECT FROM Orders WHERE order_id=$order_id", then the items inside each order
            are queries from the Order_Item table.
            "SELECT * FROM Order_Item WHERE order_id=$order_id". Next, the product each order
            item is queried. "SELECT * FROM Products WHERE product_id=$product_id"
            
        partials folder:
            authorize.php
                -checks if the $_SESSION['user'] variable is set. If it is set,
                the user is allowed through. If it's not set, it means an admin isn't
                logged in, and the user is redirected to login.php

            menu.php, footer.php
                -there are partial php chunks which are included in most of the files.
                they supply the header and footer. The header is important to SQL, because
                it includes the constants.php file, which connects to the database. It also
                includes authorize.php








