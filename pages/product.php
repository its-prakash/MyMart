<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./stylesheet/style.css">
</head>

<body>
    <?php
    require "../components/navbar.php";
    require "../database/database.php";
    $product = $conn->query("SELECT * FROM products");
    ?>
    <div class="row w-100">
        <form action="./product.php" method="GET" class="d-flex justify-content-evenly py-2" style="background-color: #6823d8cd;">
            <button class="btn border-danger bg-white text-black rounded-3 px-sm-5 px-3" name="Category" value="All">All</button>
            <button class="btn border-danger bg-white text-black rounded-3 px-sm-5 px-3" name="Category" value="Electronics">Electronics</button>
            <button class="btn border-danger bg-white text-black rounded-3 px-sm-5 px-3" name="Category" value="Toy">Toys</button>
            <button class="btn border-danger bg-white text-black rounded-3 px-sm-5 px-3" name="Category" value="Fashion">Fashion</button>
        </form>
    </div>
    <div class=" d-flex justify-content-evenly  my-3 flex-wrap gap-3">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            while ($data = $product->fetch_assoc()) {
                if (isset($_REQUEST["Category"])) {
                    if ($_REQUEST["Category"] == $data["categories"]) {
                        echo '
                        <div class="card col-md-2 col-sm-3 col-5 ">
                            <form action="./wishlist.php" method="POST">
                                <input type="hidden" name="My-wishlist" value="addtowishlist">
                                <input type="hidden" name="product_id" value="'.$data['id'].'">
                                <button type="submit" class="text-white position-absolute bg-transparent fs-2 mx-2 border border-0" >&#x2665</button>
                            </form>
                            <a href="single_product.php?id=' . $data["id"] . '"><img src=' . $data["imgsrc"] . ' class="card-img-top " alt="..."></a>
                            <div class="card-body">
                                <p class="card-text">' . $data["categories"] . '</p>
                                <h5 class="card-title">' . $data["title"] . '</h5>
                                <div class="col-12 d-flex">
                                    <span class="col-6">' . $data["price"] . '</span>
                                    <span class="col-6 text-end">
                                        <i class="fa-solid fa-star text-warning fs-6"></i>
                                        <i class="fa-solid fa-star text-warning fs-6"></i>
                                        <i class="fa-solid fa-star text-warning fs-6"></i>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-center my-2">
                                    <form action="./my-cart.php" method="POST">
                                        <input type="hidden" name="My-cart" value="addtocart">
                                        <input type="hidden" name="product_id" value="'.$data['id'].'">
                                        <button type="submit" class="btn border-success bg-transparent px-4 rounded-3">Add to cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        ';
                    } else if ($_REQUEST["Category"] == 'All') {
                        echo '
                        <div class="card col-md-2 col-sm-3 col-5 ">
                            <form action="./wishlist.php" method="POST">
                                <input type="hidden" name="My-wishlist" value="addtowishlist">
                                <input type="hidden" name="product_id" value="'.$data['id'].'">
                                <button type="submit" class="text-white position-absolute bg-transparent fs-2 mx-2 border border-0" >&#x2665</button>
                            </form>
                            <a href="single_product.php?id=' . $data["id"] . '"><img src=' . $data["imgsrc"] . ' class="card-img-top " alt="..."></a>
                            <div class="card-body">
                                <p class="card-text">' . $data["categories"] . '</p>
                                <h5 class="card-title">' . $data["title"] . '</h5>
                                <div class="col-12 d-flex">
                                    <span class="col-6">' . $data["price"] . '</span>
                                    <span class="col-6 text-end">
                                        <i class="fa-solid fa-star text-warning fs-6"></i>
                                        <i class="fa-solid fa-star text-warning fs-6"></i>
                                        <i class="fa-solid fa-star text-warning fs-6"></i>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-center my-2">
                                    <form action="./my-cart.php" method="POST">
                                        <input type="hidden" name="My-cart" value="addtocart">
                                        <input type="hidden" name="product_id" value="'.$data['id'].'">
                                        <button type="submit" class="btn border-success bg-transparent px-4 rounded-3">Add to cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        ';
                    }
                } else {
                    echo '
                        <div class="card col-md-2 col-sm-3 col-5 ">
                           <form action="./wishlist.php" method="POST">
                                <input type="hidden" name="My-wishlist" value="addtowishlist">
                                <input type="hidden" name="product_id" value="'.$data['id'].'">
                                <button type="submit" class="text-white position-absolute bg-transparent fs-2 mx-2 border border-0" >&#x2665</button>
                            </form>
                            <a href="single_product.php?id=' . $data["id"] . '"><img src=' . $data["imgsrc"] . ' class="card-img-top " alt="..."></a>
                            <div class="card-body">
                                <p class="card-text">' . $data["categories"] . '</p>
                                <h5 class="card-title">' . $data["title"] . '</h5>
                                <div class="col-12 d-flex">
                                    <span class="col-6">' . $data["price"] . '</span>
                                    <span class="col-6 text-end">
                                        <i class="fa-solid fa-star text-warning fs-6"></i>
                                        <i class="fa-solid fa-star text-warning fs-6"></i>
                                        <i class="fa-solid fa-star text-warning fs-6"></i>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-center my-2">
                                <form action="./my-cart.php" method="POST">
                                    <input type="hidden" name="My-cart" value="addtocart">
                                    <input type="hidden" name="product_id" value="'.$data['id'].'">
                                    <button type="submit" class="btn border-success bg-transparent px-4 rounded-3">Add to cart</button>
                                </form>
                                </div>
                            </div>
                        </div>
                    ';
                }
            }
        }
        ?>
    </div>
    <footer>
        <?php require "../components/footer.php"; ?>
    </footer>
</body>

</html>