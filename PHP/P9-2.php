<?php
session_start();
define( "USERNAME", "john" );
define( "PASSWORD", "secret" );

if (isset( $_POST["login"] ) )
{
login();
} elseif ( isset( $_GET["action"] ) and $_GET["action"] == "logout" ) {
logout();
} elseif ( isset( $_SESSION["username"] ) ) {
displayPage();
} else {
displayLoginForm();
}

function login() {
if (isset( $_POST["username"] ) and isset( $_POST["password"] ) ) {
if ($_POST["username"] == USERNAME and $_POST["password"] == PASSWORD ) {
$_SESSION["username"] = USERNAME;
header( "Location: P9-2.php" );
} else {
displayLoginForm("Sorry, that username/password could not be found. Please try again.");
}
}
}

function logout() {
unset($_SESSION["username"] );
header("Location: P9-2.php");
}

function displayPage() {
displayPageHeader();
?>

<p> Welcome, <strong> <?php echo $_SESSION["username"] ?> </strong> ! You are currently logged in. </p>
<p> <a href="signin.htmlaction=logout" > Logout </a> </p>
</body>
</html>

<?php
}
function displayLoginForm( $message="" ) {
displayPageHeader();
?>

<?php if ( $message ) echo ' <p class="error"> ' . $message . ' </p> ' ?>

<form action="P9-2.php" method="post">
<div style="width: 30em;">
<label for="username" > Username </label>
<input type="text" name="username" id="username" value="" />
<label for="password" > Password </label>
<input type="password" name="password" id="password" value="" />
<div style="clear: both;" >
<input type="submit" name="login" value="Login" />
</div>
</div>
</form>
</body>
</html>

<?php
}
function displayPageHeader() {
?>

<html>
<head>
<title> A login/logout system </title>
<link rel="stylesheet" type="text/css" href="common.css" />
<style type="text/css">
.error { background: #d33; color: white; padding: 0.2em; }
</style>

</head>
<body>

<h1> A login/logout system </h1>

<?php
}
?>
