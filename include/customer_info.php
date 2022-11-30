<?php


$sql = "SELECT * FROM customer WHERE CUSTOMER_ID = '" . $_SESSION['CUSTOMER_ID'] . "';";
$customer = $conn->query($sql);
if ($customer->num_rows > 0) {
    while ($customer_info = $customer->fetch_assoc()) {
        $customer_id = $customer_info['CUSTOMER_ID'];
        $firstname = $customer_info['FIRSTNAME'];
        $lastname = $customer_info['LASTNAME'];
        $address = $customer_info['ADDRESS'];
        $bday = $customer_info['BIRTHDAY'];
        $age = $customer_info['AGE'];
    }
} else {
    echo "0 customers";
}