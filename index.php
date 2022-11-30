<?php

include 'include/database.php';
session_start();
if (isset($_POST['usernameInput']) && isset($_POST['passwordInput'])) {
    $username = $_POST['usernameInput'];
    $password = md5($_POST['passwordInput']);
    $sql = "SELECT CUSTOMER_ID, PRIVILEGES FROM ACCOUNT WHERE USERNAME = '$username' AND PASSWORD = '$password'";
    echo $sql;
    $account = $conn->query($sql);
    if ($account->num_rows > 0) {
        while ($account_data = $account->fetch_assoc()) {
            $_SESSION['CUSTOMER_ID'] = $account_data['CUSTOMER_ID'];
            $_SESSION['PRIVILEGES'] = $account_data['PRIVILEGES'];
            $login_authentication = "VERIFIED";
        }
    } else {
        $login_authentication = "FAILED";
    }
}

if (isset($_SESSION['CUSTOMER_ID'])) {
    include "include/customer_info.php";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <script src="https://code.jquery.com/jquery-3.6.1.js"
        integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous">
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include 'include/navbar.php'; ?>
    <section class="home-section">
        <div class="container h-100">
            <div class="d-flex align-items-center justify-content-start h-100">
                <div class="content">
                    <h3>Mischievous Vape Lounge</h3>
                    <h2>Lorem ipsum dolor sit amet, consectetur <br> adipiscing elit.</h2>
                    <a href="shop.php" class="btn btn-primary rounded-0">Shop Now</a>
                </div>
            </div>
        </div>
    </section>
    <section class="category-section border">
        <div class="container h-100 border">
            <div class="d-flex justify-content-center align-items-center gap-4 h-100 border">
                <div class="card text-bg-dark">
                    <img src="https://images.pexels.com/photos/1005486/pexels-photo-1005486.jpeg?auto=compress&cs=tinysrgb&w=600"
                        class="card-img" alt="...">
                    <div class="card-img-overlay">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                            additional content. This content is a little bit longer.</p>
                        <p class="card-text"><small>Last updated 3 mins ago</small></p>
                    </div>
                </div>
                <div class="card text-bg-dark">
                    <img src="https://images.pexels.com/photos/1005486/pexels-photo-1005486.jpeg?auto=compress&cs=tinysrgb&w=600"
                        class="card-img" alt="...">
                    <div class="card-img-overlay">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                            additional content. This content is a little bit longer.</p>
                        <p class="card-text"><small>Last updated 3 mins ago</small></p>
                    </div>
                </div>
                <div class="card text-bg-dark">
                    <img src="https://images.pexels.com/photos/1005486/pexels-photo-1005486.jpeg?auto=compress&cs=tinysrgb&w=600"
                        class="card-img" alt="...">
                    <div class="card-img-overlay">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                            additional content. This content is a little bit longer.</p>
                        <p class="card-text"><small>Last updated 3 mins ago</small></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="sample-product-section">
        <div class="container h-100">
            <div class="d-flex align-content-start justify-content-between flex-wrap h-100 py-5">
                <?php
                $sql = "SELECT * FROM product LIMIT 12";
                $product = $conn->query($sql);
                if ($product->num_rows > 0) {

                    while ($product_data = $product->fetch_assoc()) {
                        echo '<div class="card mb-3" style="width: 18rem;">
                    <img src="https://images.pexels.com/photos/1005486/pexels-photo-1005486.jpeg?auto=compress&cs=tinysrgb&w=600"
                        class="card-img-top" alt="...">
                    <div class="card-body">
                        <h6 class="card-title">' . $product_data["NAME"] . '</h6>
                
                        <p class="card-text">' . $product_data["TYPE"] . '</p>
                        <p class="card-text">  &#8369; ' . number_format($product_data['PRICE'], 2) . '</p>
                        <button type="button" class="btn btn-primary rounded-0 add-to-cart-btn" id="' . $product_data['PRODUCT_ID'] . '">Add to cart</button>
                    </div>
                </div>';
                    }
                } else {
                    echo "0 results";
                }
                ?>
            </div>
            <div class="d-flex justify-content-center pb-5">
                <a href="shop.php" class="btn btn-primary rounded-0">View more</a>
            </div>
        </div>
    </section>
    <?php
    if (isset($login_authentication)) {
        if ($login_authentication == "VERIFIED") {

    ?>
    <script>
    $(document).ready(function() {
        Swal.fire({
            icon: 'success',
            title: 'Login Successful',
            text: 'Welcome to Mischievous Vape Lounge'
        });
    });
    </script>
    <?php
        } else {
        ?>
    <script>
    $(document).ready(function() {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Incorrect username or password'
        });
    });
    </script>
    <?php
        }
        unset($login_authentication);
    }
    ?>
    <script>
    $(document).ready(function() {
        function getPrintTotal() {
            var price = $(".price");
            var quantity = $(".quantity");
            var sbtotal_text = $(".subtotal");
            var total = 0;
            for (var i = 0; i < price.length; i++) {
                var price_value = parseFloat(price[i].innerHTML);
                var quantity_value = parseInt(quantity[i].value);
                var subtotal = price_value * quantity_value;
                sbtotal_text[i].innerHTML = "₱ " + subtotal;
                total += subtotal;
            }
            $('.total').text("₱ " + total);
        }
        getPrintTotal();
        $('.add-to-cart-btn').click(function() {
            var product_id = $(this).attr('id');
            $.ajax({
                url: "include/add-to-cart.php",
                method: "POST",
                data: {
                    product_id: product_id
                },
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Added to cart',
                        text: 'Product added to cart',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        location.reload();
                    });
                }
            });
        });
        $('.quantity').change(function() {
            var product_id = $(this).attr('id');
            var quantity = $(this).val();
            getPrintTotal();
            $.ajax({
                url: "include/update-cart.php",
                method: "POST",
                data: {
                    product_id: product_id,
                    quantity: quantity
                },
                success: function(data) {}
            });
        });
        $('.delete-from-cart-btn').click(function() {
            var product_id = $(this).attr('id');
            console.log(product_id);
            $.ajax({
                url: "include/delete-from-cart.php",
                method: "POST",
                data: {
                    product_id: product_id
                },
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Removed from cart',
                        text: 'Product removed from cart',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        location.reload();
                    });
                }
            });
        });
        $('.place-order').click(function() {
            //var generate trasaction id with tid and random number from 100000 to 999999
            var transaction_id = "TID" + Math.floor(Math.random() * 900000) + 100000;
            Swal.fire({
                title: 'Place Order',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, check it out!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "include/place-order.php",
                        method: "POST",
                        data: {
                            transaction_id: transaction_id
                        },
                        success: function(data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Order placed successfully',
                                text: 'Redirecting to transaction page',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location.href = "transaction.php";
                            });
                        }
                    });
                }
            })
        });
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
</body>

</html>