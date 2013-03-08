<?php
// Get the product data
$product_id = $_POST['product_id'];
$category_id = $_POST['category_id'];
$code = $_POST['code'];
$name = $_POST['name'];
$price = $_POST['price'];

// Validate inputs
if (empty($code) || empty($name) || empty($price) ) {
    $error = "Invalid product data. Check all fields and try again.";
    include('error.php');
} else {
    // If valid, edit the product
    require_once('global/database.php');
    $query = "UPDATE products
          SET categoryID = '$category_id',
              productCode = '$code',
              productName = '$name',
              listPrice = '$price'
          WHERE productID = $product_id";
                 
    $db->exec($query);

    // Display the Product List page
    include('index.php');
}
?>
