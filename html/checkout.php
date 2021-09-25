<?php include("partials-front/navbar.php"); ?>
<?php ob_start(); ?>
        <!--
        1. create an order with the provided information
        2. add all items from session to order_item table with the order_id
        3. on checkout, add all order_items to cart
        -->
<?php
    if(isset($_SESSION['Cart']) && $_SESSION['Cart'] != ''){
        $total = 0.00;
        $product_array = explode(' ', $_SESSION['Cart']);
        $product_id_array = array();  
        $quantity_array = array();
        foreach($product_array as $product){
            $temp = explode(',', $product);
            array_push($product_id_array, array_shift($temp));
            array_push($quantity_array, array_shift($temp));
        }
        $index = 0;
        foreach($product_id_array as $product_id){
            $quantity = $quantity_array[$index]; 
            $sql = "SELECT * FROM Products WHERE product_id=$product_id";
            try{
                $res = $conn->query($sql);
                $error = $conn->errorCode();
                if($error==00000){
                    foreach($res as $row){
                        $price = $row['price'];
                        $total += $price * $quantity;
                    }
                }
                else{
                    echo "SQL error code";
                }
            }
            catch (PDOException $e){
                echo "catch block error";
            }
        $index++;
        }
        $tax_rate = 0.04; //New York State sales tax
        $tax = $total*$tax_rate;
        $grand_total = $total+$tax;
    }
?>

<div class="bg-light">
    <div class="container" style="min-height: 70%">
  <main>

    <div class="py-5 text-center">
      <h2>Checkout</h2>
    </div>

    <div class="row">
      
      <div class="col">
        <h4 class="mb-3">Billing address</h4>
        <form action="" method="POST">
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="firstName" class="form-label">First name</label>
              <input type="text" name="first_name" class="form-control" id="firstName" placeholder="" value="" required>
              <div class="invalid-feedback">
                Valid first name is required.
              </div>
            </div>

            <div class="col-sm-6">
              <label for="lastName" class="form-label">Last name</label>
              <input type="text" name="last_name" class="form-control" id="lastName" placeholder="" value="" required>
              <div class="invalid-feedback">
                Valid last name is required.
              </div>
          </div>

            <div class="col-12">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" class="form-control" id="email" placeholder="you@example.com" required>
              <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
              </div>
            </div>

            <div class="col-12">
              <label for="address" class="form-label">Address</label>
              <input type="text" name="street" class="form-control" id="address" placeholder="1234 Main St" required>
              <div class="invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>

            <div class="col-12">
              <label for="address2" class="form-label">Address 2 <span class="text-muted">(Optional)</span></label>
              <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
            </div>

<!-- not doing international 
            <div class="col-md-5">
              <label for="country" class="form-label">Country</label>
              <select class="form-select" id="country" required>
                <option value="">Choose...</option>
                <option>United States</option>
              </select>
              <div class="invalid-feedback">
                Please select a valid country.
              </div>
            </div>
-->
            <div class="col-md-4">
              <label for="state" class="form-label">State</label>
              <select class="form-select" name="state" id="state" required>
                <option value="">Choose...</option>
                <option value="AL">Alabama</option>
                <option value="AK">Alaska</option>
                <option value="AZ">Arizona</option>
                <option value="AR">Arkansas</option>
                <option value="CA">California</option>
                <option value="CO">Colorado</option>
                <option value="CT">Connecticut</option>
                <option value="DE">Delaware</option>
                <option value="DC">District Of Columbia</option>
                <option value="FL">Florida</option>
                <option value="GA">Georgia</option>
                <option value="HI">Hawaii</option>
                <option value="ID">Idaho</option>
                <option value="IL">Illinois</option>
                <option value="IN">Indiana</option>
                <option value="IA">Iowa</option>
                <option value="KS">Kansas</option>
                <option value="KY">Kentucky</option>
                <option value="LA">Louisiana</option>
                <option value="ME">Maine</option>
                <option value="MD">Maryland</option>
                <option value="MA">Massachusetts</option>
                <option value="MI">Michigan</option>
                <option value="MN">Minnesota</option>
                <option value="MS">Mississippi</option>
                <option value="MO">Missouri</option>
                <option value="MT">Montana</option>
                <option value="NE">Nebraska</option>
                <option value="NV">Nevada</option>
                <option value="NH">New Hampshire</option>
                <option value="NJ">New Jersey</option>
                <option value="NM">New Mexico</option>
                <option value="NY">New York</option>
                <option value="NC">North Carolina</option>
                <option value="ND">North Dakota</option>
                <option value="OH">Ohio</option>
                <option value="OK">Oklahoma</option>
                <option value="OR">Oregon</option>
                <option value="PA">Pennsylvania</option>
                <option value="RI">Rhode Island</option>
                <option value="SC">South Carolina</option>
                <option value="SD">South Dakota</option>
                <option value="TN">Tennessee</option>
                <option value="TX">Texas</option>
                <option value="UT">Utah</option>
                <option value="VT">Vermont</option>
                <option value="VA">Virginia</option>
                <option value="WA">Washington</option>
                <option value="WV">West Virginia</option>
                <option value="WI">Wisconsin</option>
                <option value="WY">Wyoming</option>
              </select>
              <div class="invalid-feedback">
                Please provide a valid state.
              </div>
            </div>

            <div class="col-md-3">
              <label for="zip" class="form-label">Zip</label>
              <input type="text" name="zip" class="form-control" id="zip" placeholder="" required>
              <div class="invalid-feedback">
                Zip code required.
              </div>
            </div>
            
            <div class="col-md-3">
              <label for="city" class="form-label">City</label>
              <input type="text" name="city" class="form-control" id="city" placeholder="" required>
              <div class="invalid-feedback">
                Please provide a valid city.
              </div>
          </div>

