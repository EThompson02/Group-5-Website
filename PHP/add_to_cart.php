<?php
session_start();
if (!empty($_SESSION)) { // not a new session
  session_regenerate_id(TRUE); // make new session id
  }
$productID = $_POST['productID'];
$quantity = $_POST['quantity'];

if (!isset($_SESSION['customer_id'])) {
  // customer is not logged in, redirect to login page
  header('Location: signin.html');
  exit();
}

// Add the item to the cart
$_SESSION['cart'][$productID] = $quantity;

// Redirect back to the product page
header('Location: product.php?productID=' . $productID);
exit();
?>