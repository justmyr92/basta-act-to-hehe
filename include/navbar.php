<nav class="navbar navbar-expand-lg bg-light py-3 fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">Mischievous Vape Lounge</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse position-absolute start-50 translate-middle-x" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="shop.php">Shop</a>
                </li>
            </ul>
        </div>
        <div class="d-flex">
            <!-- Button trigger modal -->
            <?php
            if (isset($_SESSION['CUSTOMER_ID'])) {
            ?>
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bi bi-person-circle"></i> Welcome <?php echo $firstname; ?>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="transaction.php">Transaction</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </div>
            <?php
            } else {
            ?>
            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#loginModal">
                <i class="bi bi-person-circle"></i>
            </button>
            <?php
            }

            if (isset($_SESSION['CUSTOMER_ID'])) {

                //count cart by customer
                $sql = "SELECT COUNT(*) FROM CART WHERE CUSTOMER_ID = '" . $_SESSION['CUSTOMER_ID'] . "';";
                $cart = $conn->query($sql);
                if ($cart->num_rows > 0) {
                    while ($cart_data = $cart->fetch_assoc()) {
                        $cart_count = $cart_data['COUNT(*)'];
                    }
                } else {
                    $cart_count = 0;
                }
            ?>

            <button class="btn btn-light position-relative" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                <i class="bi bi-cart-fill"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <?php echo $cart_count; ?>
                    <span class="visually-hidden">unread messages</span>
                </span>
            </button>
            <?php
            }
            ?>
        </div>
    </div>
</nav>

<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="loginModalLabel">Login</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="usernameInput" name="usernameInput"
                            placeholder="Username">
                        <label for="usernameInput">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="passwordInput" name="passwordInput"
                            placeholder="Password" autocomplete="off">
                        <label for="passwordInput">Password</label>
                    </div>
                    <button type="submit" class="btn btn-primary mb-3 rounded-0">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel"
    style="width:max-content;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">You cart</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="table-responsive">
            <table class="table">
                <?php
                if (isset($_SESSION['CUSTOMER_ID'])) {
                    $sql = "SELECT * FROM cart INNER JOIN product ON cart.PRODUCT_ID = product.PRODUCT_ID WHERE cart.CUSTOMER_ID = '$customer_id'";
                    $cart = $conn->query($sql);
                    $total = 0;
                    if ($cart->num_rows > 0) {
                        echo "<thead>";
                        echo "    <tr>";
                        echo "        <th scope='col'>Product</th>";
                        echo "        <th scope='col'>Price</th>";
                        echo "        <th scope='col'>Quantity</th>";
                        echo "        <th scope='col'>Total</th>";
                        echo "        <th scope='col'>Action</th>";
                        echo "    </tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while ($cart_info = $cart->fetch_assoc()) {
                            $total += $cart_info['PRICE'];
                            echo "<tr>";
                            echo "    <td>" . $cart_info['NAME'] . "</td>";
                            echo "    <td class='price text-end'>" . $cart_info['PRICE'] . "</td>";
                            echo "    <td><input type='number' id='" . $cart_info['PRODUCT_ID'] . "' class='form-control quantity' value='" . $cart_info['QUANTITY'] . "' min='1' max='" . $cart_info['STOCKS'] . "'></td>";
                            echo "    <td class='subtotal text-end'>" . $cart_info['PRICE'] * $cart_info['QUANTITY'] . "</td>";
                            echo "    <td><button type='button' id='" . $cart_info['PRODUCT_ID'] . "' class='btn btn-danger delete-from-cart-btn'><i class='bi bi-trash-fill'></i></button></td>";
                            echo "</tr>";
                        }
                        echo "<tr>";
                        echo "<td colspan='3' class='text-end'>Total:</td>";
                        echo "<td colspan='3' class='total'></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th colspan='5' class='text-start'>";
                        echo  "Order Summary";
                        echo "</th>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td colspan='5' class='text-start'>";
                        echo $firstname . " " . $lastname;
                        echo "</td>";
                        echo "<tr>";
                        echo "<td colspan='5' class='text-start'>";
                        echo $address;
                        echo "</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td colspan='5' class='text-start'>";
                        echo "<button type='button' class='btn btn-primary rounded-0 place-order'>Place Order</button>";
                        echo "</td>";
                        echo "</tr>";
                        echo "</tbody>";
                    } else {
                        echo "<tr><td colspan='5'><h3>No product in your cart</h3></td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'><h3>Please login to view your cart</h3></td></tr>";
                }

                ?>
            </table>
        </div>
    </div>
</div>