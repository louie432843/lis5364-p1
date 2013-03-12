<?php
// show errors, comment out when done testing:
ini_set('error_reporting', E_ALL|E_STRICT);
ini_set('display_errors', 1);

  //make sure file is only required once, 
  //fail causes error that stops remainder of page from processing
    require_once('global/database.php');

/*
Using $_Get associative array (superglobal variable), retrieves key/value pair
that is, returns value associated with key: category_id

if it is null (i.e., not set/initialized, or given a value), assign $category_id value of 1
http://2011.ispace.ci.fsu.edu/~mjowett/demos/isset_vs_empty.php

NOTE: 
First try to get the value for category through the form page ($_GET super global variable).
However, when the Web app is first accessed, the user hasn't clicked on any categories
So, $category_id is hard-coded (assigned) a value of 1, the first category (Guitars)
*/

if(!isset($category_id)) 
{
  $category_id = $_GET['category_id'];
  if (!isset($category_id)) 
    {
      $category_id = 1;
    }
 }

/*
NOTES: Methods to use with SQL statements
1) SELECT: use query() method of PDO class, returns PDOStatment object containing result set, or FALSE if no result set

2) INSERT, UPDATE, and DELETE: use exec() method of PDO class, returns number of affected rows,
    or zero (0), if no affected rows
*/

    // Get name for current category
    $query = "SELECT * FROM categories
              WHERE categoryID = $category_id";

//returns PDOStatment object that contains result set, and is assigned to variable $category, if no result set returns false
$category = $db->query($query); 

//fetch() method of PDOStatment class, returns array, that is, next row in result set, or FALSE
$category = $category->fetch(); 

//uses string index (categoryName) to access specific table column/attribute
$category_name = $category['categoryName']; 

//modify value of $query variable to get all categories
    $query = "SELECT * FROM categories
              ORDER BY categoryID";

//same as above, returns result set containing all categories, and is assigned to variable $categories
$categories = $db->query($query); 

//modify value of $query variable to get products for selected category, ordered by productID
    $query = "SELECT * FROM products
              WHERE categoryID = $category_id
              ORDER BY productID";

//same as above, returns result set
$products = $db->query($query); 
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

        <h1>Product List</h1>

        <div id="sidebar">
<!-- display a list of categories and their links //-->
            <h2>Categories</h2>
            <ul class="nav">

<?php
 /*
Generic syntax example: 
foreach ($array_name as $variable_value)

Use foreach loop to loop through associative array $categories.
On each loop, value of current element is assigned to $category.
Uses string key (categoryName) to access specific table column/attribute (i.e., categoryID, categoryName)

The line including "?category_id=..." is specifying a link that is
 appending a query string to where this file currently resides.
(You can view what the link displays by holding the cursor over "Guitars," "Basses," or "Drums" links.)
 */
?>
            <?php foreach ($categories as $category) : ?>
                <li>
                <a href="?category_id=<?php echo $category['categoryID']; ?>">
                    <?php echo $category['categoryName']; ?>
                </a>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>

        <div id="content">
            <!-- display a table of products -->
            <h2><?php echo $category_name; ?></h2>
            <table>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th class="right">Price</th>
                    <th>Remove Product</th>
                    <th>Edit Product</th>
                </tr>

<!-- Include product information here.  //-->
                <?php foreach ($products as $product) : ?>
                <tr>
                    <td><?php echo $product['productCode']; ?></td>
                    <td><?php echo $product['productName']; ?></td>
                    <td class="right"><?php echo $product['listPrice']; ?></td>

<!-- Create form button and hidden input fields to pass product and category info. to delete product.  //-->

                    <td><form action="delete_product.php" method="post" id="delete_product_form">
                        <input type="hidden" name="product_id" value="<?php echo $product['productID']; ?>" />
                        <input type="hidden" name="category_id" value="<?php echo $product['categoryID']; ?>" />
                        <input type="submit" value="Delete" />
                    </form></td>

<!-- Create form button and hidden input fields to pass product and category info. to edit product.  //-->

                    <td><form action="edit_product_form.php" method="post" id="edit_product_form">    
                        <input type="hidden" name="category_id" value="<?php echo $product['categoryID']; ?>" />
                        <input type="hidden" name="product_id" value="<?php echo $product['productID']; ?>" />
                        <input type="hidden" name="code" value="<?php echo $product['productCode']; ?>" />
                        <input type="hidden" name="name" value="<?php echo $product['productName']; ?>" />
                        <input type="hidden" name="price" value="<?php echo $product['listPrice']; ?>" />
                        <input type="submit" value="Edit" />
                    </form></td>

                </tr>
                <?php endforeach; ?>
            </table>
            <p><a href="add_product_form.php">Add Product</a></p>
            <p><a href="category_list.php">List Categories</a></p>
        </div>
    </div>

<div id="footer">
        <p>
            &copy; 
<?php 
  //be sure default time zone is set, otherwise, error!
date_default_timezone_set('America/New_York');

//$today = date("m/d/y g:ia");
//echo $today;

echo date("Y"); 

?> 

My Guitar Shop, Inc.
        </p>
</div>

    </div><!-- end page -->
</body>
</html>
