<?php
require_once('database.php');

// Get IDs
$order_id = filter_input(INPUT_POST, 'order_id');
// Delete the product from the database
if ($order_id != null) {
    $query = 'DELETE FROM orders
              WHERE orderID = :order_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':order_id', $order_id);
    $success = $statement->execute();
    $statement->closeCursor();    
}

// Display the Admin Order History page
include('admin_order_history.php');

?>