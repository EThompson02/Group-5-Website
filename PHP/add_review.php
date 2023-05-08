<?php
session_start();

if(!isset($_SESSION['customer_id'])) {
    header('Location: signin.php');
    exit();
}
if (!empty($_SESSION)) { // not a new session
    session_regenerate_id(TRUE); // make new session id
    }

$mysqli = mysqli_connect("localhost", "root", "", "music");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// retrieve review data from POST parameters
$productID = $_POST['productID'];
$reviewText = $_POST['reviewText'];
$rating = $_POST['rating'];
$customerID = $_SESSION['customer_id'];

// retrieve customer name from database
$stmt = $mysqli->prepare("SELECT first_name, last_name FROM customer WHERE customerID = ?");
$stmt->bind_param("s", $customerID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $customerName = $row['first_name'] . ' ' . $row['last_name'];
} else {
    $customerName = 'Unknown';
}

$stmt->close();

// insert review data into database
$stmt = $mysqli->prepare("INSERT INTO reviews (productID, customerID, customerName, comment, rating) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $productID, $customerID, $customerName, $reviewText, $rating);
$stmt->execute();

$stmt->close();

$mysqli->close();

// redirect back to product page
header("Location: product.php?productID=$productID");
exit();
?>
