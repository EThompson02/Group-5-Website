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

// Check if the order ID is provided in the query string
if (!isset($_GET['orderID'])) {
    header("Location: tracking-home.php");
    exit();
}

// Retrieve order details from the database
$mysqli = new mysqli("localhost", "root", "", "music");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$orderID = $_GET['orderID'];
$stmt = $mysqli->prepare("SELECT customer.customerID, customer.first_name, customer.last_name, customer.address, customer.city, customer.postcode, customer.country, `order`.orderID, `order`.orderTracking FROM `order` JOIN customer ON `order`.customerID = customer.customerID WHERE `order`.orderID = ?");
$stmt->bind_param("i", $orderID);
$stmt->execute();
$stmt->bind_result($customerID, $fName, $lName, $address, $city, $postcode, $country, $orderID, $orderTracking);
$stmt->fetch();
$stmt->close();

if ($_SESSION['customer_id'] != $customerID) {
    header("Location: trackinghome.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Tracking</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/stylesheets/main.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- Favicon-->
		<link rel="shortcut icon" type="image/png" href="assets/logo.png">
		<!-- Bootstrap icons-->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
		<!-- Font Awesome-->
		<!-- Font Awesome JS-->
		<script src="https://kit.fontawesome.com/15ec1140f7.js" crossorigin="anonymous"></script>
		<link href="css/styles.css" rel="stylesheet">

</head>
<body>
<!--Nav-->

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



<div class ="tracking-container">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h3><br>Track Your Order</h3>
				<hr>
				<div class="d-flex justify-content-between align-items-center"></div>
			</div>
		</div>
	</div>
	<div class="container">
		<article class="card">
			<header class="card-header"> Order Details </header>
			<div class="card-body">
				<h6>Order ID: <?php echo $orderID; ?></h6>
				<div class="row">
					<div class="col">
						<h5>Billing Address</h5>
						<p><?php echo $fName . " " . $lName; ?><br>
						<?php echo $address; ?><br>
						<?php echo $city . ", " . $postcode; ?><br>
						<?php echo $country; ?></p>
					</div>
					<div class="col">
						<h5>Delivery Address</h5>
						<p><?php echo $fName . " " . $lName; ?><br>
						<?php echo $address; ?><br>
						<?php echo $city . ", " . $postcode; ?><br>
						<?php echo $country; ?></p>
					</div>
				</div>
        <br>

        <div class="row">
                <div class="col">
                <h5>Delivery Information</h5>
                <h6>Tracking Order Number: <?php echo $orderID; ?></h6>
                    <?php if ($orderTracking == 1) { ?>
                        <h6>Order Status: Order Placed, Being Processed</h6>
                    <?php } else if ($orderTracking == 2) { ?>
                        <h6>Order Status: Dispatched from us</h6>
                    <?php } else if ($orderTracking == 3) {?>
                    <h6> Order Status: Your Order is being Shipped</h6>
                  <?php } else if ($orderTracking == 4) {?>
                  <h6> Order Status: Your Order is out for Delivery!</h6>
                <?php }else if ($orderTracking == 5) { ?>
                        <h6>Order Status: Your Order Has Been Delivered</h6>
                        <img src="assets/delivery.jpg" alt="delivery" width="500" height="300">
                    <?php } ?>
                </div>
            </div>
            <br>

            <div class="d-flex justify-content-between align-items-center">
  <div class="step">
    <div class="circle <?php echo ($orderTracking >= 1) ? 'done' : ''; ?>">
      <span>1</span>
    </div>
    <p>Order Placed</p>
  </div>
  <div class="step">
    <div class="circle <?php echo ($orderTracking >= 2) ? 'done' : ''; ?>">
      <span>2</span>
    </div>
    <p>Dispatched</p>
  </div>
  <div class="step">
    <div class="circle <?php echo ($orderTracking >= 3) ? 'done' : ''; ?>">
      <span>3</span>
    </div>
    <p>Shipped</p>
  </div>
  <div class="step">
    <div class="circle <?php echo ($orderTracking >= 4) ? 'done' : ''; ?>">
      <span>4</span>
    </div>
    <p>Out for Delivery</p>
  </div>
  <div class="step">
    <div class="circle <?php echo ($orderTracking >= 5) ? 'done' : ''; ?>">
      <span>5</span>
    </div>
    <p>Delivered</p>
  </div>
</div>

<div class="progress progress-bottom-padding">
  <?php if ($orderTracking == 1): ?>
    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 20%;" aria-valuenow="<?php echo $orderTracking; ?>" aria-valuemin="0" aria-valuemax="5"></div>
  <?php elseif ($orderTracking == 2): ?>
    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 40%;" aria-valuenow="<?php echo $orderTracking; ?>" aria-valuemin="0" aria-valuemax="5"></div>
  <?php elseif ($orderTracking == 3): ?>
    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 60%;" aria-valuenow="<?php echo $orderTracking; ?>" aria-valuemin="0" aria-valuemax="5"></div>
  <?php elseif ($orderTracking == 4): ?>
    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 80%;" aria-valuenow="<?php echo $orderTracking; ?>" aria-valuemin="0" aria-valuemax="5"></div>
  <?php elseif ($orderTracking == 5): ?>
    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="<?php echo $orderTracking; ?>" aria-valuemin="0" aria-valuemax="5"></div>
  <?php endif; ?>
</div>

<br>

			  <a href="trackinghome.php" class="btn btn-danger">Track Another Order</a>
			</div>
		  </article>
		</div>
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

</body>
</html>
