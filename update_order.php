<?php
require_once('database.php');

// Get the values
$order_id = filter_input(INPUT_POST, 'order_id');
$order_quantity = filter_input(INPUT_POST, 'order_quantity');
$order_price = filter_input(INPUT_POST, 'order_price');

//Update the order in the database
if ($order_quantity != null && $order_id != null) {
    $update = 'UPDATE orders
                SET orderQuantity = :order_quantity
                WHERE orderID = :order_id';
    $statement = $db->prepare($update);
    $statement->bindValue(':order_quantity', $order_quantity);
    $statement->bindValue(':order_id', $order_id);
    $success = $statement->execute();
    $statement->closeCursor();    
}
if ($order_price != null && $order_id != null) {
    $update = 'UPDATE orders
                SET orderPrice = :order_price
                WHERE orderID = :order_id';
    $statement = $db->prepare($update);
    $statement->bindValue(':order_price', $order_price);
    $statement->bindValue(':order_id', $order_id);
    $success = $statement->execute();
    $statement->closeCursor();    
}

// Display the admin's Product List page
include('customers.php');

?>