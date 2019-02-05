<?php
require_once('database.php');

// Get IDs
$product_id = filter_input(INPUT_POST, 'product_id');
$category_id = filter_input(INPUT_POST, 'category_id');

// Delete the product from the database
if ($product_id != null && $category_id != null) {
    $query = 'DELETE FROM products
              WHERE productID = :product_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':product_id', $product_id);
    $success = $statement->execute();
    $statement->closeCursor();    
}

// Display the Product List page
include('admin.php');

?>