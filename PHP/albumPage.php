<?php

session_start();
$cart_count = 0;
if(isset($_SESSION['cart'])) {
    $cart_count = count($_SESSION['cart']);
}
if (!empty($_SESSION)) { // not a new session
  session_regenerate_id(TRUE); // make new session id
  }

$connect = mysqli_connect("localhost", "root", "", "music");

?>

<!DOCTYPE html>
<html lang="en">
    <head>
	  <meta charset="utf-8" />
	  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	  <title>Vinyls</title>
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


<!-- Chat -->
  
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

        <!-- Header-->
        <!-- Header-->
<!--Carousel-->
	  <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
		<div class="carousel-indicators">
		  <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
		  <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
		  <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
		</div>
		<div class="carousel-inner">
		  <div class="carousel-item active">
			<img src="assets/queen.jpg" class="d-block w-100" alt="My Image" width="1200" height="450">

			<div class="container">
			  <div class="carousel-caption text-start">
				<h1>Sign Up Today</h1>
				<p>Join over 10,000 users today by clicking below</p>
				<p><a class="btn btn-lg btn-danger" href="signup.php">Sign up</a></p>
			  </div>
			</div>
		  </div>
		  <div class="carousel-item">
			<img src="assets/trishaLoveYouJesus.jpg" class="d-block w-100" alt="My Image" width="1200" height="450">

			<div class="container">
			  <div class="carousel-caption text-end">
			  <iframe style="border-radius:12px" src="https://open.spotify.com/embed/track/3wYmNpzVhpXV9e4YpkHi8W?utm_source=generator&theme=0" width="30%" height="80" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>

				<!--Plays music -->
			  </div>
			</div>
		  </div>
		  <div class="carousel-item">
			<img src="assets/summerSale.jpg" class="d-block w-100" alt="My Image" width="1200" height="450">

			<div class="container">
				<div class="carousel-caption text-end">
					<p><a class="btn btn-lg btn-danger" href="albumPage.php">Shop Now</a></p>
				</div>
			</div>
			
			</div>
		</div>
		<button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
		  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
		  <span class="visually-hidden">Previous</span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
		  <span class="carousel-control-next-icon" aria-hidden="true"></span>
		  <span class="visually-hidden">Next</span>
		</button>
	  </div> 
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</header>

        <!-- Section-->
        <body>

<?php
$query = "SELECT * FROM product ORDER BY productID ASC";
$result = mysqli_query($connect, $query);
$counter = 0;
if(mysqli_num_rows($result) > 0)
{
    echo '<section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
              <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">';
    while($row = mysqli_fetch_array($result))
    {
        $productID = $row["productID"];
        $imageSrc = "data:image/jpeg;base64," .  $row["image"];
        $imageAlt = $row["artistName"] . " - " . $row["albumTitle"];
        $productName = $row["description"];
        $productPrice = $row["sellPrice"];


        $link = "product.php?productID=$productID";

        if ($counter % 4 == 0) {
            echo '</div><div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">';
        }

        echo '<div class="col mb-5">
                <div class="card h-100">
                    <!-- Product image-->
                    <img src="'.$imageSrc.'" alt="'.$imageAlt.'" class="card-img-top">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <!-- Product name-->
                            <h5 class="fw-bolder">'.$productName.'</h5>
                            <!-- Product reviews-->
                            <div class="d-flex justify-content-center small text-warning mb-2">
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                                <div class="bi-star-fill"></div>
                            </div>
                            <!-- Product price-->
                            £'.$productPrice.'
                        </div>
                    </div>
                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="'.$link.'">View More</a></div>
                    </div>
                </div>
              </div>';

        $counter++;
    }

    echo '</div></div></section>';
}
?>
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


    </body>
</html> 
       
    