<?php 
    require_once('database.php');

    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

    $product_id = filter_input(INPUT_POST, "product_id");
    $quantity =  filter_input(INPUT_POST, "quantity");
    $index = filter_input(INPUT_POST, "session_array_index");

    //Query the stock availability
    $queryStock = 'SELECT * FROM products
    WHERE productID = :product_id
    ORDER BY productID';
    $statement = $db->prepare($queryStock);
    $statement->bindValue(':product_id', $product_id);
    $statement->execute();
    $stock = $statement->fetch();
    $statement->closeCursor();

    //The quantity can only be updated if the stock is greater than or equal to
    //the requested quantity
    if($stock['productStockQuantity']>=$quantity){
        $_SESSION['cart'][$index]["quantity"] = $quantity;
    }
    //Display the cart page
    include('cart_view.php');
?>