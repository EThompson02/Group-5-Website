<?php

session_start();
if (!empty($_SESSION)) { // not a new session
  session_regenerate_id(TRUE); // make new session id
  }

if(isset($_POST['productID'])) {
  // get product ID and quantity
  $product_id = $_POST['productID'];
  $quantity = $_POST['quantity'];

  // add item to cart session variable
  $_SESSION['cart'][$product_id] = $quantity;
}

$cart_count = 0;
if(isset($_SESSION['cart'])) {
    $cart_count = count($_SESSION['cart']);
}


$mysqli = mysqli_connect("localhost", "root", "", "music");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
// retrieve productID from URL parameter
if(isset($_GET['productID'])) {
    $productID = $_GET['productID'];
} else {
    echo "Product not found";
}


$productreview = $mysqli->prepare("SELECT customerName, rating, comment FROM reviews WHERE productID = ?");
    $productreview->bind_param("s", $productID);
    $productreview->execute();
    $reviews_result = $productreview->get_result();

   // if ($reviews_result->num_rows > 0) {


   
    


$stmt = $mysqli->prepare("SELECT * FROM product WHERE productID = ?");
$stmt->bind_param("s", $productID);
$stmt->execute();
$result = $stmt->get_result();

// process query results
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

      $imageSrc = "data:image/jpeg;base64," .  $row["image"];
$imageAlt = $row["artistName"] . " - " . $row["albumTitle"];
      
?>


<!DOCTYPE html>
<html lang="en">
    <head>
	  <meta charset="utf-8" />
	  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	  <title>Product</title>
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






<div class="chat-icon">
  <i class="fas fa-comments"></i>
</div>

<div class="modal fade" id="chat-modal" tabindex="-1" role="dialog" aria-labelledby="chat-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="chat-modal-label">Have A Question?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" required>
          </div>
          <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" required>
          </div>
          <div class="form-group">
            <label for="question">Question</label>
            <textarea class="form-control" id="question" rows="3" required></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger btn-md">Submit</button>
		<button type="reset" class="btn btn-default btn-md">Clear</button>
      </div>
    </div>
  </div>
</div>

<br>


<div class="col-md-9" style="padding-left: 100px;">
  <div style="display: inline-block; width: calc(100% - 320px); padding-left: 80px;">
    <h1 class="display-5 fw-bolder"><?php echo $row["albumTitle"]; ?><br><?php echo $row["artistName"]; ?></h1>
    <div class="fs-5 mb-4">
      <span><?php echo "£" . $row["sellPrice"]; ?></span>
    </div>
    <p class="lead"><?php echo $row["description"]; ?></p>
    <br>
    <br>
    <br>

    <div style="display:inline-block; width: 100%; height: 100%; background-color: #f2f2f2;"></div>

    <?php if (isset($_SESSION['customer_id'])) : ?>
      <form action="add_to_cart.php" method="post">
        <input type="hidden" name="productID" value="<?php echo $productID; ?>">
        <input type="number" name="quantity" value="1" min="0">
        <?php if ($row['quantity'] == 0) : ?>
          <button type="submit" disabled>Out of Stock</button>
        <?php else : ?>
          <button type="submit" <?php echo $row['quantity'] == 0 ? 'disabled' : ''; ?>>Add to Cart</button>
        <?php endif; ?>
      </form>
    <?php else : ?>
      <button disabled>Add to Cart</button>
      <span>Please login to add to cart.</span>
    <?php endif; ?>

  </div>

  <img src="<?php echo $imageSrc; ?>" alt="<?php echo $imageAlt; ?>" style="display: inline-block; width: 300px; height: 400px; float: left;">
</div>


<div>
  <br>
  <br>

<br>

  <h2>Reviews</h2>
  <?php

if ($reviews_result->num_rows > 0)
{
  while($row = $reviews_result->fetch_assoc()){

    ?> 
    <br>
    <div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-2">
                <img src="assets/profilePicture.jpg" class="img img-rounded img-fluid"/>
            </div>
            <div class="col-md-10">
                <?php
                    echo "<p>";
                    echo "<h2>" . $row["customerName"] . "<span class='float-right ml-2'>";
                    for ($i = 0; $i < $row["rating"]; $i++) {
                        echo "★ ";
                    }
                    echo "</span></h2>";
                    echo "<div class='clearfix'></div>";
                    echo "<p>" . $row["comment"] . "</p>";
                    echo "</p>";
                ?>
            </div>
        </div>
    </div>
</div>




<p>


</p>

<?php
  }}
  else {
    echo "Review not found";
  }
?>

<!-- Display review section only if user is logged in -->
<?php
if (isset($_SESSION['customer_id'])) {
?>

<div class="container">
    <div class="row">
	<div class="mt-5">
		<hr>
        <h2>Leave a Review</h2>
   
      <div class="col-md-9 col-md-offset-0">
  <form method="post" action="add_review.php">
    <input type="hidden" name="productID" value="<?php echo $productID; ?>" />
    <div class="form-group">
      <input type="hidden" name="customerID" value="<?php echo isset($_SESSION['customerID']) ? $_SESSION['customerID'] : ''; ?>">
    </div>
    <div class="form-group">
      <label class="col-md-3 control-label" for="reviewText">Review</label>
      <textarea class="form-control" name="reviewText" id="reviewText" rows="3" required></textarea>
    </div>
    <div class="form-group">
      <label for="rating">Rating</label>
      <select class="form-control" name="rating" id="rating" required>
        <option value="">Select rating</option>
        <option value="1">1 star</option>
        <option value="2">2 stars</option>
        <option value="3">3 stars</option>
        <option value="4">4 stars</option>
        <option value="5">5 stars</option>
      </select>
    </div>
    <button type="submit" class="btn btn-danger">Submit</button>
    <button type="reset" class="btn btn-default btn-md">Clear</button>

  </form>
      </div>
      </div>
      </div>
      </div>

<?php
} else {
  echo "<p>Please <a href='signin.php'>log in</a> to leave a review.</p>";
}
?>

<?php
    }
} else {
    echo "Product not found";
}



?>
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


// close mysqli connection
$stmt->close();
$productreview->close();
$mysqli->close();
?>
