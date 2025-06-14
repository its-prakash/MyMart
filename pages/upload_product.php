<?php
session_start();
require "../database/database.php";

if (!isset($_SESSION["UserID"]) || $_SESSION["UserID"] == 0) {
    header("Location: sign-in.php");
    exit;
}

$userid = $_SESSION["UserID"];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $name  = $_POST["Pname"];
    $desc = $_POST["Pdescription"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $category = $_POST["category"];
    $specification = $_POST["Pspecification"];
    $features = $_POST["Pfeatures"];

    // Handle Image Upload
    $imagePath = "../assets/product_image/";
    $imageName = basename($_FILES["image"]["name"]);
    $fullImagePath = $imagePath . $imageName;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $fullImagePath)) {

        $query = $conn->prepare("INSERT INTO `products` 
        (title, description, categories, price, quantity, specification, features, imgsrc, userid) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $query->bind_param("sssssssss", $name, $desc, $category, $price, $stock, $specification, $features, $fullImagePath, $userid);

        if ($query->execute()) {
            echo '
            <div class="alert alert-success alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x top-0 start-50 z-3" role="alert">
                <strong>Product uploaded successfully! </strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        } else {
            echo '<div class="alert alert-danger">Database error: ' . $conn->error . '</div>';
        }

        $query->close();
    } else {
        echo '
            <div class="alert alert-info alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x top-0 start-50 z-3" role="alert">
                <strong>Image upload faild </strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
    }
}
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

    <!-- Tab Structure -->
    <div class="row m-0 justify-content-evenly my-sm-5">
        <div class="col-sm-10 bg-light p-3 rounded">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active tabbtn text-black" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload" type="button"
                        role="tab" aria-controls="home" aria-selected="true">
                        <i class="fa-solid fa-upload"></i> <span>Upload</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link tabbtn text-black" id="view-tab" data-bs-toggle="tab" data-bs-target="#view" type="button"
                        role="tab" aria-controls="contact" aria-selected="false">
                        <i class="fa-solid fa-eye"></i> <span>View</span>
                    </button>
                </li>
            </ul>

            <div class="tab-content">
                <!-- Upload  -->
                <div class="tab-pane fade show active p-2" id="upload" role="tabpanel" aria-labelledby="home-tab">
                    <h2>Upload your Products</h2>
                    <hr>
                    <div class="d-flex justify-content-evenly">
                        <form class="col-sm-10 col-12 shadow d-sm-flex" action="./upload_product.php" method="POST" enctype="multipart/form-data">

                            <!-- Enter description -->
                            <div class="col-sm-8 col-12 bg-warning p-3">

                                <div>
                                    <h4>General information</h4>

                                    <div class="my-2 px-sm-3">
                                        <label class="col-12 fw-bold" for="name">Product Name</label>
                                        <input class="col-12 rounded" type="text" name="Pname" id="" placeholder="Enter your product name" required>
                                    </div>
                                    <div class="my-2 px-sm-3">
                                        <label class="col-12 fw-bold" for="description">Product Description</label>
                                        <textarea class="col-12 rounded" type="text" name="Pdescription" id="" placeholder="Enter your product description" required></textarea>
                                    </div>
                                </div>

                                <div>
                                    <h4>Price Stock & Category</h4>

                                    <div class="d-flex flex-column flex-sm-row  justify-content-evenly gap-2">
                                        <div class="col-sm-3">
                                            <label class="col-12 fw-bold" for="">Price</label>
                                            <input type="number" class="col-12 rounded" name="price" placeholder="Enter your price" required>
                                        </div>
                                        <div class="col-sm-3 ">
                                            <label class="col-12 fw-bold" for="">Stock</label>
                                            <input class="col-12 rounded" type="number" name="stock" placeholder="Enter your stock" required>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="col-12 fw-bold" for="">Category</label>
                                            <select name="category" id="" class="col-12 rounded" required>
                                                <option value="Electronics">Electronics</option>
                                                <option value="Fashion">Fashion</option>
                                                <option value="Toy">Toy</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="my-3">
                                    <h4>Detaild information</h4>

                                    <div class="my-2 px-sm-3">
                                        <label class="col-12 fw-bold" for="name">Product Specification</label>
                                        <textarea class="col-12 rounded" type="text" name="Pspecification" id="" placeholder="Enter your product specification" required></textarea>
                                    </div>
                                    <div class="my-2 px-sm-3">
                                        <label class="col-12 fw-bold" for="description">Product Features</label>
                                        <textarea class="col-12 rounded" type="text" name="Pfeatures" id="" placeholder="Enter your product Features" required></textarea>
                                    </div>
                                </div>

                                <div class=" my-2 px-sm-3">
                                    <input type="submit" class="btn btn-primary col-12 fw-bolder" name="submit">
                                </div>

                            </div>

                            <!-- enter Imgae  -->
                            <div class="col-sm-4 col-12 bg-info p-sm-3 my-sm-0 my-3 p-2">
                                <h4>Image</h4>
                                <div class="col-12">
                                    <label for="image">Chose your Image</label>
                                    <input type="file" class="border col-12 rounded" name="image" id="image" value="../assets/product_image/" required>
                                </div>
                                <div class="p-2" id="preview_container">
                                    <img src="" class=" rounded col-12 prev_img" alt="">
                                </div>
                                <hr>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- View products that pload by you -->
                <div class="tab-pane fade p-2" id="view" role="tabpanel" aria-labelledby="contact-tab">
                    <h2>View Products</h2>
                    <hr>
                    <div class="table-responsive overflow-y-scrool" style="max-height: 60vh;">
                        <table class="table align-middle table-bordered border-primary text-wrap">
                            <tr class="text-center table-dark">
                                <th class="col-1">Name</th>
                                <th class="col-1">Price</th>
                                <th class="col-1">Stock</th>
                                <th class="col-1">Category</th>
                                <th class="col-2">Description</th>
                                <th class="col-2">Specification</th>
                                <th class="col-2">Features</th>
                                <th class="col-2">Image</th>
                            </tr>

                            <?php
                            $yourproduct = $conn->prepare("SELECT * FROM `products` WHERE userid = ?");
                            $yourproduct->bind_param("s", $userid);
                            $yourproduct->execute();
                            $data = $yourproduct->get_result();

                            while ($product = $data->fetch_assoc()) {
                                echo '
                                <tr class="text-center">
                                    <td>' . $product["title"] . '</td>
                                    <td>' . $product["price"] . '</td>
                                    <td>' . $product["quantity"] . '</td>
                                    <td>' . $product["categories"] . '</td>
                                    <td>' . $product["description"] . '</td>
                                    <td>' . $product["specification"] . '</td>
                                    <td>' . $product["features"] . '</td>
                                    <td><img src=' . $product["imgsrc"] . ' class="col-12" alt=""></td>
                                </tr>
                                ';
                            }
                            ?>

                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <footer>
        <?php require "../components/footer.php"; ?>
    </footer>

    <!-- Preview -->
    <script>
        const imageInput = document.getElementById('image');
        const previewContainer = document.querySelector('.prev_img');

        imageInput.addEventListener('change', () => {
            const file = imageInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewContainer.src = e.target.result; // Update the preview image
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

    <script>
        const uploadbtn = document.getElementById("upload-tab");
        const viewbtn = document.getElementById("view-tab");

        uploadbtn.style.backgroundColor = "yellow";

        viewbtn.addEventListener("click" , ()=>{
            viewbtn.style.backgroundColor = "yellow";
            uploadbtn.style.backgroundColor = "transparent";
        })

        uploadbtn.addEventListener("click" , ()=> {
            uploadbtn.style.backgroundColor = "yellow";
            viewbtn.style.backgroundColor = "transparent";
        })
    </script>

</body>

</html>