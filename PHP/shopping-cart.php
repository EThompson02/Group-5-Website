<?php
session_start();
$cart_count = 0;
if (!empty($_SESSION)) { // not a new session
    session_regenerate_id(TRUE); // make new session id
    }

	if(isset($_SESSION['cart'])) {
		$cart_count = count($_SESSION['cart']);
	}

// Connect to database
$mysqli = new mysqli("localhost", "root", "", "music");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}?>

<!DOCTYPE html>
<html lang="en">
    <head>
	  <meta charset="utf-8" />
	  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	  <title>Shopping Cart</title>
    <link rel="stylesheet" href="assets/stylesheets/main.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	  <!-- Favicon -->
	  <link rel="shortcut icon" type="image/png" href="assets/logo.png">
	  <!-- Bootstrap icons -->
	  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
	  <!-- Font Awesome icons -->
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	  <script src="https://kit.fontawesome.com/15ec1140f7.js" crossorigin="anonymous"></script>
	  <!-- jQuery -->
	  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	  <!-- Bootstrap CSS and JavaScript -->
	  <link href="css/styles.css" rel="stylesheet">
	 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
  
	
  </head>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <img class="mb-2" src="Assets/Images/LogoName.png" alt="" width="150" height="45">

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="home.php">Home</a>
        </li>		
        <li class="nav-item dropdown">
          <a class="nav-link" aria-current="page" href="albumPage.php">Vinyls</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" aria-current="page" href="merchandise.php">Merchandise</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="trackinghome.php">Orders</a>
        </li>
        <li class="nav-item">
  <?php 
    if(isset($_SESSION["customer_id"])) {
      echo '<form method="post" action="signout.php">
              <button type="submit" name="signout" class=" nav-item nav-link btn">Sign Out</button>
            </form>';
    } else {
      echo '<a class="nav-link" href="signin.php">Sign In</a>';
    }
  ?>
</li>


      </ul>
      <form role="search" class="d-flex flex-column" method="GET" action="search.php">
  <div class="d-flex">
    <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search">
    <button class="btn btn-secondary border-0" type="submit">
      <i class="fas fa-search"></i>
    </button>
  </div>
</form>

    <form action="shopping-cart.php">
      <button class="btn btn-outline-light ms-2 btn-sm" type="submit">
          <i class="bi-cart-fill me-1"></i>
          Cart (<?php echo $cart_count; ?>)
      </button>
    </form>
    </div>
  </div>
</nav>










<?php



$totalPrice = 0;
$discount = 0;


// If the user submitted an update or remove action for the cart
if (isset($_POST['updateCart'])) {
    // Loop through all products in the cart
    foreach ($_SESSION['cart'] as $productID => $quantity) {
        // Get the new quantity from the form submission
        $newQuantity = $_POST['quantity'][$productID];

        // If the new quantity is valid, update the cart
        if (is_numeric($newQuantity) && $newQuantity > 0) {
            $_SESSION['cart'][$productID] = $newQuantity;
        } else {
            // If the new quantity is 0 or invalid, remove the item from the cart
            unset($_SESSION['cart'][$productID]);
        }
    }
}







// If the user clicked the "Remove" button for a cart item, remove it from the session cart
if (isset($_POST['removeCartItem'])) {
  $productIDToRemove = $_POST['removeCartItem'];
  unset($_SESSION['cart'][$productIDToRemove]);}
// Initialize variables

