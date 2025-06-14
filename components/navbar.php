<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Header</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<style>
  .my-mart {
    background-image: linear-gradient(217deg, rgba(255, 0, 0, .8), rgba(255, 0, 0, 0) 70.71%),
      linear-gradient(127deg, rgba(0, 255, 0, .9), rgba(0, 255, 0, 0) 70.71%),
      linear-gradient(336deg, rgba(0, 0, 255, .8), rgba(0, 0, 255, 0) 70.71%);
    border-radius: 1.5rem 0.5rem;
  }

  .bg-nav {
    background-color: #cecef6;
  }

  .btn-orange {
    background-color: rgba(237, 162, 22, 0.893);
  }
</style>

<body>
  <nav class="navbar navbar-expand-lg bg-nav position-sticky top-0 left-0 z-2 w-100 ">
    <div class="container-fluid">
      <a class="navbar-brand my-mart px-3 fw-bolder text-black" href="#">My-mart</a>
      <button class="navbar-toggler bg-info" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse row w-100 d-sm-flex justify-content-evenly" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 col-sm-12 d-sm-flex justify-content-between gap-2">
          <div class="d-sm-flex gap-2">
            <li class="nav-item ms-2 ms-sm-0"><a class="nav-link active fw-bolder" href="home.php"><i class="fa-solid fa-house"></i> Home</a></li>
            <li class="nav-item ms-2 ms-sm-0"><a class="nav-link fw-bolder" href="product.php"><i class="fa-solid fa-box"></i> Products</a></li>
          </div>
          <form class="d-none d-sm-flex col-sm-5 mx- justify-content-sm-evenly" role="search">
            <div class="d-flex col-sm-12">
              <input class="form-control border-white border border-2 rounded-0" type="search" placeholder="Search">
              <button class="btn  btn-orange rounded-0" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
          </form>
          <div class="d-sm-flex gap-2">
            <li class="nav-item dropdown fw-bold ms-2 ms-sm-0">
              <a class="nav-link dropdown-toggle fw-bolder" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-circle-user"></i> Account</a>
              <?php if (!empty($_SESSION["UserID"])): ?>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="account.php">My Account</a></li>
                  <li><a class="dropdown-item" href="purchase-history.php">Purchase History</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="wishlist.php">My Wishlist</a></li>
                  <li><a class="dropdown-item" href="my-cart.php">My cart</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
              <?php elseif (!empty($_SESSION["AdminID"])): ?>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="sign-in.php">My Profile</a></li>
                  <li><a class="dropdown-item" href="">Admin Dashboard</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
              <?php else: ?>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="sign-up.php">Sign up</a></li>
                  <li><a class="dropdown-item" href="sign-in.php">Sign in</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="admin_login.php">Admin Login</a></li>
                </ul>
              <?php endif; ?>
            </li>
            <li class="nav-item ms-2 ms-sm-0"><a class="nav-link fw-bolder" href="my-cart.php"><i class="fa-solid fa-cart-shopping"></i> Cart</a></li>
          </div>
        </ul>
      </div>
    </div>
  </nav>
</body>

</html>