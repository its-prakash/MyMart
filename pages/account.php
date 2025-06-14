<?php
session_start();
$userid = $_SESSION["UserID"];

require "../database/database.php";

$fetch_userinfo = $conn->prepare("SELECT * FROM `user-details` WHERE id = ?");
$fetch_userinfo->bind_param("s", $userid);
$fetch_userinfo->execute();
$userinfo = $fetch_userinfo->get_result()->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_REQUEST["delete"]) {
        $deletepassword = $_POST["delete_password"];

        if (password_verify($deletepassword, $userinfo["password"])) {

            $delete_userdetails = $conn->prepare("DELETE FROM `user-details` WHERE id = ?");
            $delete_userdetails->bind_param("s", $userid);
            $delete_userdetails->execute();
            $delete_usercart = $conn->prepare("DELETE FROM `my-cart` WHERE user_id = ?");
            $delete_usercart->bind_param("s", $userid);
            $delete_usercart->execute();
            $delete_userwishlist = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
            $delete_userwishlist->bind_param("s", $userid);
            $delete_userwishlist->execute();

            header("Location:logout.php");
        } else {
            echo '
            <div class="alert alert-info alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x top-0 start-50 z-3" role="alert">
                <strong>Wrong password! </strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        }
    }

    if ($_REQUEST["update"]) {
        $newlocation = $_POST["location"];

        $new_location = $conn->prepare("UPDATE `user-details` SET address = ? WHERE id = ?;");
        $new_location->bind_param("ss", $newlocation, $userid);

        if ($new_location->execute()) {
            echo '
            <div class="alert alert-successfully alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x top-0 start-50 z-3" role="alert">
                <strong>Update location successfully! </strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
            header("Location:account.php");
        } else {
            echo '
            <div class="alert alert-danger alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x top-0 start-50 z-3" role="alert">
                <strong>Maybe somthing error </strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        }
    }

    if ($_REQUEST["change"]) {
        $new_name = $_POST["name"];
        $new_username = $_POST["username"];
        $new_email = $_POST["email"];
        $new_contact = $_POST["phone"];

        $change_details = $conn->prepare("UPDATE `user-details` SET fullname = ?, username = ?, email = ?, contectnumber = ? WHERE id = ?;");
        $change_details->bind_param("sssss", $new_name, $new_username, $new_email, $new_contact, $userid);

        if ($change_details->execute()) {
            header("Location:account.php");
        } else {
            echo '
            <div class="alert alert-danger alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x top-0 start-50 z-3" role="alert">
                <strong>Maybe somthing error </strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        }
    }

    if ($_REQUEST["change_pass"]) {
        $old_pass = $_POST["old_password"];
        $new_pass = $_POST["new_password"];

        if (password_verify($old_pass, $userinfo["password"])) {
            $hashed_new_pass = password_hash($new_pass, PASSWORD_DEFAULT);

            $update_password = $conn->prepare("UPDATE `user-details` SET password = ? WHERE id = ?;");
            $update_password->bind_param("ss", $hashed_new_pass, $userid);

            if ($update_password->execute()) {
                echo '
                <div class="alert alert-success alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x z-3" role="alert">
                    <strong>Password updated successfully!</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
                header("Location:account.php");
            } else {
                echo '
                <div class="alert alert-danger alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x z-3" role="alert">
                    <strong>Failed to update password. Please try again later.</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
            }
        } else {
            echo '
            <div class="alert alert-danger alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x z-3" role="alert">
                <strong>Old password is incorrect.</strong>
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
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./stylesheet/style.css">
</head>

<body>
    <?php require "../components/navbar.php"; ?>
    <h1 class="text-white px-sm-5 px-2 py-4 py-sm-2">Welcome <?php echo $userinfo["username"] ?></h1>

    <!--Tab Structure  -->
    <div class="row m-0 justify-content-evenly p-2">
        <div class="col-sm-10 bg-light rounded p-3">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active tabbtn text-black" id="account-tab" data-bs-toggle="tab" data-bs-target="#my-account" type="button"
                        role="tab" aria-controls="home" aria-selected="true">
                        <i class="fa-solid fa-user"></i> <span>Account</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link tabbtn text-black" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit-account" type="button"
                        role="tab" aria-controls="contact" aria-selected="false">
                        <i class="fa-solid fa-user-edit"></i> <span>Edit Profile</span>
                    </button>
                </li>
            </ul>

            <div class="tab-content">

                <!--my account -->
                <div class="tab-pane fade show active p-2" id="my-account" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row justify-content-evenly m-0">

                        <div class="col-12 bg-light overflow-y-scroll rounded" style="height: 67vh;">
                            <h3 class="my-3">My Details</h3>
                            <div class="">
                                <?php
                                echo '
                                    <div class="col-10 px-3 mx-5 py-1 my-2">
                                        <h4 class="text-warning fw-bolder">Personal Information</h4>
                                        <div><b class="fs-4">Name :</b><span class="fs-5">' . $userinfo["fullname"] . '</span></div>
                                        <div><b class="fs-4">Email :</b><span class="fs-5">' . $userinfo["email"] . '</span></div>
                                        <div><b class="fs-4">Contact :</b><span class="fs-5">' . $userinfo["contectnumber"] . '</span></div>
                                        <div><b class="fs-4">Address :</b><span class="fs-5">' . $userinfo["address"] . '</span></div>
                                        <div><b class="fs-4">Account creation time :</b><span class="fs-5">' . $userinfo["create_time"] . '</span></div>
                                    </div>
                                ';
                                ?>

                                <div class="col-12  p-3  d-flex flex-wrap gap-3 justify-content-evenly">
                                    <div id="boxes" class="col-5 col-md-4 col-lg-3 p-2 rounded  bg-warning">
                                        <button class="col-12 bg-transparent border-0 text-center fs-4 fw-bold" data-bs-toggle="modal" data-bs-target="#delete-account"><i class="col-12 fs-1 fa-solid fa-trash"></i>Account Delete</button>
                                    </div>
                                    <div id="boxes" class="col-5 col-md-4 col-lg-3 p-2 rounded  bg-warning"><a class="text-decoration-none text-black" href="">
                                            <h4 class="text-center fs-4 fw-bold"><i class="col-12 fs-1 fa-solid fa fa-user"></i>Edit Profile</h4>
                                        </a>
                                    </div>
                                    <div id="boxes" class="col-5 col-md-4 col-lg-3 p-2 rounded  bg-warning">
                                        <button class="col-12 bg-transparent border-0 text-center fs-4 fw-bold" data-bs-toggle="modal" data-bs-target="#update-location">
                                            <i class="col-12 fs-1 fa-solid fa-location-dot"></i>Update Location
                                        </button>
                                    </div>
                                    <div id="boxes" class="col-5 col-md-4 col-lg-3 p-2 rounded  bg-warning"><a class="text-decoration-none text-black" href="./wishlist.php">
                                            <h3 class="text-center fs-4 fw-bold"><i class="col-12 fs-1 fa-solid fa-heart"></i>My wishlist</h3>
                                        </a>
                                    </div>
                                    <div id="boxes" class="col-5 col-md-4 col-lg-3 p-2 rounded  bg-warning"><a class="text-decoration-none text-black" href="./my-cart.php">
                                            <h3 class="text-center fs-4 fw-bold"><i class="col-12 fs-1 fa-solid fa-cart-shopping"></i>My cart</h3>
                                        </a>
                                    </div>
                                    <div id="boxes" class="col-5 col-md-4 col-lg-3 p-2 rounded  bg-warning"><a class="text-decoration-none text-black" href="./upload_product.php">
                                            <h3 class="text-center fs-4 fw-bold"><i class="col-12 fs-1 fa-solid fa-upload"></i>Uplod my product</h3>
                                        </a>
                                    </div>
                                    <div id="boxes" class="col-5 col-md-4 col-lg-3 p-2 rounded  bg-warning"><a class="text-decoration-none text-black" href="">
                                            <h3 class="text-center fs-4 fw-bold"><i class="col-12 fs-1 fa-solid fa-box"></i>My order</h3>
                                        </a>
                                    </div>
                                    <div id="boxes" class="col-5 col-md-4 col-lg-3 p-2 rounded  bg-warning"><a class="text-decoration-none text-black" href="">
                                            <h4 class="text-center fs-4 fw-bold"><i class="col-12 fs-1 fa-solid fa-credit-card"></i>Payment</h4>
                                        </a>
                                    </div>
                                    <div id="boxes" class="col-5 col-md-4 col-lg-3 p-2 rounded  bg-warning"><a class="text-decoration-none text-black" href="">
                                            <h4 class="text-center fs-4 fw-bold"><i class="col-12 fs-1 fa-solid fa-circle-info"></i>Support</h4>
                                        </a>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit profile -->
                <div class="tab-pane fade show overflow-y-scroll" id="edit-account" style="height: 67vh;  background-color: #fcfbfc">
                    <div class="tab-pane fade show active px-5 py-2" id="upload" role="tabpanel" aria-labelledby="home-tab">
                        <h2>Edit your personal details</h2>
                        <hr>
                        <div class="row m-0 bg-warning rounded rounded-3 justify-content-evenly p-3  ">
                            <form action="./account.php" class="form col-sm-6" method="POST">
                                <div class="mb-3">
                                    <label class="col-12 rounded p-2 fw-bolder text-black" for="name">Fullname</label>
                                    <input class="col-12 rounded p-2 fw-bolder text-black" type="text" name="name" value="<?php echo $userinfo["fullname"] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="col-12 rounded p-2 fw-bolder text-black" for="username">Username</label>
                                    <input class="col-12 rounded p-2 fw-bolder text-black" type="text" name="username" value="<?php echo $userinfo["username"] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="col-12 rounded p-2 fw-bolder text-black" for="email">Email</label>
                                    <input class="col-12 rounded p-2 fw-bolder text-black rounded p-2" type="email" name="email" value="<?php echo $userinfo["email"] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="col-12 rounded p-2 fw-bolder text-black" for="contact">Contact</label>
                                    <input class="col-12 rounded p-2 fw-bolder text-black" type="tel" name="phone" value="<?php echo $userinfo["contectnumber"] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <input type="submit" value="confirm" name="change" id="" class="p-2 col-12 fw-bolder btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade show active px-5 py-2" id="upload" role="tabpanel" aria-labelledby="home-tab">
                        <h2>Change your Password </h2>
                        <hr>
                        <div class="row m-0 bg-warning rounded rounded-3 justify-content-evenly p-3 ">
                            <form action="./account.php" class="form col-sm-6" method="POST">
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="col-12 rounded p-2 fw-bolder text-black form-label">Enter old password</label>
                                    <input type="password" class=" col-12 rounded p-2 fw-bolder text-black " name="old_password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="col-12 rounded p-2 fw-bolder text-black form-label">Enter new Password</label>
                                    <input type="password" class="col-12 rounded p-2 fw-bolder text-black " name="new_password" required>
                                </div>
                                <div class="mb-3">
                                    <input type="submit" value="confirm" name="change_pass" id="" class="p-2 col-12 fw-bolder btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <!-- Modal for account delete-->
    <div class="modal fade" id="delete-account">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex">
                    <h1 class="text-black fw-bolder">Delete Account</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="fw-bolder text-warning">Delete your account permanently</h3>
                    <p class="fw-bold text-info">By proceeding with this action, your account and all associated data will be permanently deleted. This includes your order history, saved preferences, and any remaining credits or rewards. Once deleted, this action cannot be undone, and we will not be able to recover any of your information.</p>
                    <p class="fw-bolder">If you're sure about this decision, please confirm carefully. </p>
                    <form action="./account.php" method="POST" class="row m-o d-flex justify-content-evenly">
                        <input class="rounded text-black fw-bolder col-8" type="text" name="delete_password" placeholder="Enter your password" id="password" required>
                        <input class="col-3 btn btn-danger fw-bolder" type="submit" name="delete" value="confirm">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Update Location -->
    <div class="modal fade" id="update-location">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex">
                    <h1 class="text-black fw-bolder">Update Location</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="fw-bolder text-info">Chnage your location</h3>
                    <div class="d-flex my-3 fw-bolder text-black">
                        <span>Old Location :</span>
                        <span><?php echo $userinfo["address"] ?></span>
                    </div>
                    <div class="p-3">
                        <h4 class="text-warning">Set new Location </h4>
                        <form action="./account.php" method="POST" class="row m-o d-flex justify-content-evenly">
                            <textarea name="location" id="location" class="mb-3" required></textarea>
                            <input class="btn btn-primary fw-bolder mt-2" type="submit" name="update" value="confirm">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <?php require "../components/footer.php"; ?>
    </footer>

    <script>
        const boxes = document.querySelectorAll('#boxes');

        boxes.forEach((box) => {
            box.addEventListener('mouseover', () => {
                box.style.transform = 'translateY(-10px)';
                box.style.transition = 'transform 0.3s ease';
            });

            box.addEventListener('mouseout', () => {
                box.style.transform = 'translateY(0)';
                box.style.transition = 'transform 0.3s ease';
            });
        });
    </script>

    <script>
        const accountbtn = document.getElementById("account-tab");
        const editbtn = document.getElementById("edit-tab");

        accountbtn.style.backgroundColor = "yellow";

        editbtn.addEventListener("click", () => {
            editbtn.style.backgroundColor = "yellow";
            accountbtn.style.backgroundColor = "transparent";
        })

        accountbtn.addEventListener("click", () => {
            accountbtn.style.backgroundColor = "yellow";
            editbtn.style.backgroundColor = "transparent";
        })
    </script>
</body>

</html>