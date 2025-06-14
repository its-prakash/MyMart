<?php
session_start();
require "../database/database.php";

if (!isset($_SESSION["UserID"]) || $_SESSION["UserID"] == 0) {
    header("Location: sign-in.php");
    exit;
}

$userid = $_SESSION["UserID"];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (($_REQUEST["My-cart"] == "addtocart") && $_REQUEST["product_id"] != NULL) {

        $productid = $_REQUEST["product_id"];

        $checksql = $conn->prepare("SELECT * FROM `my-cart` WHERE user_id = ? AND product_id = ?");
        $checksql->bind_param("ss", $userid, $productid);
        $checksql->execute();

        $row = $checksql->get_result();
        $data = $row->fetch_assoc();

        if (!$data) {
            $insertsql = $conn->prepare("INSERT INTO `my-cart` (user_id , product_id) VALUES (? , ? )");
            $insertsql->bind_param("ss", $userid, $productid);
            $insertsql->execute();
            $insertsql->close();
        }
        $checksql->close();
    }

    // Remove from Wishlist
    if (isset($_REQUEST["delete"]) && ($_REQUEST["delete"] == "from-cart") && !empty($_REQUEST["product_id"])) {
        $productid = $_REQUEST["product_id"];

        $remove = $conn->prepare("DELETE FROM `my-cart` WHERE user_id = ? AND product_id = ?");
        $remove->bind_param("ss", $userid, $productid);
        $remove->execute();
        $remove->close();
    }

    // Redirect to Refresh Data
    header("Location: my-cart.php");
    exit;
}


// Fetch data from cart
$call = $conn->prepare("SELECT * FROM `my-cart` WHERE user_id = ?");
$call->bind_param("s", $userid);
$call->execute();
$result = $call->get_result();

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My-Cart</title>
    <link rel="stylesheet" href="./stylesheet/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php require "../components/navbar.php"; ?>

    <div class="row  d-sm-flex m-0 p-4 ">

        <div class="col-sm-9 p-sm-3 p-1">
            <div class="col-12 bg-light p-3">
                <h2>Shopping Cart</h2>
                <hr>
                <div class="table-responsive overflow-y-scrool" style="max-height: 70vh;">
                    <table class="table table-responsive align-middle table-bordered border-primary">
                        <tr class="table-dark text-center ">
                            <th>Product</th>
                            <th>Product name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total price</th>
                            <th>Remove</th>
                        </tr>

                        <?php

                        while ($display = $result->fetch_assoc()) {
                            $display_productid = $display["product_id"];

                            $data = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                            $data->bind_param("s", $display_productid);
                            $data->execute();

                            $product = $data->get_result()->fetch_assoc();

                            echo '
                                <tr class="text-center border border-info border-3">
                                    <td class="col-2 text-center"><a href="single_product.php?id=' . $product["id"] . '"><img class="col-sm-8 col-12" src="' . $product["imgsrc"] . '" alt=""></a></td>
                                    <td class="col-2">' . $product["title"] . '</td>
                                    <td class="col-2" id="price">' . $product["price"] . '</td>
                                    <td class="col-2 d-flex gap-0 border border-0 mx-3">
                                        <input type="number" value="1" max="10" min="1"  class="border border-0 p-0" id="quantity">
                                        <div>
                                            <button class="btn btn-default" id="btn-plus"><i class="fa-solid fa-plus"></i></button>
                                            <button class="btn btn-default" id="btn-minus"><i class="fa-solid fa-minus"></i></button>
                                        </div>
                                    </td>
                                    <td class="col-2" id="total-price">sum</td>
                                    <td class="col-2">
                                        <form action="my-cart.php" method="POST">
                                            <input type="hidden" name="delete" value="from-cart">
                                            <input type="hidden" name="product_id" value="' . $product['id'] . '">
                                            <button class="btn btn-close"></button>
                                        </form>
                                    </td>
                                </tr>
                            ';
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>

        <!-- Subtotals and proceds -->
        <div class="col-sm-3 " style="max-height:40vh;">
            <div class="col-12 bg-light p-3 mt-3">
                <div>
                    <h2>Cart Summary</h2>
                </div>
                <hr>
                <div class="d-flex my-2 col-12">
                    <h3>Total product :</h3>
                    <h2 id="total-product">1000</h2>
                </div>
                <div class="d-flex my-2 col-12">
                    <h3 class="col-4">Subtotal :</h3>
                    <h2 class="col-8" id="subtotal">₹1000</h2>
                </div>
                <div class="col-12 my-2">
                    <button class="btn btn-warning w-100">Proceed to buy</button>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <?php require "../components/footer.php"; ?>
    </footer>
    
    <script>
        document.querySelectorAll("td.d-flex").forEach((td) => {
            const inputField = td.querySelector("input[type='number']");
            const plusbtn = td.querySelector("#btn-plus");
            const minusbtn = td.querySelector("#btn-minus");
            const row = td.closest("tr");

            plusbtn.addEventListener("click", () => {
                const currentvalue = parseInt(inputField.value);
                const maxvalue = parseInt(inputField.max);

                if (currentvalue < maxvalue) {
                    inputField.value = currentvalue + 1;
                }

                updateRowTotal(row);
                updateCartTotals();
            });

            minusbtn.addEventListener("click", () => {
                const currentValue = parseInt(inputField.value);
                const minValue = parseInt(inputField.min);

                if (currentValue > minValue) {
                    inputField.value = currentValue - 1;
                }

                updateRowTotal(row);
                updateCartTotals();
            });

            // Initialize totals for each row
            updateRowTotal(row);
        });

        // Function to update the total price for each product row
        function updateRowTotal(row) {
            const priceElement = row.querySelector("#price");
            const quantityElement = row.querySelector("input[type='number']");
            const totalPriceElement = row.querySelector("#total-price");

            const price = parseFloat(priceElement.textContent);
            const quantity = parseInt(quantityElement.value);

            const totalPrice = price * quantity;
            totalPriceElement.textContent = `₹${totalPrice.toFixed(2)}`;
        }

        // Function to update overall cart totals
        function updateCartTotals() {
            const rows = document.querySelectorAll("table tr");
            let totalProducts = 0;
            let subtotal = 0;

            rows.forEach((row) => {
                const quantityElement = row.querySelector("input[type='number']");
                const totalPriceElement = row.querySelector("#total-price");

                if (quantityElement && totalPriceElement) {
                    const quantity = parseInt(quantityElement.value);
                    const totalPrice = parseFloat(totalPriceElement.textContent.replace("₹", ""));

                    totalProducts += quantity;
                    subtotal += totalPrice;
                }
            });

            document.getElementById("total-product").textContent = totalProducts;
            document.getElementById("subtotal").textContent = `₹${subtotal.toFixed(2)}`;
        }

        // Initialize cart totals on page load
        updateCartTotals();
    </script>
</body>

</html>