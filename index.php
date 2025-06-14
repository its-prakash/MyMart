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
  <link rel="stylesheet" href="./pages/stylesheet/style.css">
</head>

<style>
  .top_container {
    height: 100vh;
    /* width: 100vw; */
    background-image: url("assets/background_image/electronics_item1.1.jpg");
    background-size: cover;
    background-repeat: no-repeat;
    align-items: center;
  }

  .brand {
    font-size: 8rem;
    color: lime;
  }

  h2 {
    font-size: 3rem;
  }

  p {
    font-size: 1.2rem;
  }

  .bottom_sub_container {
    background-color: #fffff0;
  }
</style>

<body>

  <div class="top_container d-flex align-items-center">
    <div class="col-sm-1"></div>
    <div class="col-sm-6 px-sm-3 px-2">
      <div class="px-4 rounded rounded-5">
        <h1 class="fw-bolder brand">My Mart</h1>
      </div>
      <h2 class="fw-bolder text-warning">Your Style, Your Way</h2>
      <p class="my-4 fw-bold text-primary">My-Mart is your one-stop online shopping destination for all your daily needs. We offer a wide range of products, including fresh produce, groceries, electronics, fashion, and more. With a user-friendly interface, fast shipping, and competitive prices, My-Mart makes online shopping easy and convenient.</p>
      <a href="./pages/home.php" class="btn btn-danger text-white fw-bolder px-5 rounded-5">Shop Now</a>
    </div>
    <div class="col-sm-5"></div>
  </div>

  <div class="bottom_containerbg-white ">
    <h2 class="text-center bg-warning my-1 fw-bolder">ABOUT US</h2>
    <div class="row m-0 d-flex justify-content-evenly bottom_sub_container">

      <div class="col-sm-9">
        <p class="fs-1 fs-bolder text-success">Why Choose My Mart</p>
        <div class="px-3">
          <p>My-Mart is your ultimate online shopping destination, offering a seamless blend of convenience, affordability, and quality. With a diverse range of products, from electronics and fashion to toys and everyday essentials, we ensure you find everything you need in one place. Our competitive pricing, coupled with exciting deals, makes premium products accessible to everyone. Enjoy fast and reliable delivery services that bring your orders to your doorstep promptly. With secure payment options and a customer-centric approach, we prioritize your satisfaction at every step. At My-Mart, we also embrace eco-friendly practices, ensuring our operations contribute to a sustainable future. Experience the joy of shopping with My-Mart today!</p>
        </div>
      </div>

      <div class="col-sm-9 d-flex flex-column flex-sm-row gap-3 justify-content-evenly py-sm-5 p-3 mb-2" style="background-color: #ffdb58;">
        <div class="py-2 bg-white shadow col-sm-3 d-flex align-items-center justify-content-center gap-2"><i class="fs-1 fw-bolder text-black fa-solid fa-truck"></i><span class="text-black fw-bolder fs-3">Free delivery</span></div>
        <div class="py-2 bg-white shadow col-sm-3 d-flex align-items-center justify-content-center gap-2"><i class="fs-1 fw-bolder text-black fa-solid fa-sack-dollar"></i><span class="text-black fw-bolder fs-3">15 days return</span></div>
        <div class="py-2 bg-white shadow col-sm-3 d-flex align-items-center justify-content-center gap-2"><i class="fs-1 fw-bolder text-black fa-solid fa-credit-card"></i><span class="text-black fw-bolder fs-3">Secure Payment</span></div>
      </div>
    </div>
  </div>

  <footer>
    <?php require "./components/footer.php"; ?>
  </footer>
</body>

</html>