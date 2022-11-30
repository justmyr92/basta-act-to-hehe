<?php

include "database.php";

session_start();

$customer_id = $_SESSION['CUSTOMER_ID'];

$product_id = $_POST['product_id'];

$quantity = 0;

//select if customer and product id already exists in cart if it is already in cart, increase quantity by 1

$sql = "SELECT * FROM cart WHERE CUSTOMER_ID = '$customer_id' AND PRODUCT_ID = '$product_id';";

$cart = $conn->query($sql);

if ($cart->num_rows > 0) {

    while ($cart_data = $cart->fetch_assoc()) {
        $quantity = $cart_data['QUANTITY'] + 1;
    }
    //update quantity in cart
    $sql = "UPDATE cart SET QUANTITY = '$quantity' WHERE CUSTOMER_ID = '$customer_id' AND PRODUCT_ID = '$product_id';";
    $conn->query($sql);
} else {
    $quantity = 1;
    $sql = "INSERT INTO cart (CUSTOMER_ID, PRODUCT_ID, QUANTITY) VALUES ('$customer_id', '$product_id', '$quantity');";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}