<?php
require_once('database.php');

if(!isset($_SESSION)) 
{ 
    session_start(); 
}

//Get customerID
$customer_id = filter_input(INPUT_POST, 'customer_id');
//Obtain the order history using the customerID
if(isset($customer_id)){
    $queryOrderHistory = 'SELECT * FROM orders 
                            WHERE customerID = :customerID 
                            ORDER BY orderID';
    $statement5 = $db->prepare($queryOrderHistory);
    $statement5->bindValue(':customerID', $customer_id);
    $statement5->execute();
    $orders = $statement5->fetchAll();
    $statement5->closeCursor();

}
else {
    $queryOrderHistory = 'SELECT * FROM orders ORDER BY orderID';
    $statement = $db->prepare($queryOrderHistory);
    $statement->execute();
    $orders = $statement->fetchAll();
    $statement->closeCursor();

}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>My Online Store</title>
        <link rel="stylesheet" type="text/css" href="main.css" />
    </head> 

    <body>
        <header><h1>My Online Store</h1></header>
        <main>
            <h1 align="center">Order History</h1>
            <!--Search Order History-->
            <form align="center" action="admin_order_history.php" method="post">
                <input type="number" name="customer_id" placeholder="Customer ID">
                <input type="submit" value="Search Order">
            </form>
            <p></p>
            <aside>
                <nav>
                    <ul>
                        <hr>
                        <li><a href="admin_search_form.php">Search</a></li>
                        <li><a href="add_product_form.php">Add Product</a></li>
                        <li><a href="categories_list.php">Add Category</a></li>
                        <li><a href="cart_view.php">Cart</a></li>
                        <li><a href="admin_order_history.php">Order History</a></li>
                        <li><a href="customers.php">Customers</a></li>
                        <hr>
                        <li><a href="admin.php">Admin Home</a></li>
                    </ul>
                </nav>          
            </aside>
            <table border="1">
                <tr>
                    <th align="center">Order ID</th>
                    <th align="center">Customer ID</th>
                    <th align="center">Product ID</th>
                    <th align="center">Product Name</th>
                    <th align="center">Quantity</th>
                    <th align="center">Price</th>
                    <th align="center">Update</th>
                    <th align="center">Delete</th>
                </tr>
                
                <?php 
                    if (!(empty($orders) || count($orders) == 0))
                    foreach ($orders as $orderRow) : ?>
                    <tr>
                        <td align="center"><?php echo $orderRow['orderID']; ?></td>
                        <td align="center"><?php echo $orderRow['customerID']; ?></td>
                        <td align="center"><?php echo $orderRow['productID']; ?></td>

                        <?php
                            $queryProductName = 'SELECT productName FROM products
                                        WHERE productID = :productID';
                            $statement6 = $db->prepare($queryProductName);
                            $statement6->bindValue(':productID', $orderRow['productID']);
                            $statement6->execute();
                            $productNameArray = $statement6->fetch();
                            $statement6->closeCursor();
                        ?>
                        <td align="center"><?php echo $productNameArray['productName'] ?></td>

                        <td align="center"><?php echo $orderRow['orderQuantity']; ?></td>
                        <td align="center"><?php echo "$".$orderRow['orderPrice']; ?></td>
                        <td>
                            <form action="update_order.php" method="post">
                                <input type="number" name="order_quantity" placeholder="Quantity">
                                <input type="hidden" name="order_id"
                                    value="<?php echo $orderRow['orderID']; ?>">
                                <input type="submit" value="Update">
                            </form>
                            <form action="update_order.php" method="post">
                                <input type="number" name="order_price" placeholder="Price">
                                <input type="hidden" name="order_id"
                                    value="<?php echo $orderRow['orderID']; ?>">
                                <input type="submit" value="Update">
                            </form>
                        </td>
                        <!--delete the Order-->
                        <td>
                            <form action="delete_order.php" method="post">
                                <input type="hidden" name="order_id"
                                    value="<?php echo $orderRow['orderID']; ?>">
                                <input type="submit" value="Delete">
                            </form>
                        </td>

                    </tr>
                <?php endforeach; ?>                
            </table>
            <br>
        </main>
        <footer>
            <p>&copy; <?php echo date("Y"); ?> Henry Wang</p>
        </footer>
    </body>
</html>