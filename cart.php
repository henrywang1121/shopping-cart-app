<?php
    require_once('database.php');

    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

    $product_id = filter_input(INPUT_POST, "product_id");
    $product_name =  filter_input(INPUT_POST, "product_name");
    $product_price =  filter_input(INPUT_POST, "product_price");
    $quantity =  filter_input(INPUT_POST, "quantity");

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    //Query the stock availability
    $queryStock = 'SELECT * FROM products
                  WHERE productID = :product_id
                  ORDER BY productID';
    $statement = $db->prepare($queryStock);
    $statement->bindValue(':product_id', $product_id);
    $statement->execute();
    $stock = $statement->fetch();
    $statement->closeCursor();

    //An item can be added only if the requested quantity is equal to or less than the total stock
    if($stock['productStockQuantity']>=$quantity){
        //Create an array using the values from POST
        $item = array("id"=>$product_id, "name"=>$product_name, "price"=>$product_price, "quantity"=>$quantity, );
        
        //Push the array into the session variable
        array_push($_SESSION['cart'], $item);

        //Display the cart page
        include('cart_view.php');
    } else {
        include('index.php');
    }
?>

