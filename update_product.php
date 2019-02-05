<?php
require_once('database.php');

// Get the values
$product_id = filter_input(INPUT_POST, 'product_id');
$product_name = filter_input(INPUT_POST, 'product_name');
$product_description = filter_input(INPUT_POST, 'product_description');
$product_price = filter_input(INPUT_POST, 'product_price');
$product_stock_quantity = filter_input(INPUT_POST, 'product_stock_quantity');

//Update the product in the database
if ($product_name != null && $product_id != null) {
    $update = 'UPDATE products
                SET productName = :product_name
                WHERE productID = :product_id';
    $statement = $db->prepare($update);
    $statement->bindValue(':product_name', $product_name);
    $statement->bindValue(':product_id', $product_id);
    $success = $statement->execute();
    $statement->closeCursor();    
}
if ($product_description != null && $product_id != null) {
    $update = 'UPDATE products
                SET productDescription = :product_description
                WHERE productID = :product_id';
    $statement = $db->prepare($update);
    $statement->bindValue(':product_description', $product_description);
    $statement->bindValue(':product_id', $product_id);
    $success = $statement->execute();
    $statement->closeCursor();    
}
if ($product_price != null && $product_id != null) {
    $update = 'UPDATE products
                SET productPrice = :product_price
                WHERE productID = :product_id';
    $statement = $db->prepare($update);
    $statement->bindValue(':product_price', $product_price);
    $statement->bindValue(':product_id', $product_id);
    $success = $statement->execute();
    $statement->closeCursor();    
}
if ($product_stock_quantity != null && $product_id != null) {
    $update = 'UPDATE products
                SET productStockQuantity = :product_stock_quantity
                WHERE productID = :product_id';
    $statement = $db->prepare($update);
    $statement->bindValue(':product_stock_quantity', $product_stock_quantity);
    $statement->bindValue(':product_id', $product_id);
    $success = $statement->execute();
    $statement->closeCursor();    
}

// Display the admin's Product List page
include('admin.php');

?>