<?php
// Get the student data
$categoryID = filter_input(INPUT_POST, 'category_id');
$productName = filter_input(INPUT_POST, 'product_name');
$productDescription = filter_input(INPUT_POST, 'product_description');
$productPrice = filter_input(INPUT_POST, 'product_price', FILTER_VALIDATE_INT);
$productStockQuantity = filter_input(INPUT_POST, 'product_stock_quantity', FILTER_VALIDATE_INT);

// Validate inputs
if ($categoryID == null ||
        $productName == null || 
        $productDescription == null ||
        $productPrice == null || $productPrice == false ||
        $productStockQuantity == null || $productStockQuantity == false) {
    $error = "Invalid student data. Check all fields and try again.";
    include('error.php');
} else {
    require_once('database.php');

    // Add the student to the database  
    $query = 'INSERT INTO products
                 (productCategory, productName, productDescription, productPrice, productStockQuantity)
              VALUES
                 (:categoryID, :productName, :productDescription, :productPrice, :productStockQuantity)';
    $statement = $db->prepare($query);
    $statement->bindValue(':categoryID', $categoryID);
    $statement->bindValue(':productName', $productName);
    $statement->bindValue(':productDescription', $productDescription);
    $statement->bindValue(':productPrice', $productPrice);
    $statement->bindValue(':productStockQuantity', $productStockQuantity);
    $statement->execute();
    $statement->closeCursor();

    // Display the Product List page
    $category_id = $categoryID;
    include('index.php');
}
?>