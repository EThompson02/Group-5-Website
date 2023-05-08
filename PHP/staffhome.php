<?php
session_start();



if (!isset($_SESSION['staff_id'])) {
  header('Location: signin.php');
  exit;
}

$cart_count = 0;
if (!empty($_SESSION)) { // not a new session
    session_regenerate_id(TRUE); // make new session id
    }

	if(isset($_SESSION['cart'])) {
		$cart_count = count($_SESSION['cart']);
	}

$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "music";
$connection = mysqli_connect($hostname, $username, $password, $dbname);

// check if the connection was successful
if (mysqli_connect_errno()) {
  die("Connection failed: " . mysqli_connect_error());
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


	
	<br>
	<section class="hero container">
  		<h2>Add a Product?</h2>
      <a class="btn btn-dark btn-lg" href="addproduct.php" role="button">Click Here!</a>
	</section>
	
	<br>
	<hr>
	
	<div class=" container text-center">
	  <h2><br>Need Help?</h2>
	  <h4>Contact One of Our Senior Team Members</h4>
	  <div class="row justify-content-center">
		<div class="col-sm-4">
		  <a href="Assets/Images/viola1.jpg" data-toggle="modal" data-target="#viola-modal" style="color:black;">
			<img src="Assets/Images/viola1.jpg" class="rounded img-thumbnail">
			<h4>Viola Davis</h4>
			<h5>Manager and CEO</h5>
		  </a>
		</div>
		<div class="col-sm-4">
		  <a href="Assets/Images/trisha1.jpg" data-toggle="modal" data-target="#trisha-modal" style="color:black;">
			<img src="Assets/Images/trisha1.jpg" class="rounded img-thumbnail">
			<h4>Trisha Paytas</h4>
			<h5>Deputy Manager</h5>
		  </a>
		</div>
		<div class="col-sm-4">
		  <a href="Assets/Images/katy1.jpg" data-toggle="modal" data-target="#katy-modal" style="color:black;">
			<img src="Assets/Images/katy1.jpg" class="rounded img-thumbnail">
			<h4>Katy Perry</h4>
			<h5>Supervisor</h5>
		  </a>
		</div>
	  </div>
	  <br>
	</div>


	<!-- Viola Modal -->
	<div class="modal fade" id="viola-modal" tabindex="-1" role="dialog" aria-labelledby="viola-modal-label" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="viola-modal-label">Viola Davis</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<p>Manager and CEO</p>
			<p>Email: viola@example.com</p>
			<p>Phone: 123-456-7890</p>
		  </div>
		</div>
	  </div>
	</div>

	<!-- Trisha Modal -->
	<div class="modal fade" id="trisha-modal" tabindex="-1" role="dialog" aria-labelledby="trisha-modal-label" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="trisha-modal-label">Trisha Paytas</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<p>Deputy Manager</p>
			<p>Email: trisha@example.com</p>
			<p>Phone: 123-456-7890</p>
		  </div>
		</div>
	  </div>
	</div>

	<!-- Katy Modal -->
	<div class="modal fade" id="katy-modal" tabindex="-1" role="dialog" aria-labelledby="katy-modal-label" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="trisha-modal-label">Katy Perry</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<p>Supervisor</p>
			<p>Email: katy@example.com</p>
			<p>Phone: 123-456-7890</p>
		  </div>
		</div>
	  </div>
	</div>
	
	<hr>
	<br>
	
	<div class="custom-card">
	
	<!--Icons-->
	<div class="row">
	  <div class="col-lg-3 col-md-6 col-sm-12">
		<div class="card custom-card m-3">
		  <a href="https://outlook.com/mail" style="color: black;">
			<div class="card-body text-center">
			  <h4>Email</h4>
			  <img class="card-img-top img-fluid" src="Assets/Images/email.png" alt="Card image cap">
			</div>
		  </a>
		</div>
	 </div>

    <div class="col-lg-3 col-md-6 col-sm-12">
    <div class="card custom-card m-3">
      <a href="#" data-toggle="modal" data-target="#profile-modal"style="color: black;">
        <div class="card-body text-center">
          <h4>Profile</h4>
          <img class="card-img-top img-fluid" src="Assets/Images/profile.png" alt="Card image cap">
        </div>
      </a>
      
	  <!-- Profile Modal -->
    <div class="modal fade" id="profile-modal" tabindex="-1" role="dialog" aria-labelledby="profile-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="profile-modal-label">User Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <?php 
      if (isset($_SESSION['staff_id'])) {
        // Retrieve staff member details from database
        $staffID = $_SESSION['staff_id'];
        $query = "SELECT * FROM staff WHERE staffID = '$staffID'";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
      ?>

      <div class="modal-body">
        <div class="row">
          <br>
          <div class="col-sm-4 text-center">
            <img src="Assets/Images/profile.png" class="img-fluid rounded-circle">
          </div>
          <div class="col-sm-8">
            <h3><?php echo $row['fName'] . ' ' . $row['lName']; ?></h3>
            <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
            <p><strong>Position:</strong> <?php echo $row['position']; ?></p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

      <?php } else { ?>
      <!-- display a message or redirect to the login page if staffID session variable is not set -->
      <?php } ?>
      
    </div>
  </div>
</div>

    </div>
  </div>

    <div class="col-lg-3 col-md-6 col-sm-12">
    <div class="card custom-card m-3">
      <a href="#" data-toggle="modal" data-target="#discount-modal" style="color: black;">
        <div class="card-body text-center">
          <h4>Discount</h4>
          <img class="card-img-top img-fluid" src="Assets/Images/discount.png" alt="Card image cap">
        </div>
      </a>
		  <!-- Discount Modal -->
		  <div class="modal fade" id="discount-modal" tabindex="-1" role="dialog" aria-labelledby="discount-modal-label" aria-hidden="true">
			<div class="modal-dialog" role="document">
			  <div class="modal-content">
				<div class="modal-header">
				  <h5 class="modal-title" id="discount-modal-label">Discount</h5>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
				<div class="modal-body">
				  <!-- Discount content goes here -->
				  <h4>Staff Discount Code:</h4>
				  <p>DISCOUNT10</p>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	 
	  <div class="col-lg-3 col-md-6 col-sm-12">
    <div class="card custom-card m-3">
        <a href="signout.php" style="color: black;">
            <div class="card-body text-center">
                <h4>Log Out</h4>
                <img class="card-img-top img-fluid" src="Assets/Images/logout.png" alt="Card image cap">
            </div>
        </a>
    </div>
</div>

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


<?php 
mysqli_close($connection);

?>