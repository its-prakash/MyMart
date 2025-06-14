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

<body style=" z-index: -1;">
  <?php
  require "../components/navbar.php";
  require "../database/database.php";
  $product = $conn->query("SELECT * FROM products WHERE id='$_REQUEST[id]'");
  $data = $product->fetch_assoc();
  ?>

  <div class="row">

    <?php
    echo '
    <div class="col-sm-6 mt-5">
      <div class="col-sm-10 d-flex flex-column align-items-center">
        <img src="' . $data["imgsrc"] . '" class="col-8 p-3 bg-white rounded rounded-3" alt="">
        <div class="col-sm-10 d-flex justify-content-evenly my-3">
          <img src="' . $data["imgsrc"] . '" class="col-3 rounded rounded-4" alt="">
          <img src="' . $data["imgsrc"] . '" class="col-3 rounded rounded-4" alt="">
          <img src="' . $data["imgsrc"] . '" class="col-3 rounded rounded-4" alt="">
        </div>
      </div>
    </div>

    <div class="col-sm-6 mt-sm-5 px-4 px-sm-0">
      <div class="col-sm-8 col-12 bg-dark rounded rounded-4 border border-5 border-danger text-white p-3">
        <p>' . $data["categories"] . '</p>
        <h2>' . $data["title"] . '</h2>
          <form action="./wishlist.php" method="POST">
              <input type="hidden" name="My-wishlist" value="addtowishlist">
              <input type="hidden" name="product_id" value="'.$data['id'].'">
              <button type="submit" class="text-white bg-transparent fs-2 mx-2 border border-0 px-3">&#x2665</button>
          </form>
        <hr>
        <dl style="min-height: 15rem;">
          <dt>Description</dt>
          <dd class="col-sm-8 ">' . $data["description"] . '</dd>
          <ul>
            <li>' . $data["specification"] . '</li>
            <li>' . $data["features"] . '</li>
          </ul>
        </dl>
        <hr>
        <div class="row justify-content-evenly gap-3">
          <button class="px-5 col-sm-5 btn btn-success">Buy Now</button>
          <form action="./my-cart.php" method="POST" class="col-sm-5">
              <input type="hidden" name="My-cart" value="addtocart">
              <input type="hidden" name="product_id" value="'.$data['id'].'">
              <button type="submit" class="px-5  btn btn-warning">Add to Cart</button>
          </form>
        </div>
      </div>
    </div>
    ';
    ?>

  </div>

  <h1 class="mx-5 mt-sm-4 text-white">People also likes</h1>
  <div class="d-flex gap-3 my-2 overflow-x-scroll mx-4 py-3 px-3">
    <?php
    $product_category = $conn->query("SELECT * FROM products WHERE categories='$data[categories]'");
    while ($row = $product_category->fetch_assoc()) {
      if ($row["id"] != $data["id"]) {
        echo '
            <div class="card col-md-2 col-sm-3 col-5 border-0">
              <button class="text-white position-absolute bg-transparent fs-2 mx-2 border border-0">&#x2665</button>
              <a href="single_product.php?id=' . $row["id"] . '"><img src=' . $row["imgsrc"] . ' class="card-img-top " alt="..."></a>
                <div class="card-body ">
                    <h5 class="card-title">' . $row["title"] . '</h5>
                    <div class="col-12 d-flex">
                        <span class="col-6">' . $row["price"] . '</span>
                        <span class="col-6 text-end">
                            <i class="fa-solid fa-star text-warning fs-6"></i>
                            <i class="fa-solid fa-star text-warning fs-6"></i>
                            <i class="fa-solid fa-star text-warning fs-6"></i>
                        </span>
                    </div>
                </div>
            </div>
          ';
      }
    }
    ?>
  </div>
  
  <!-- <script>
      const wishlist = document.querySelector("#wishlistform")
      const icon = document.querySelector("#icon");

      let color = "white";
      icon.addEventListener("click", function(evt){
          evt.preventDefault();
          if(color === "white"){
              color = "blue";
              icon.style.color = "blue";
            } else {
              color = "white";
              icon.style.color = "white";
            }
      });
    </script> -->

</body>

</html>