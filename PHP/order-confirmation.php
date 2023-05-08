<?php
session_start();
$cart_count = 0;
if (!empty($_SESSION)) { // not a new session
    session_regenerate_id(TRUE); // make new session id
    }

	if(isset($_SESSION['cart'])) {
		$cart_count = count($_SESSION['cart']);
	}
// Make sure the customer is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: signin.php");
    exit();
}



$orderID = $_GET['orderID'];

// Clear the session variables
unset($_SESSION['cart']);
unset($_SESSION['order_id']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
	  <meta charset="utf-8" />
	  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	  <title>Order Confirmation</title>
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
	
  <body style="display:flex; flex-direction:column; min-height:100vh;">
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



<!-- Order Confirmation notification-->
<br>
<div class="container-fluid">
    <div class="container text-center">
        <h1>Thank you.</h1>
        <p class="lead w-lg-50 mx-auto">Your order has been placed successfully.</p>
        <p class="w-lg-50 mx-auto">Your order number is <?php echo $orderID; ?>. We will process your order and it will be shipped in 2 - 5 business days.</p>
    </div>
 
</div>
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


  </html>
