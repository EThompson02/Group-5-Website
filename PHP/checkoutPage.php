
        <?php
        session_start();
// Make sure the customer is logged in
if (!isset($_SESSION['customer_id'])) {
  header("Location: signin.php");
  exit();
}


        $cart_count = 0;

if (!empty($_SESSION)) { // not a new session
  session_regenerate_id(TRUE); // make new session id
  }

        $mysqli = new mysqli("localhost", "root", "", "music");
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli->connect_error;
            exit();
        }


        ?>


<!DOCTYPE html>
<html lang="en">
<head>
	  <meta charset="utf-8" />
	  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	  <title>Check Out</title>
    <link rel="stylesheet" href="assets/stylesheets/main.css">

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




  <body>
	


  <?php
        // Initialize variables
        $totalPrice = 0;

        // If the cart is not empty
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            // Get product info for each cart item
            $productIDs = array_keys($_SESSION['cart']);
            $stmt = $mysqli->prepare("SELECT sellPrice FROM product WHERE productID IN (" . implode(",", $productIDs) . ")");
            $stmt->execute();
            $stmt->bind_result($sellPrice);

            // Loop through the results and accumulate the total price
            $rowIndex = 0;
            while ($stmt->fetch()) {
                // Get the quantity of the item in the cart
                $cartQuantity = $_SESSION['cart'][$productIDs[$rowIndex]];
                $quantity = ($cartQuantity != '') ? $cartQuantity : 0;

                // Calculate subtotal for each item and accumulate total price
                $subtotal = $sellPrice * $quantity;
                $totalPrice += $subtotal;

                $rowIndex++;
            }

            $stmt->close();
        }


        if (isset($_SESSION['discounted_price'])) {
          $totalPrice = $_SESSION['discounted_price'];
      }
        $totalPrice += 2.99;


        ?>
   

   <div class="row">
      <!-- Left Side -->
      <div class="col-lg-12">
        <div class="accordion" id="accordionPayment">
          <!-- Credit card -->
          <div class="accordion-item mb-3">
            <h2 class="h5 px-4 py-3 accordion-header d-flex justify-content-between align-items-center">
              <div class="form-check w-100 collapsed" data-bs-toggle="collapse" data-bs-target="#collapseCC" aria-expanded="false">
                <input class="form-check-input" type="radio" name="payment" id="payment1">
                <label class="form-check-label pt-1" for="payment1">
                  Credit Card
                </label>
              </div>
              <span>
                <svg width="34" height="25" xmlns="http://www.w3.org/2000/svg">
                  <g fill-rule="nonzero" fill="#333840">
                    <path d="M29.418 2.083c1.16 0 2.101.933 2.101 2.084v16.666c0 1.15-.94 2.084-2.1 2.084H4.202A2.092 2.092 0 0 1 2.1 20.833V4.167c0-1.15.941-2.084 2.102-2.084h25.215ZM4.203 0C1.882 0 0 1.865 0 4.167v16.666C0 23.135 1.882 25 4.203 25h25.215c2.321 0 4.203-1.865 4.203-4.167V4.167C33.62 1.865 31.739 0 29.418 0H4.203Z"></path>
                    <path d="M4.203 7.292c0-.576.47-1.042 1.05-1.042h4.203c.58 0 1.05.466 1.05 1.042v2.083c0 .575-.47 1.042-1.05 1.042H5.253c-.58 0-1.05-.467-1.05-1.042V7.292Zm0 6.25c0-.576.47-1.042 1.05-1.042H15.76c.58 0 1.05.466 1.05 1.042 0 .575-.47 1.041-1.05 1.041H5.253c-.58 0-1.05-.466-1.05-1.041Zm0 4.166c0-.575.47-1.041 1.05-1.041h2.102c.58 0 1.05.466 1.05 1.041 0 .576-.47 1.042-1.05 1.042H5.253c-.58 0-1.05-.466-1.05-1.042Zm6.303 0c0-.575.47-1.041 1.051-1.041h2.101c.58 0 1.051.466 1.051 1.041 0 .576-.47 1.042-1.05 1.042h-2.102c-.58 0-1.05-.466-1.05-1.042Zm6.304 0c0-.575.47-1.041 1.051-1.041h2.101c.58 0 1.05.466 1.05 1.041 0 .576-.47 1.042-1.05 1.042h-2.101c-.58 0-1.05-.466-1.05-1.042Zm6.304 0c0-.575.47-1.041 1.05-1.041h2.102c.58 0 1.05.466 1.05 1.041 0 .576-.47 1.042-1.05 1.042h-2.101c-.58 0-1.05-.466-1.05-1.042Z"></path>
                  </g>
                </svg>
              </span>
            </h2>
            <div id="collapseCC" class="accordion-collapse collapse show" data-bs-parent="#accordionPayment" style="">
              <div class="accordion-body">
                <div class="mb-3">
                  <div class="col-md-6">
					<label for="card_number" class="form-label"><br>Card Number</label>
					<input type="text" class="form-control" id="first_name" name="first_name" required>
					<div class="invalid-feedback">
					  Please enter your card number.
					</div>
				  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
						<label for="name" class="form-label"><br>Name On Card</label>
						<input type="text" class="form-control" id="last_name" name="last_name" required>
						<div class="invalid-feedback">
						  Please enter your full name.
					</div>
                  </div>
                  <div class="col-lg-6">
						<label for="name" class="form-label"><br>Expiry Date</label>
						<input type="text" class="form-control" id="last_name" name="last_name" required>
						<div class="invalid-feedback">
						  Please enter your expiry date.
					</div>
                  </div>
                  <div class="col-lg-6">
						<label for="name" class="form-label"><br>CVV</label>
						<input type="text" class="form-control" id="last_name" name="last_name" required>
						<div class="invalid-feedback">
						  Please enter your CVV code.
					</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        </div>
        </div>



   <form action="order.php" method="post">
  <div class='card mb-4 checkout-container' style='width: 800px;'>
    <div class="card mb-4">
      <div class="card-header py-3">
        <h5 class="mb-0">Summary</h5>
      </div>
      <div class="card-body">
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
        <div class="form-check mb-3">
                  <input class="form-check-input" type="checkbox" value="" id="terms" name ="terms" required>
                  <label class="form-check-label" for="terms">
                  I agree to the 
                  <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#exampleModal">Terms and Conditions</button>
                  </label>
                  <div class="invalid-feedback">
                  You must agree to the terms and conditions.
                  </div>
               </div>

               <div class="form-check mb-3 small">
              <input class="form-check-input" type="checkbox" value="" id="subscribe">
              <label class="form-check-label" for="subscribe">
                Get emails about product updates and events.</a>
              </label>
            </div>
              
<button class="btn btn-danger w-100 mt-2" type="submit" name="submit">Place Order</button>
</div>
</div>
</div>



   <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-lg">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">Terms and Conditions</h5>
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                           <p>Welcome to Rockin' Roll! Before using our services, please read these terms and conditions carefully. 
                              By accessing or using our website, you agree to be bound by these terms and conditions.<br><br>If you do not agree to these terms and conditions, 
                              you may not use our website. <br><br>Our website is intended for use by adults only. If you are under the age of 18, please do not use our 
                              services.
                              <br><br>All content on our website is provided for general information purposes only. It is not intended to be and should not be relied upon as legal, 
                              financial, or other professional advice. <br><br>We reserve the right to modify these terms and conditions at any time, so please review them 
                              frequently. Your continued use of our website constitutes your acceptance of any changes to these terms and conditions.
                           </p>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn-btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


</form>


  

    <script>
  var forms = document.getElementsByClassName('needs-validation');
  var validation = Array.prototype.filter.call(forms, function(form) {
    form.addEventListener('submit', function(event) {
      if (form.checkValidity() === false) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
</script>
 <!-- Bootstrap core JS-->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>

</body>


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

<?php
$mysqli->close();

?>