// If the cart is not empty
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    // Get product info for each cart item
    $productIDs = array_keys($_SESSION['cart']);
    $stmt = $mysqli->prepare("SELECT productID, albumTitle, sellPrice, image, artistName FROM product WHERE productID IN (" . implode(",", $productIDs) . ")");
    $stmt->execute();
    $stmt->bind_result($productID, $albumTitle, $sellPrice, $image, $artistName);
    
    echo "<form method='post'>";

    echo "<section class='h-100 gradient-custom'>";
    echo "<div class='container py-5' >";
    echo "<div class='row d-flex justify-content-center my-2' >";
    echo "<div class='col-md-12'>";
    echo "<div class='card mb-9 custom-card'>";
    echo "<div class='card-header py-3' >";
    echo "</div>";
    echo "<div class='card-body'>";
    while ($stmt->fetch()) {



        // Get the quantity of the item in the cart
        $quantity = $_SESSION['cart'][$productID];
    
        // Calculate subtotal for each item and accumulate total price
        $subtotal = $sellPrice * $quantity;
        $totalPrice += $subtotal;

            // Convert image data to base64-encoded string
            $imageSrc = "data:image/jpeg;base64," . $image;
            $imageAlt = $artistName . " - " . $albumTitle;
    
        // Display item information in a card with an input field to update the quantity and a remove button
        echo "<div class='row'>";
        echo "<div class='col-lg-6 col-md-12 mb-4 mb-lg-0' >";
        echo "<div class='bg-image hover-overlay hover-zoom ripple rounded' data-mdb-ripple-color='light'>";
        echo "<img src='".$imageSrc."' alt='".$imageAlt."' class='img-fluid' style='width:100%; height:auto;' />";
        echo "</div>";
        echo "</div>";
        echo "<div class='col-lg-5 col-md-9 mb-4 mb-lg-0'>";
        echo "<div class='my-box'>";
        // Shopping Cart Items
        echo "<p><strong>" . $artistName . "<br>" . $albumTitle . "</strong></p>";
        echo "<p>" . $sellPrice . "</p>";
        echo "<input type='number' name='quantity[" . $productID . "]' value='" . $quantity . "' min='1'>";
        echo "<br>";
        echo "<div class = 'col-md-6'> <button type='submit' name='removeCartItem' value='" . $productID . "'>Remove</button>";
        echo " <tr><td colspan='5'><input type='submit' name='updateCart' value='Update Cart' class='my-button'></td></tr>";

        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "<hr class='my-4' />";
    }
        
        $stmt->close();

        
     

        
    
        echo "<div class='row d-flex justify-content-center mt-2'>";
        echo "<div class='card mb-6 checkout-container custom-card' style='width: 100%; max-width: 850px;'>";
        echo "<div class='card-body'>";
        echo "<p><strong>Expected shipping delivery</strong></p>";
        echo "<div class='input-group mb-3'>";
        echo "<input type='text' class='form-control' placeholder='Enter your postcode' aria-label='Postcode' aria-describedby='postcode-btn'>";
        echo "<button class='btn btn-danger' type='button' id='postcode-btn'>Check Delivery</button>";
        echo "</div>";
        echo "<p class='mb-0 d-none' id='delivery-cost'>Delivery cost
        : £2.99</p>";
    echo "</div>";
    echo "</div>";
    echo "</form>";

    ?>
    
    <script>
    const btn = document.getElementById('postcode-btn');
    const deliveryCost = document.getElementById('delivery-cost');
    
    btn.addEventListener('click', () => {
      const postcode = document.querySelector('input[type="text"]').value;
      const validPostcode = /^[A-Za-z]{1,2}\d[A-Za-z\d]?\s?\d[A-Za-z]{2}$/i.test(postcode);
    
      if (validPostcode) {
        deliveryCost.classList.remove('d-none');
      } else {
        alert('Invalid postcode. Please try again.');
      }
    });
    </script>


<?php

    
    // Add delivery charge to the total price
    $totalPrice += 2.99;
    



    echo "</form>";
    
    echo "<div class='row d-flex justify-content-center my-2'>";

    echo "<div class='card mb-4 mb-lg-0 'checkout-container' style='width: 850px;'>";
    echo "<div class='card-body '>";
    echo "<p><strong>We accept</strong></p>";
    echo "<img class='me-2' width='45px' src='assets/images/visa.png' alt='Visa' />";
    echo "<img class='me-2' width='45px' src='assets/images/mastercard.png' alt='Mastercard' />";
    echo "<img class='me-2' width='45px' src='assets/images/klarna.png' alt='Klarna' />";
    echo "<img class='me-2' width='45px' src='assets/images/payPal.png' alt='PayPal' />";
    echo "<img class='me-2' width='45px' src='assets/images/applePay.png' alt='Apple Pay' />";
    echo "<img class='me-2' width='45px' src='assets/images/googlePay.png' alt='Google Pay' />";
    echo "</div>";
    echo "</div>";
?>




<div class = "row"></div>
    <div class='row d-flex justify-content-center '>
    <div class="checkout-container" style="width: 980px;">
      <div class="card-header py-3">
        <h5 class="mb-0">Summary</h5>
      </div>
      <div class="card-body">
        <?php
                  $product_price = $totalPrice - 2;

        ?>
      <ul class="list-group list-group-flush">
          <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
            Products
            <span><?php echo '£' . number_format($totalPrice - 2.99, 2); ?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center px-0">
            Shipping
            <span>£2.99</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
            <div>
              <strong>Total amount</strong>
              <strong>
                <p class="mb-0">(including VAT)</p>
              </strong>
            </div>
            <span><strong><?php echo '£' . number_format($totalPrice, 2); ?></strong></span>
          </li>
        </ul>
        <br>
        <form method="POST">
  <input type="text" name="discount_code" placeholder="Enter discount code">
  <button type="submit" class ="btn btn-outline-secondary" name="apply_discount">Apply Discount</button>
</form>

