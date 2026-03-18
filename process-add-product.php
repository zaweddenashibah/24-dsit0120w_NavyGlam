<?php
// 1. Include the database connection
include('includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 2. Collect and sanitize text data - TYPO FIXED HERE
    $name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // 3. Handle the Image Upload
    $target_dir = "images/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = time() . '_' . basename($_FILES["product_image"]["name"]);
    $target_file = $target_dir . $file_name;
    $upload_ok = true;
    $image_path_for_db = "";

    if(!empty($_FILES["product_image"]["tmp_name"])) {
        $check = getimagesize($_FILES["product_image"]["tmp_name"]);
        if($check !== false) {
            if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                $image_path_for_db = $target_file;
            } else {
                echo "Error uploading file.";
                $upload_ok = false;
            }
        } else {
            echo "File is not an image.";
            $upload_ok = false;
        }
    }

    // 4. Insert into Database - UPDATED FOR CONSISTENCY
    if ($upload_ok) {
        $sql = "INSERT INTO products (name, category, price, image_path) 
                VALUES ('$name', '$category', '$price', '$image_path_for_db')";

        if (mysqli_query($conn, $sql)) {
            header("Location: index.php?upload=success");
            exit();
        } else {
            echo "Database Error: " . mysqli_error($conn);
        }
    }
}
?>