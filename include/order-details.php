<?php
include "database.php";
session_start();
$customer_id = $_SESSION['CUSTOMER_ID'];
$transation_id = $_POST['transaction_id'];

//select name, price quantity, subtotal inner join from orderline and product where transaction id is equal to the transaction id of the button clicked
$sql = "SELECT * FROM orderline INNER JOIN product ON orderline.PRODUCT_ID = product.PRODUCT_ID WHERE orderline.TRANSACTION_ID = '$transation_id';";
$orderline = $conn->query($sql);
if ($orderline->num_rows > 0) {
    while ($orderline_data = $orderline->fetch_assoc()) {
        $name = $orderline_data['NAME'];
        $price = $orderline_data['PRICE'];
        $quantity = $orderline_data['QUANTITY'];
        $subtotal = $orderline_data['SUBTOTAL'];
        echo "<tr>";
        echo "<td>$name</td>";
        echo "<td>$quantity</td>";
        echo "<td>$price</td>";
        echo "<td>$subtotal</td>";
        echo "</tr>";
    }
}