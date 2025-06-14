<?php
session_start();
require "../database/database.php";

if (!isset($_SESSION["UserID"]) || $_SESSION["UserID"] == 0) {
    header("Location: sign-in.php");
    exit;
}

$userid = $_SESSION["UserID"];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add to Wishlist
    if (isset($_REQUEST["My-wishlist"]) && ($_REQUEST["My-wishlist"] == "addtowishlist") && !empty($_REQUEST["product_id"])) {
        $productid = $_REQUEST["product_id"];

        $checksql = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ? AND product_id = ?");
        $checksql->bind_param("ss", $userid, $productid);
        $checksql->execute();
        $data = $checksql->get_result()->fetch_assoc();

        if (!$data) {
            $insertsql = $conn->prepare("INSERT INTO `wishlist` (user_id, product_id) VALUES (?, ?)");
            $insertsql->bind_param("ss", $userid, $productid);
            $insertsql->execute();
            $insertsql->close();
        }
        $checksql->close();
    }

    // Remove from Wishlist
    if (isset($_REQUEST["delete"]) && ($_REQUEST["delete"] == "from-wishlist") && !empty($_REQUEST["product_id"])) {
        $productid = $_REQUEST["product_id"];

        $remove = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ? AND product_id = ?");
        $remove->bind_param("ss", $userid, $productid);
        $remove->execute();
        $remove->close();
    }

    // Redirect to Refresh Data
    header("Location: wishlist.php");
    exit;
}

// Fetch Wishlist Data
$idpresent = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
$idpresent->bind_param("s", $userid);
$idpresent->execute();
$wishlist_rows = $idpresent->get_result();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Single Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./stylesheet/style.css">
</head>

<body>
    <?php require "../components/navbar.php"; ?>

    <div class="row  d-sm-flex m-0 p-4 justify-content-evenly">

        <div class="col-sm-10 p-sm-3 p-1">
            <div class="col-12 bg-light p-3">
                <h2>My Wishlist</h2>
                <hr>
            </div>
            <div class="table-responsive overflow-y-scrool" style="max-height: 70vh;">
                <table class="table table-responsive align-middle table-bordered border-primary">
                    <tr class="table-dark text-center">
                        <th>Product</th>
                        <th>Product name</th>
                        <th>Price</th>
                        <th>Add to cart</th>
                        <th>Remove</th>
                    </tr>

                    <?php
                    while ($wishlist_row = $wishlist_rows->fetch_assoc()) {
                        $product_id = $wishlist_row["product_id"];

                        // Fetch Product Details
                        $display = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                        $display->bind_param("s", $product_id);
                        $display->execute();
                        $product = $display->get_result()->fetch_assoc();

                        if ($product) {
                            echo '
                            <tr align="text-center border border-info border-3">
                                <td class="col-2 text-center"><a href="single_product.php?id=' . $product["id"] . '"><img class="col-sm-8 col-12" src="' . $product["imgsrc"] . '" alt=""></a></td>
                                <td class="col-3 text-center">' . $product["title"] . '</td>
                                <td class="col-2  text-center">' . $product["price"] . '</td>
                                <td class="col-3 text-center">
                                    <form action="./my-cart.php" method="POST">
                                        <input type="hidden" name="My-cart" value="addtocart">
                                        <input type="hidden" name="product_id" value="' . $product['id'] . '">
                                        <button type="submit" class="px-3 btn btn-warning">Add to Cart</button>
                                    </form>
                                </td>
                                <td class="col-2 text-center">
                                    <form action="./wishlist.php" method="POST">
                                        <input type="hidden" name="delete" value="from-wishlist">
                                        <input type="hidden" name="product_id" value="' . $product['id'] . '">
                                        <button class="btn btn-close"></button>
                                    </form>
                                </td>
                            </tr>
                        ';
                        }
                        $display->close();
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>

    <footer>
        <?php require "../components/footer.php"; ?>
    </footer>
</body>

</html>