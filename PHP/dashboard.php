<!-- dashboard.php -->
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  // Redirect to sign-in page if user is not signed in
  header("Location: http://localhost/dbtest/signin.html");
  exit();
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Dashboard</title>
  </head>
  <body>
    <h1>Welcome to the Dashboard!</h1>
    <p>You are now signed in.</p>
  </body>
</html>
