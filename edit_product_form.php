<?php // Get the product data

$product_id = $_POST['product_id'];
$category_id = $_POST['category_id'];
$code = $_POST['code'];
$name = $_POST['name'];
$price = $_POST['price'];



require('global/database.php');
$query = 'SELECT *
          FROM categories
          ORDER BY categoryID';
$categories = $db->query($query);



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- the head section -->
<head>
    <title>My Guitar Shop</title>
    <link rel="stylesheet" type="text/css" href="global/main.css" />
</head>

<!-- the body section -->
<body>
    <div id="page">
        <div id="header">
            <h1>Product Manager</h1>
        </div>

        <div id="main">
            <h1>Edit Product</h1>
            <form action="edit_product.php" method="post"
                  id="edit_product_form">

               <input type="hidden" name="product_id" value="<?php echo $product_id['productID'];?>"/>
               <br />

                <label>Category:</label>
                <select name="category_id">
                <?php foreach ($categories as $category) : ?>
                    <option value="<?php echo $category['categoryID']; ?>">
                        <?php echo $category['categoryName']; ?>
                    </option>
                <?php endforeach; ?>
                </select>
                <br />

 <label>Code:</label>
                <input type="input" name="code" value="<?php echo $code ;?>" />
                <br />

                <label>Name:</label>
                <input type="input" name="name" value="<?php echo $name;?>"/>
                <br />

                <label>List Price:</label>
                <input type="input" name="price" value="<?php echo $price;?>" />
                <br />


                <label>&nbsp;</label>
                <input type="submit" value="Save Changes" />
                <br />
            </form>
            <p><a href="index.php">View Product List</a></p>
               

        </div><!-- end main -->

        <div id="footer">
            <p>
                &copy; <?php echo date("Y"); ?> My Guitar Shop, Inc.
            </p>
        </div>

    </div><!-- end page -->
</body>
</html>
