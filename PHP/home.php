<?php

session_start();
$cart_count = 0;
if (!empty($_SESSION)) { // not a new session
    session_regenerate_id(TRUE); // make new session id
    }

	if(isset($_SESSION['cart'])) {
		$cart_count = count($_SESSION['cart']);
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Home</title>
  <link rel="stylesheet" href="assets/stylesheets/main.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Favicon -->
  <link rel="shortcut icon" type="image/png" href="assets/logo.png">
  <!-- Bootstrap icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Font Awesome icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://kit.fontawesome.com/15ec1140f7.js" crossorigin="anonymous"></script>
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
			<button type="button" class="btn btn-danger" data-bs-dismiss="modal">x</button>
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
			  <div class="modal-footer">
				<button type="submit" class="btn btn-danger btn-md">Submit</button>
				<button type="reset" class="btn btn-secondary btn-md">Clear</button>
			  </div>
			  </form>
		  </div>
		</div>
	  </div>
	</div>

	<main>
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
	
	<!-- About Us -->	
	<section class="bg-light py-5 py-xl-8">
	  <div class="container">
		<div class="row gy-5 gy-lg-0 gx-lg-6 gx-xxl-8 align-items-lg-center">
		  <div class="col-12 col-lg-6">
			<img class="img-fluid rounded" loading="lazy" src="assets/billClinton.png" alt="">
		  </div>
		  <div class="col-12 col-lg-6">
			<h2 class="h1 mb-3 text-center">About Us</h2>
			<p class="lead fs-4 text-secondaryX mb-5 text-center">Founded in 2023, Rockin’ Records is the largest record selling company to emerge from Alexander McDaid’s 
			sophisticated class ‘COM336’. What began as a passion projects, members Deirbhile Leonard, Charlie Devlin, Emmet Thompson, Alexander Morrison, and 
			Ava Rijkers evolved this small scale website to an international sensation. Rockin’ Records, based in Derry/Londonderrry has cultivated a large following, 
			young and old, singlehandedly bringing records back in style.</p>
			
			<div class="text-center">
				<a href="https://outlook.office.com">
					<button type="button" class="btn btn-outline-danger rounded-pill px-4 gap-3">Contact Us</button>
				</a>
			</div>
		  </div>
		</div>
	  </div>
	</section>
		
	<!-- Recommended Products -->
	
	
	<!-- Staff -->
	<br>
	<hr>
	<div class=" container text-center">
	  <h2><br>Meet Our Team</h2>
	  <h4>Click their Profile to find out more</h4>
	  <div class="row justify-content-center">
		<div class="col-sm-4">
		    <a href="https://twitter.com/violadavis" target="_blank" rel="noopener noreferrer" style="color: black; text-decoration: none;">
			  <img src="Assets/Images/viola1.jpg" class="rounded img-thumbnail">
			  <h4>Viola Davis</h4>
			  <h5>Manager and CEO</h5>
			</a>

		</div>
		<div class="col-sm-4">
		  <a href="https://twitter.com/trishapaytas" target="_blank" rel="noopener noreferrer" style="color: black; text-decoration: none;">
			<img src="Assets/Images/trisha1.jpg" class="rounded img-thumbnail">
			<h4>Trisha Paytas</h4>
			<h5>Deputy Manager</h5>
		  </a>
		</div>
		<div class="col-sm-4">
		  <a href="https://twitter.com/katyperry" target="_blank" rel="noopener noreferrer" style="color: black; text-decoration: none;">
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
 
	<!-- FAQ -->
	<hr>
	<br>
	<div class="faq_area section_padding_130" id="faq">
	  <div class="container-lg">
		<div class="row justify-content-center">
		  <div class="col-12 col-sm-8 col-lg-6">
			<!-- Section Heading-->
			<div class="section_heading text-center wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
			  <h3><span>Frequently </span> Asked Questions</h3>
			  <p>Check out below any questions you may have!</p>
			  <div class="line"></div>
			</div>
		  </div>
		</div>
		<div class="row justify-content-center">
		  <!---->
		  <div class="col-12 col-sm-10 col-lg-8">
			<div class="accordion faq-accordian" id="faqAccordion">
			  <div class="card border-0 wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
			  <!-- Question 1 -->
				<div class="card-header" id="headingOne">
				  <h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">What do you sell?<span class="lni-chevron-up"></span></h6>
				</div>
				<div class="collapse" id="collapseOne" aria-labelledby="headingOne" data-parent="#faqAccordion">
				  <div class="card-body" style="width: 100%;">
					<p>We sell the lastest Vinyl Records, specialising in Rock Music. From Elvis Presley to Tenacious D, there really is something for everyone </p>
					<p>We also have released our exclusive merchandise, so shop quick before it sells out!</p>
				  </div>
				</div>
			  </div>
			  
			  <!--Question 2 -->
			  <div class="card border-0 wow fadeInUp" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
				<div class="card-header" id="headingTwo">
				  <h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">How long will it take to receive my order?<span class="lni-chevron-up"></span></h6>
				</div>
				<div class="collapse" id="collapseTwo" aria-labelledby="headingTwo" data-parent="#faqAccordion">
				  <div class="card-body">
					<p>Shipping times vary depending on your location and the shipping method you choose at checkout. In general, orders are processed within 1-2 
					business days and shipped via standard or expedited shipping. </p>
					<p>You will receive a tracking number via email once your order has shipped.</p>
				  </div>
				</div>
			  </div>
			  
			<!--Question 3 -->
			<div class="card border-0 wow fadeInUp" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
				<div class="card-header" id="headingThree">
				  <h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">What payment methods do you accept?<span class ="lni-chevron-up"></span></h6>
					</div>
					<div class="collapse" id="collapseThree" aria-labelledby="headingThree" data-parent="#faqAccordion">
						<div class="card-body">
							<p>We accept all major credit cards, including Visa, Mastercard, and Apple Pay, as well as PayPal.</p>
						</div>
					</div>
				</div>
 			
			<!--Question 4 -->
			<div class="card border-0 wow fadeInUp" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
				<div class="card-header" id="headingFour">
				  <h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">What is your return policy?<span class ="lni-chevron-up"></span></h6>
					</div>
					<div class="collapse" id="collapseFour" aria-labelledby="headingFour" data-parent="#faqAccordion">
						<div class="card-body">
							<p>We accept returns within 30 days of purchase for any defective or damaged items.</p>
							<p>If you receive a damaged or defective item, please contact us immediately and we will provide instructions on how to return the item for a refund or exchange.</p>
						</div>
					</div>
				</div>
				
				<!--Question 5 -->
			<div class="card border-0 wow fadeInUp" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
				<div class="card-header" id="headingFive">
				  <h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseFive" aFvea-expanded="true" aria-controls="collapseFive">Can I track my order?<span class ="lni-chevron-up"></span></h6>
					</div>
					<div class="collapse" id="collapseFive" aria-labelledby="headingFive" data-parent="#faqAccordion">
						<div class="card-body">
							<p>Yes, you will receive a tracking number via email once your order has shipped. You can use this tracking number to track your order online.</p>
							<P>Click the below button to track your order</p>
							<div class="text-center">
								<a href="trackinghome.html">
									<button type="button" class="btn btn-outline-danger rounded-pill px-4 gap-3">Track Now</button>
								</a>
							</div>
						</div>
					</div>
				</div>
				
				<!--Question 6 -->
			<div class="card border-0 wow fadeInUp" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
				<div class="card-header" id="headingSix">
				  <h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="true" aria-controls="collapseThree">What types of vinyls do you sell?<span class ="lni-chevron-up"></span></h6>
					</div>
				 	<div class="collapse" id="collapseSix" aria-labelledby="headingSix" data-parent="#faqAccordion">
						<div class="card-body">
							<p>We sell a wide variety of rock vinyls, including classic albums, new releases, and limited edition pressings. </p>
							<p>Our selection includes genres such as classic rock, metal, punk, and indie rock, among others.</p>
						</div>
					</div>
				</div>
			</div>
			
					<!-- Support Button-->
					<div class="support-button text-center d-flex align-items-center justify-content-center mt-4 wow fadeInUp" data-wow-delay="0.5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInUp;">
						<i class="lni-emoji-sad"></i>
						<p class="mb-0 px-2">Can't find your answers? Contact us VIA the chat icon on the bottom right of your screen!</p>
					</div>
				</div>
			</div>
		</div>
		<br>
		<br>
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