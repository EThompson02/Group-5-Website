<?php
$con = mysqli_connect("localhost", "root", "", "music");
$cart_count = 0;
$errorMsg = "";
if (isset($_POST['submit'])) {
    if (array_key_exists('first_name', $_POST) && array_key_exists('last_name', $_POST) &&
        array_key_exists('email', $_POST) && array_key_exists('password', $_POST) &&
        array_key_exists('address', $_POST) && array_key_exists('city', $_POST) &&
        array_key_exists('postcode', $_POST) && array_key_exists('country', $_POST)) {
        $firstname = mysqli_real_escape_string($con, $_POST['first_name']);
        $lastName = mysqli_real_escape_string($con, $_POST['last_name']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $address = mysqli_real_escape_string($con, $_POST['address']);
        $city = mysqli_real_escape_string($con, $_POST['city']);
        $postcode = mysqli_real_escape_string($con, $_POST['postcode']);
        $country = mysqli_real_escape_string($con, $_POST['country']); 
        // Database connection
        if($con->connect_error){
            echo "$con->connect_error";
            die("Connection Failed : ". $con->connect_error);
        } else {
            $sql = "SELECT * FROM customer WHERE email = '$email'";
            $execute = mysqli_query($con, $sql);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorMsg = "Email in not valid try again";
            } else if(strlen($password) < 6) {
                $errorMsg  = "Password should be six digits";
            } else if($execute->num_rows == 1){
                $errorMsg = "This Email is already exists";
            } else {
                $query= "INSERT INTO customer (email,password, first_name, last_name, address, city, postcode, country)
                          VALUES( '$email','$password', '$firstname', '$lastName', '$address', '$city', '$postcode', '$country')";
                $result = mysqli_query($con, $query);
                if ($result == true) {
                    header("Location:signin.php");
                } else {
                    $errorMsg  = "You are not Registred..Please Try again";
                }
            }
        }
    } else {
        $errorMsg = "Please fill out all required fields";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sign Up</title>
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

	
<div class="container rounded text-center">
  <img class="profile-img" src="assets/images/logo.png" alt="Profile Image">
  <div class="container text-center">
    <h1>Sign Up</h1>
	<h6> Join over 10000 users and start rockin' today!</h6>
  </div>
  <form  method="POST" class="needs-validation" novalidate>
    <div class="row mb-3">
      <div class="col-md-6">
        <label for="first_name" class="form-label"><br>First Name</label>
        <input type="text" class="form-control" id="first_name" name="first_name" required>
        <div class="invalid-feedback">
          Please enter your first name.
        </div>
      </div>
      <div class="col-md-6">
        <label for="last_name" class="form-label"><br>Last Name</label>
        <input type="text" class="form-control" id="last_name" name="last_name" required>
        <div class="invalid-feedback">
          Please enter your last name.
        </div>
      </div>
    </div>
    <div class="form-group custom-form-group">
      <label for="username" class="form-label">Username</label>
      <input type="text" class="form-control" id="username" name="username" required>
      <div class="invalid-feedback">
        Please enter a username.
      </div>
    </div>
    <div class="form-group custom-form-group">
      <label for="email" class="form-label">Email address</label>
      <input type="email" class="form-control" id="email" name="email" required>
      <div class="invalid-feedback">
        Please enter a valid email address.
      </div>
    </div>
	<div class="form-group custom-form-group">
  <label for="password" class="form-label">Password</label>
  <input type="password" class="form-control" id="password" name="password" required>
  <div class="invalid-feedback">
    Please enter a password.
  </div>
</div>
<div class="form-group custom-form-group">
  <label for="confirm_password" class="form-label">Confirm Password</label>
  <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
  <div class="invalid-feedback">
    Please confirm your password.
  </div><br><hr>
</div>
<script>
  const password = document.querySelector('#password');
  const confirm_password = document.querySelector('#confirm_password');
  function validatePassword() {
    if (password.value !== confirm_password.value) {
      confirm_password.setCustomValidity("Passwords do not match");
    } else {
      confirm_password.setCustomValidity("");
    }
  }
  password.addEventListener('change', validatePassword);
  confirm_password.addEventListener('keyup', validatePassword);
</script>


	<h4>Address:</h4>
	<div class="form-group custom-form-group">
      <label for="username" class="form-label">Street</label>
      <input type="text" class="form-control" id="address" name="address" pattern="^[a-zA-Z0-9\s,'-]+$" required>
      <div class="invalid-feedback">
        Please enter a valid street name.
      </div>
    </div>
	<div class="form-group custom-form-group">
      <label for="username" class="form-label">City</label>
      <input type="text" class="form-control" id="city" name="city" pattern="^[a-zA-Z\s]+$" required>
      <div class="invalid-feedback">
        Please enter a valid city name.
      </div>
    </div>
	<div class="form-group custom-form-group">
      <label for="username" class="form-label">Postcode</label>
      <input type="text" class="form-control" id="postcode" name="postcode" pattern="^[A-Z]{1,2}[0-9][0-9A-Z]?\s?[0-9][A-Z]{2}$" required>
      <div class="invalid-feedback">
        Please enter a valid Postcode.
      </div>
    </div>
    <div class="form-group custom-form-group text-center">
      <label for="country" class="form-label">Country</label>
      <div class="dropdown d-inline-block">
        <button class="btn btn-light dropdown-toggle" type="button" id="countryDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <img src="assets/uk.png" alt="UK Flag" class="flag-image"> UK
        </button>
        <div class="dropdown-menu" aria-labelledby="countryDropdown">
          <a class="dropdown-item" href="#" onclick="event.preventDefault(); setCountry('UK')">
            <img src="assets/uk.png" alt="UK Flag" class="flag-image"> UK
          </a>
          <a class="dropdown-item" href="#" onclick="event.preventDefault(); setCountry('Ireland')">
            <img src="assets/ireland.png" alt="Ireland Flag" class="flag-image"> Ireland
          </a>
        </div>
      </div>
      <input type="hidden" id="countryInput" name="country" value="">
    </div>
    
	
    <script>
     function setCountry(country) {
  // Update the hidden input with the selected country
  document.getElementById('countryInput').value = country;
  // Update the dropdown button text and flag image with the selected country
  var dropdownButton = document.getElementById('countryDropdown');
  dropdownButton.innerHTML = '<img src="assets/' + country.toLowerCase() + '.png" alt="' + country + ' Flag" class="flag-image"> ' + country;
}
    </script>
    

    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" value="" id="terms" required>
      <label class="form-check-label" for="terms">
        I agree to the <a href="#">terms and conditions</a>
      </label>
      <div class="invalid-feedback">
        You must agree to the terms and conditions.
      </div>
    </div>
    <button type="submit" class="btn btn-dark btn-block">Sign Up</button>
	<div class="container text-center mt-3">
    <p>Have an account already? <a href="signin.html">Sign in</a>.</p>
  </div>
  </form>
</div>


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
