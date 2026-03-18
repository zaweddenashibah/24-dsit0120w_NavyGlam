<?php
include('includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    // Handle Image Upload if a new one was selected
    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . $_FILES['image']['name'];
        $target = "images/" . $image_name;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image_sql = ", image_path = '$target'";
        }
    } else {
        $image_sql = ""; // Keep the old image
    }

    $update_query = "UPDATE products SET 
                     name = '$name', 
                     price = '$price', 
                     category = '$category' 
                     $image_sql 
                     WHERE id = '$id'";

    if (mysqli_query($conn, $update_query)) {
        header("Location: admin.php?msg=updated");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>