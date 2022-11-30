<?php

include "database.php";
session_start();

//update quantity in cart
$sql = "UPDATE cart SET QUANTITY = '" . $_POST['quantity'] . "' WHERE PRODUCT_ID = '" . $_POST['product_id'] . "' AND CUSTOMER_ID = '" . $_SESSION['CUSTOMER_ID'] . "';";

$conn->query($sql);