<?php
if (isset($_POST['apply_discount'])) {
          $discount_code = $_POST['discount_code'];
          if ($discount_code == "DISCOUNT10") { // change DISCOUNT10 to your desired discount code
            $discount_percent = 0.1; // 10%
          }
        }
        
 // If the discount code is valid, calculate the discount
 if (isset($discount_percent)) {
  $discount = $product_price * $discount_percent;
  $totalPrice -= $discount;
  $_SESSION['discounted_price'] = $totalPrice;

  echo "<p>Discount applied successfully! Your new total is £" . number_format($totalPrice, 2) . ".</p>";
}?>

        <a href="checkoutPage.php" class="btn btn-danger btn-lg mx-auto">
          <i class="bi-cart-fill me-1"></i>
          Go to checkout
        </a>
        </div>
    </div>
  </div>
</div>

<?php
    }
    else 
    {
        echo "<p>Your cart is empty.</p>";
    }
    
    


    
?>

</div>
  </div>
  </div>
<footer
          class="text-center text-lg-start text-white"
          style="background-color: #000000"
          >
    <!-- Grid container -->
    <div class="container p-4 pb-0">
      <!-- Section: Links -->
      <section class="">
        <!--Grid row-->
        <div class="row">
          <!-- Grid column -->
          <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
            <h6 class="text-uppercase mb-4 font-weight-bold" style="color: red;">
              Rockin' Roll
            </h6>
            <p>
            Rockin’ Records, based in Derry/Londonderrry has cultivated a large following, 
			young and old, singlehandedly bringing records back in style.
            </p>
          </div>
          <!-- Grid column -->

          <hr class="w-100 clearfix d-md-none" />

          <!-- Grid column -->
          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
            <h6 class="text-uppercase mb-4 font-weight-bold" style="color: red;">Products</h6>
            <p>
              <a class="text-white" href="albumPage.php">Vinyls</a>
            </p>
            <p>
              <a class="text-white" href="merchandise.php">Merchandise</a>
            </p>
          </div>
          <!-- Grid column -->

          <hr class="w-100 clearfix d-md-none" />

          <!-- Grid column -->
          <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
            <h6 class="text-uppercase mb-4 font-weight-bold " style="color: red;">
              Useful links
            </h6>
            <p>
			  <a class="text-white" href="signin.php">Your Account</a>
			</p>
            <p>
              <a class="text-white" href="trackinghome.php">Track My Order</a>
            </p>
            <p>
              <a class="text-white" href="home.php">Home</a>
            </p>
          </div>

          <!-- Grid column -->
          <hr class="w-100 clearfix d-md-none" />

          <!-- Grid column -->
          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
            <h6 class="text-uppercase mb-4 font-weight-bold" style="color: red;">
				Contact
			</h6>
            <p><i class="fas fa-home mr-3"></i> Magee College Northland Road, Londonderry Derry BT48 7JL</p>
            <p><i class="fas fa-envelope mr-3"></i> rockinrollinfo@gmail.com</p>
            <p><i class="fas fa-phone mr-3"></i> 028 7012 3456 </p>
          </div>
        </div>
      </section>
      <hr class="my-3">

      <!-- Section: Copyright -->
      <section class="p-3 pt-0">
        <div class="row d-flex align-items-center">
          <!-- Grid column -->
          <div class="col-md-7 col-lg-8 text-center text-md-start">
            <!-- Copyright -->
            <div class="p-3">
              © 2023 Copyright:
              <a class="text-white" href="home.php"
                 >Rockin'Roll.com</a
                >
            </div>
          </div>
          <div class="col-md-5 col-lg-4 ml-lg-0 text-center text-md-end">
            <!-- Facebook -->
            <a
               class="btn btn-outline-light btn-floating m-1"
			   href="https://www.facebook.com/viola.davis/"
               class="text-white"
               role="button"
               ><i class="fab fa-facebook-f"></i
              ></a>

            <!-- Twitter -->
            <a
               class="btn btn-outline-light btn-floating m-1"
			   href = "https://twitter.com/violadavis"
               class="text-white"
               role="button"
               ><i class="fab fa-twitter"></i
              ></a>

            <!-- Google -->
            <a
               class="btn btn-outline-light btn-floating m-1"
               class="text-white"
			   href = "https://en.wikipedia.org/wiki/Viola_Davis"
               role="button"
               ><i class="fab fa-google"></i
              ></a>

            <!-- Instagram -->
            <a
               class="btn btn-outline-light btn-floating m-1"
               class="text-white"
			   href = "https://www.instagram.com/violadavis/"
               role="button"
               ><i class="fab fa-wikipedia-w"></i>
              </a>
          </div>
        </div>
      </section>
    </div>
  </footer>
	
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
		<!-- jQuery and Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js"></script>