<!-- payement not setup yet

          <hr class="my-4">

          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="same-address">
            <label class="form-check-label" for="same-address">Shipping address is the same as my billing address</label>
          </div>

          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="save-info">
            <label class="form-check-label" for="save-info">Save this information for next time</label>
          </div>

          <hr class="my-4">

          <h4 class="mb-3">Payment</h4>

          <div class="my-3">
            <div class="form-check">
              <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked required>
              <label class="form-check-label" for="credit">Credit card</label>
            </div>
            <div class="form-check">
              <input id="debit" name="paymentMethod" type="radio" class="form-check-input" required>
              <label class="form-check-label" for="debit">Debit card</label>
            </div>
            <div class="form-check">
              <input id="paypal" name="paymentMethod" type="radio" class="form-check-input" required>
              <label class="form-check-label" for="paypal">PayPal</label>
            </div>
          </div>

          <div class="row gy-3">
            <div class="col-md-6">
              <label for="cc-name" class="form-label">Name on card</label>
              <input type="text" class="form-control" id="cc-name" placeholder="" required>
              <small class="text-muted">Full name as displayed on card</small>
              <div class="invalid-feedback">
                Name on card is required
              </div>
            </div>

            <div class="col-md-6">
              <label for="cc-number" class="form-label">Credit card number</label>
              <input type="text" class="form-control" id="cc-number" placeholder="" required>
              <div class="invalid-feedback">
                Credit card number is required
              </div>
            </div>

            <div class="col-md-3">
              <label for="cc-expiration" class="form-label">Expiration</label>
              <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
              <div class="invalid-feedback">
                Expiration date required
              </div>
            </div>

            <div class="col-md-3">
              <label for="cc-cvv" class="form-label">CVV</label>
              <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
              <div class="invalid-feedback">
                Security code required
              </div>
            </div>
          </div>
-->
          <hr class="my-4">

          <input type="submit" name="submit" value="Place your order" class="w-100 btn btn-primary btn-lg">
          <!--<button class="w-100 btn btn-primary btn-lg" name="submit" type="submit">Place Order</button>-->
        </form>
      </div>
    </div>
  </main>
</div>

</div>

<?php
    
    if(isset($_POST['submit'])){
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $total = $grand_total;
        //shouldn't need date because sql autogenerates a datatime
        $date = date("m/d/Y");
        $street = $_POST['street'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip = $_POST['zip'];
        $status = "Ordered";
        
        $sql2 = "INSERT INTO Orders SET
            first_name=?,
            last_name=?,
            email=?,
            total=?,
            street=?,
            city=?,
            state=?,
            zip=?,
            status=?";
        
        try{
            $statement = $conn->prepare($sql2);
            $statement->execute([$first_name, $last_name, $email, $total, $street, $city, $state, $zip, $status]);

            $order_id = $conn->lastInsertId();
            $index2 = 0;
            foreach($product_id_array as $product_id){
                $quantity = $quantity_array[$index2]; 
                $sql3 = "INSERT INTO Order_Item SET
                    order_id=$order_id,
                    product_id=$product_id,
                    quantity=$quantity";

                    $conn->query($sql3);
                    $index2++;
            }

            $_SESSION['checkout'] = "<div class='alert alert-success'>Order placed successfully, Thank you!</div>";
            unset($_SESSION['Cart']);
            header('location:'.URL);
        }
        catch (PDOException $e) {
            $_SESSION['checkout'] = "<div class='alert alert-danger'>catch block error</div>";
            header('location:'.URL);
        }
    }
?>
<!-- Display Product End -->
<?php include("partials-front/footer.php"); ?>
