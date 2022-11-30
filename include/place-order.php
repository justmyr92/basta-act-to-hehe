<?php
include "database.php";
session_start();

$customer_id = $_SESSION['CUSTOMER_ID'];
$transaction_id = $_POST['transaction_id'];
$transaction_date = date("Y-m-d");
$total_price = 0;
//insert to transaciton table

$sql = "INSERT INTO transaction(TRANSACTION_ID, CUSTOMER_ID, TRANSACTION_DATE, TOTAL) VALUES ('$transaction_id', '$customer_id', '$transaction_date', $total_price);";

if ($conn->query($sql) === TRUE) {
    //select from cat inner joinproduct
    $sql = "SELECT * FROM cart INNER JOIN product ON cart.PRODUCT_ID = product.PRODUCT_ID WHERE cart.CUSTOMER_ID = '$customer_id';";
    $cart = $conn->query($sql);
    if ($cart->num_rows > 0) {
        while ($cart_data = $cart->fetch_assoc()) {
            $product_id = $cart_data['PRODUCT_ID'];
            $quantity = $cart_data['QUANTITY'];
            $price = $cart_data['PRICE'];
            $stocks = $cart_data['STOCKS'];
            $subtotal = $quantity * $price;
            $total_price += $subtotal;
            $orderline_id = "OID" . rand(1000000, 9999999);
            $sql = "INSERT INTO orderline(ORDERLINE_ID, TRANSACTION_ID, PRODUCT_ID, QUANTITY, SUBTOTAL) VALUES ('$orderline_id', '$transaction_id', '$product_id', $quantity, $subtotal);";
            echo $sql;
            if ($conn->query($sql) === TRUE) {
                $sql = "UPDATE product SET STOCKS = $stocks - $quantity WHERE PRODUCT_ID = '$product_id';";
                echo $sql;
                if ($conn->query($sql) === TRUE) {
                    //update total from transaction table
                    $sql = "UPDATE transaction SET TOTAL = $total_price WHERE TRANSACTION_ID = '$transaction_id';";
                    if ($conn->query($sql) === TRUE) {
                        $sql = "DELETE FROM cart WHERE PRODUCT_ID = '$product_id' AND CUSTOMER_ID = '$customer_id';";
                        if ($conn->query($sql) === TRUE) {
                            echo "Record deleted successfully";
                        }
                    }
                }
            }
        }
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}