<?php
include "database.php";
session_start();

//delete from cart where product id and customer id is equal to the product id and customer id of the button clicked
$sql = "DELETE FROM cart WHERE PRODUCT_ID = '" . $_POST['product_id'] . "' AND CUSTOMER_ID = '" . $_SESSION['CUSTOMER_ID'] . "';";
if ($conn->query($sql) == TRUE) {
    echo "Record deleted successfully";
    header("Location: ../index.php");
} else {
    echo "Error deleting record: " . $conn->error;
    header("Location: ../index.php");
}