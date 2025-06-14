<?php

require "../database/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($_POST["submit"]) {
    if ($_POST["password"] == $_POST["conf-password"]) {
      $name = $_POST["fullname"];
      $username = $_POST["username"];
      $email = $_POST["email"];
      $contact = $_POST["contact"];
      $address = $_POST["address"];

      $stml = $conn->prepare("SELECT * FROM `user-details` WHERE email = ?");
      $stml->bind_param("s", $email);
      $stml->execute();

      $result = $stml->get_result();
      $data = $result->fetch_assoc();

      if ($data) {
        echo '
          <div class="alert alert-info alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x top-0 start-50 z-3" role="alert">
              <strong>Already have Account</strong><br>
              <p>Plese go and sign-in to your account</p>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          ';
      } else {
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $stml = $conn->prepare("INSERT INTO `user-details` (fullname , username , email , password , contectnumber , address) VALUES(?,?,?,?,?,?)");
        $stml->bind_param("ssssss", $name, $username, $email, $password, $contact, $address);

        if ($stml->execute()) {
          echo '
            <div class="alert alert-success alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x top-0 start-50 z-3" role="alert">
                <strong>Registration Sucessfully !</strong> 
                <p>Plese go and sign-in to your account</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        ';
        header("refresh:2 ; url=sign-in.php ");
        } else {
          echo '
            <div class="alert alert-danger alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x top-0 start-50 z-3" role="alert">
                <strong>Registration denied </strong> 
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        ';
        }
      }
      $stml->close();
    } else {
      echo '
        <div class="alert alert-warning alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x top-0 start-50 z-3" role="alert">
            <strong>Plese Enter same Password.</strong> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    ';
    }
  }
  $conn->close();
}
?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign up</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="./stylesheet/style.css">
</head>

<body>
  <?php require "../components/navbar.php"; ?>

  <div class="row d-flex justify-content-evenly my-3 w-100">
    <div class="col-sm-8 z-1 d-flex flex-column flex-sm-row col-12 box-shadow">

      <div class="col-sm-7">
        <img src="../assets/background_image/register-image.jpg" alt="" class="col-12 m-0">
      </div>

      <div class="col-sm-5 col-12 py-2  bg-white">
        <div class="d-flex justify-content-between ">
          <h3 class="col-4 px-3 fw-bold text-warning">Sign Up</h3>
          <a href="./home.php" class="col-1 justify-content-evenly text-white text-decoration-none fs-6 py-1">Back</a>
        </div>
        <hr class="border-4 border-primary opacity-100 m-0">
        <form method="POST" action="./sign-up.php">
          <div class="mt-3 mb-3 px-3">
            <input
              type="text"
              class="form-control border border-primary border-2"
              id="fullname"
              name="fullname"
              placeholder="Enter your full name"
              required>
          </div>
          <div class="mb-3 px-3">
            <input
              type="text"
              class="form-control border border-primary border-2"
              id="username"
              name="username"
              placeholder="Enter your username"
              required>
          </div>
          <div class="mb-3 px-3">
            <input
              type="email"
              class="form-control border border-primary border-2"
              id="exampleInputEmail1"
              aria-describedby="emailHelp"
              name="email"
              placeholder="Enter your email address"
              required>
          </div>
          <div class="mb-3 px-3">
            <input
              type="tel"
              class="form-control border border-primary border-2"
              id="contactno"
              name="contact"
              placeholder="Enter your phone number"
              required>
          </div>
          <div class="mb-3 px-3">
            <input
              type="password"
              class="form-control border border-primary border-2"
              id="exampleInputPassword1"
              name="password"
              placeholder="Enter your password"
              required>
          </div>
          <div class="mb-3 px-3">
            <input
              type="password"
              class="form-control border border-primary border-2"
              id="confirmPassword"
              name="conf-password"
              placeholder="Confirm your password"
              required>
          </div>
          <div class="mb-3 px-3">
            <textarea
              name="address"
              id="address"
              class="form-control border border-primary border-2"
              placeholder="Enter your address"
              required></textarea>
          </div>
          <div class="d-grid px-3">
            <input
              type="submit"
              class="btn btn-primary fw-bold"
              value="Create Your Account"
              name="submit">
          </div>
          <div class="text-center my-2">
            <a href="./sign-in.php" class="text-decoration-none text-primary fw-bold">Already have Account</a>
          </div>
        </form>

      </div>

    </div>
  </div>

</body>

</html>