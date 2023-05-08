<?php

session_start();


$cart_count = 0;

if (!empty($_SESSION)) { // not a new session
    session_regenerate_id(TRUE); // make new session id
    }


if (!isset($_SESSION['staff_id'])) {
  header('Location: signin.php');
  exit;
}
// connect to database
$conn = mysqli_connect("localhost", "root", "", "music");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_POST['submit'])) {



// escape user inputs for security
$artistName = mysqli_real_escape_string($conn, $_POST['artistName']);
$productTitle = mysqli_real_escape_string($conn, $_POST['productTitle']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
$buyPrice = mysqli_real_escape_string($conn, $_POST['buyPrice']);
$sellPrice = mysqli_real_escape_string($conn, $_POST['sellPrice']);

if (isset($_FILES["imageUpload"]) && $_FILES["imageUpload"]["error"] == 0) {
    // specify the target directory and file name
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["imageUpload"]["name"]);

    // move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file)) {
        echo "The file has been uploaded,";
    } else {
        echo "Sorry, there was an error uploading your file.";
        exit();
    }
} else {
    echo "Sorry, there was an error uploading your file.";
    exit();
}

// read the contents of the image file and encode it as base64
$imageData = base64_encode(file_get_contents($target_file));

// insert the product information and encoded image data into the database
$sql = "INSERT INTO product (artistName, albumTitle, description, quantity, buyPrice, sellPrice, image) 
        VALUES ('$artistName', '$productTitle', '$description', '$quantity', '$buyPrice', '$sellPrice', '$imageData')";

if (mysqli_query($conn, $sql)) {
    echo "<h2>Product added successfully.</h2>";
    header("Location:staffhome.php");


} else {
    echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
}

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Staff Home</title>
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
<nav class="navbar navbar-expand-lg navbar-dark bg-dark topnav sticky-top">
  <div class="container-fluid">
    <img class="mb-2" src="Assets/Images/LogoName.png" alt="" width="150" height="45">
	
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
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
        <?php 
    if(isset($_SESSION["staff_id"])) {
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
    </div>
  
    <form action="shopping-cart.php">
      <button class="btn btn-outline-light ms-2 btn-sm" type="submit">
          <i class="bi-cart-fill me-1"></i>
          Cart (<?php echo $cart_count; ?>)
      </button>
    </form>
	</div>
</nav>


	<div class="container rounded">
	  <div class="container text-center"><h1><br>Add Product</h1></div>
    <form  method="POST"  enctype="multipart/form-data" class="needs-validation" novalidate> 
		
<div class="form-group custom-form-group">
  <label for="imageUpload" class="form-label">Upload Image</label>
  <input type="file" class="form-control-file" id="imageUpload" name="imageUpload" onchange="previewImage(event)">
<img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 200px; max-height: 200px; margin-top: 10px;">

<script>
  function previewImage(event) {
  var image = document.getElementById('imagePreview');
  image.style.display = "block";
  image.src = URL.createObjectURL(event.target.files[0]);
  }
</script>

</div>


		<div class="row mb-3">
		  <div class="col-md-6">
			<label for="productID" class="form-label"><br>ProductID</label>
			<input type="text" class="form-control" id="productID" name="productID" required>
			<div class="invalid-feedback">
			  Please enter Product ID.
			</div>
		  </div>
		  <div class="col-md-6">
			<label for="quantity" class="form-label"><br>Quantity</label>
			<input type="text" class="form-control" id="quantity" name="quantity" required>
			<div class="invalid-feedback">
			  Please enter a valid quantity.
			</div>
		  </div>
		</div>
		<div class="form-group custom-form-group">
			<label for="description" class="form-label">Description</label>
			<textarea class="form-control" id="description" name="description" rows="3" required></textarea>
			<div class="invalid-feedback">
				Please enter a valid description.
			</div>
			</div>

		<div class="row mb-4">
		  <div class="col-md-6">
			<label for="buyPrice" class="form-label"><br>Buy Price</label>
			<input type="text" class="form-control" id="buyPrice" name="buyPrice" required>
			<div class="invalid-feedback">
			  Please enter a valid buy price.
			</div>
		  </div>
		  <div class="col-md-6">
			<label for="sellPrice" class="form-label"><br>Sell Price</label>
			<input type="text" class="form-control" id="quantity" name="sellPrice" required>
			<div class="invalid-feedback">
			  Please enter a valid sell price.
			</div>
		  </div>
		</div>
		<div class="form-group custom-form-group">
		  <label for="productTitle" class="form-label">Product Title</label>
		  <input type="text" class="form-control" id="productTitle" name="productTitle" required>
		  <div class="invalid-feedback">
			Please enter a valid product title.
		  </div>
		</div>
		<div class="form-group custom-form-group">
		  <label for="artistName" class="form-label">Artist Name (Not Required)</label>
		  <input type="text" class="form-control" id="artistName" name="artistName">
		</div>
		<button type="submit" name = "submit" class="btn btn-dark btn-block">Submit</button>
		<button type="submit" class="btn btn-dark btn-block" onclick="window.location.href = 'staffhome.php';">Back to Staff Home</button>

	  </form>
	</div>

	<script>
	  // Add custom validation messages
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

<!-- Footer -->
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
  
</body>
</html>



<?php



// close connection
mysqli_close($conn);
?>


