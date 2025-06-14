<?php
session_start();
require "../database/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $row = $conn->prepare("SELECT * FROM `user-details` WHERE email = ?");
    $row->bind_param("s", $email);
    $row->execute();

    $result = $row->get_result();
    $data = $result->fetch_assoc();

    if (password_verify($password, $data["password"])) {
      $_SESSION["logged_in"] = true;
      $_SESSION["UserID"] = $data["id"];
      echo '
        <div class="alert alert-success alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x top-0 start-50 z-3" role="alert">
            <strong>Your data is accepting <br>plese wait!</strong>
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
  <title>Sign in</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="./stylesheet/style.css">
</head>

<body class=" text-white">

  <?php require "../components/navbar.php"; ?>

  <div class="row d-flex justify-content-evenly z-3 px-3 align-items-center w-100" style="height: 80vh;">
    <div class="col-sm-3 my-3 border rounded rounded-4 shadow signin-div ms-2">
      <form action="./sign-in.php" method="POST">
        <div class="d-flex justify-content-center my-5">
          <i class="fa-solid fa-user" style="font-size: 7rem;"></i>
        </div>
        <div class="px-3 my-3">
          <label for="exampleInputEmail1" class="form-label">Email address</label>
          <input type="email" class="form-control bg-transparent border-3 text-light" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" required>
        </div>
        <div class="px-3 my-3">
          <label for="exampleInputPassword1" class="form-label">Password</label>
          <input type="password" class="form-control bg-transparent border-3 text-light " id="exampleInputPassword1" name="password" required>
        </div>
        <div class="px-5 form-check my-3">
          <input type="checkbox" class="form-check-input bg-transparent border-3" id="exampleCheck1">
          <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <div class="px-sm-5 my-3 col-12 d-flex justify-content-center">
          <input type="submit" class="btn btn-primary col-sm-6 fw-bold" value="submit" name="submit">
        </div>
        <div class="text-center my-3">
          <a href="./sign-up.php" class="text-decoration-none text-warning fw-bold">Create New Account</a>
        </div>
      </form>
    </div>
  </div>

</body>

</html>