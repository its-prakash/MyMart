<?php

require "../database/database.php";

$fetchdata = $conn->query("SELECT * FROM `products` WHERE id > 12");
?>


<!DOCTYPE html>
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
  <?php require "../components/navbar.php"; ?>

  <div class="">
    <div id="carouselExampleAutoplaying" class="carousel slide " data-bs-ride="carousel">
      <div class="carousel-inner ">
        <div class="carousel-item active">
          <img src="../assets/carsoule_image/carsole1.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
          <img src="../assets/carsoule_image/carsole2.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
          <img src="../assets/carsoule_image/carsole3.jpg" class="d-block w-100" alt="...">
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>

  <h1 class="bg-warning p-2 text-center">Featured Categories</h1>
  <div class="row d-flex gap-2 px-3 justify-content-evenly m-0 py-2">
    <div class="col-sm-3 text-center text-black rounded rounded-2 p-2" style="background-color: peachpuff;">
      <h2>Electronics</h2>
      <h5>Explore the latest electronics products</h5>
      <form action="./product.php" method="GET">
        <button class="btn btn-primary " name="Category" value="Electronics">View Electronics</button>
      </form>
    </div>
    <div class="col-sm-3 text-center text-black rounded rounded-2 p-2 " style="background-color: peachpuff;">
      <h2>Fashion</h2>
      <h5>Explore the latest fashion products</h5>
      <form action="./product.php" method="GET">
        <button class="btn btn-primary " name="Category" value="Fashion">View Fashion</button>
      </form>
    </div>
    <div class="col-sm-3 text-center text-black rounded rounded-2 p-2 " style="background-color: peachpuff;">
      <h2>Toys</h2>
      <h5>Explore the latest toys products</h5>
      <form action="./product.php" method="GET">
        <button class="btn btn-primary " name="Category" value="Toy">View Toys</button>
      </form>
    </div>
  </div>

  <div class="row d-flex my-3 py-3 flex-wrap  justify-content-evenly bg-light m-0">
    <?php
    while ($data = $fetchdata->fetch_assoc()) {
      if ($data["id"] > 12 && $data["id"] < 31) {
        echo '
        <div class="col-lg-2 col-md-4 col-sm-6 col-6 mb-4">
        <a href="single_product.php?id=' . $data["id"] . '" class="text-decoration-none text-black" >
          <div class="card h-100 shadow-lg  border-0">
            <img src="' . $data['imgsrc'] . '" class="card-img-top" alt="">
            <div class="card-body">
                <h5 class=" card-title">' . $data['title'] . '</h5>
                <p class="card-price">₹ ' . $data['price'] . '</p>
              <h6 class="card-category">' . $data['categories'] . '</h6>
              <div class="col-12">
                <i class="fa-solid fa-star text-warning "></i>
                <i class="fa-solid fa-star text-warning "></i>
                <i class="fa-solid fa-star text-warning "></i>
              </div>
            </div>
          </div>
          </a>
        </div>';
      }
    }
    ?>
  </div>

  <footer>
    <?php require "../components/footer.php"; ?>
  </footer>

</body>

</html>