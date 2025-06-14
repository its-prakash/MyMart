<?php
session_start();
require "../database/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $row = $conn->prepare("SELECT * FROM `admin-details` WHERE email = ?");
    $row->bind_param("s", $email);
    $row->execute();

    $result = $row->get_result();
    $data = $result->fetch_assoc();

    if (password_verify($password, $data["password"])) {
      $_SESSION["adminlogged_in"] = true;
      $_SESSION["AdminID"] = $data["id"];
      echo '
        <div class="alert alert-success alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x top-0 start-50 z-3" role="alert">
            <strong>Your details is matching <br>plese wait!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
      header("refresh:3;url=home.php");
    } else {
      echo '
          <div class="alert alert-danger alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x top-0 start-50 z-3" role="alert">
              <strong>Either email or  Password wrong</strong>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          ';
    }
  }
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./stylesheet/style.css">
</head>

<body style="height: 100vh;">
    <div class="row d-flex flex-column justify-content-center align-items-center h-100 p-3">
        <div class="col-sm-4 text-white d-flex bg-light rounded-top-3">
            <div class="col-2 d-flex justify-content-center"><a href="./home.php" class="text-decoration-none text-secondary fs-2">&#8592</a></div>
            <div class="col-8 text-center  fs-3 fw-bold text-black">Admin Login</div>
            <div class="col-2"></div>
        </div>
        <form action="./admin_login.php" class="col-sm-4 px-5 py-3 bg-light mt-2 rounded-bottom-3" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email Address</label>
                <input type="email" class="form-control border-info" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Password</label>
                <input type="password" class="form-control border-info" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="d-grid mb-3">
                <input type="submit" class="btn btn-warning fw-bold" value="Login" name="submit"></input>
            </div>
            <div class="d-grid">
                <a href="./admin_register.php" class="col-12 text-center text-info fw-bold text-decoration-none">Register as Admin</a>
            </div>
        </form>
    </div>
</body>

</html>