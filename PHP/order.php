<?php 
session_start();
if (!empty($_SESSION)) { // not a new session
    session_regenerate_id(TRUE); // make new session id
    }

$mysqli = new mysqli("localhost", "root", "", "music");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

// Check if the order button is pressed and if the cart is not empty
if (isset($_POST['submit']) && isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    // Get customerID from session
    $customerID = $_SESSION['customer_id'];

    // Insert order into the order table
    $stmt = $mysqli->prepare("INSERT INTO `order` (`productID`, `customerID`, `quantity`, `sellPrice`) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $productID, $customerID, $quantity, $sellPrice);

    $productIDs = array_keys($_SESSION['cart']);
    foreach ($productIDs as $productID) {
        // Get the quantity of the item in the cart
        $cartQuantity = $_SESSION['cart'][$productID];
        $quantity = ($cartQuantity != '') ? $cartQuantity : 0;

        // Get the sellPrice of the product from the database
        $stmt2 = $mysqli->prepare("SELECT sellPrice FROM product WHERE productID = ?");
        $stmt2->bind_param("i", $productID);
        $stmt2->execute();
        $stmt2->bind_result($sellPrice);
        $stmt2->fetch();
        $stmt2->close();

        // Calculate subtotal for each item and accumulate total price
        $subtotal = $sellPrice * $quantity;

        // Insert order into order table
        $stmt->execute();
        
        // Update product quantity in the product table
        $stmt3 = $mysqli->prepare("UPDATE product SET quantity = quantity - ? WHERE productID = ?");
        $stmt3->bind_param("ii", $quantity, $productID);
        $stmt3->execute();
        $stmt3->close();
    }
    
    $stmt->close();
    
    // Retrieve the order ID from the database
    $stmt4 = $mysqli->prepare("SELECT orderID FROM `order` WHERE customerID = ? ORDER BY orderID DESC LIMIT 1");
    $stmt4->bind_param("i", $customerID);
    $stmt4->execute();
    $stmt4->bind_result($orderID);
    $stmt4->fetch();
    $stmt4->close();

    // Clear the cart
    $_SESSION['cart'] = array();
    
    // Get the order ID and store it in the session
    $_SESSION['order_id'] = $orderID;

    // Redirect to the order confirmation page
    header("Location: order-confirmation.php?orderID=" . $orderID);
    exit();
}
 ?>