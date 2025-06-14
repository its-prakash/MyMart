<?php
require "../database/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["submit"])) {
        if ($_POST["password"] == $_POST["confirm_password"]) {

            $name = htmlspecialchars(trim($_POST["name"]));
            $username = htmlspecialchars(trim($_POST['username']));
            $email = htmlspecialchars(trim($_POST["email"]));
            $phone = htmlspecialchars(trim($_POST["phone"]));
            $role = htmlspecialchars(trim($_POST["role"]));

            // echo var_dump($name , $email , $phone , $role);

            $checksql = $conn->prepare("SELECT * FROM `admin-details` WHERE email = ?");
            $checksql->bind_param("s", $email);
            $checksql->execute();

            $result = $checksql->get_result();
            $data = $result->fetch_assoc();

            if ($data) {
                echo '
                    <div class="alert alert-info alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x top-0 start-50 z-3" role="alert">
                        <strong>You are already an admin</strong><br>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    ';
            } else {
                $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

                $sql = $conn->prepare("INSERT INTO `admin-details` (name ,username , email , contact , role , password) VALUES(? ,?, ? , ? , ? , ?)");
                $sql->bind_param("ssssss", $name, $username, $email, $phone, $role, $password);

                if ($sql->execute()) {
                    echo '
                            <div class="alert alert-success alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x top-0 start-50 z-3" role="alert">
                                <strong>Registration Sucessfully !</strong> 
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        ';
                    header("refresh:1 ; url=admin_login.php ");
                } else {
                    echo '
                            <div class="alert alert-danger alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x top-0 start-50 z-3" role="alert">
                                <strong>Registration denied </strong> 
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        ';
                }
                $sql->close();
            }
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
    <title>Admin Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./stylesheet/style.css">
</head>


<body>
    <div class="d-flex flex-column mt-5">
        <div class="row d-flex flex-column justify-content-center align-items-center h-100 p-3">
            <div class="col-sm-6 text-white d-flex bg-light rounded-top-4">
                <div class="col-2 d-flex justify-content-center"><a href="./admin_login.php" class="text-decoration-none text-secondary fs-2">&#8592</a></div>
                <div class="col-8 text-center  fs-3 fw-bold text-black">Admin Registration</div>
                <div class="col-2"></div>
            </div>
            <form action="./admin_register.php" class="col-sm-6 px-5 py-3 bg-light mt-2 rounded-bottom-4" method="POST">
                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Full Name</label>
                    <input type="text" class="form-control border border-info" id="name" name="name" placeholder="Enter your full name" required>
                </div>

                <div class="d-sm-flex justify-content-between ">
                    <!-- username -->
                    <div class="mb-3 col-sm-6 ">
                        <label for="name" class="form-label fw-semibold">UserName</label>
                        <input type="text" class="form-control border border-info" id="username" name="username" placeholder="Enter your Username" required>
                    </div>


                    <!-- Email -->
                    <div class="mb-3 col-sm-5 ">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <input type="email" class="form-control border border-info" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                </div>

                <div class="d-sm-flex justify-content-between">
                    <!-- Phone -->
                    <div class="mb-3 col-sm-6">
                        <label for="phone" class="form-label fw-semibold">Phone Number</label>
                        <input type="tel" class="form-control border border-info" id="phone" name="phone" placeholder="Enter your phone number" required>
                    </div>

                    <!-- Role -->
                    <div class="mb-3 col-sm-5 ">
                        <label for="role" class="form-label fw-semibold">Role</label>
                        <select class="form-select border border-info" id="role" name="role" required>
                            <option value="" selected disabled>Choose a role</option>
                            <option value="super_admin">Super Admin</option>
                            <option value="manager">Manager</option>
                            <option value="editor">Editor</option>
                        </select>
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input type="password" class="form-control border border-info" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="confirm_password" class="form-label fw-semibold">Confirm Password</label>
                    <input type="password" class="form-control border border-info" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                </div>

                <!-- Submit Button -->
                <div class="d-grid">
                    <input type="submit" class="btn btn-primary" value="Register" name="submit"></input>
                </div>
            </form>
        </div>
    </div>
</body>

</html>