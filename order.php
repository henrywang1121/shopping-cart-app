<?php
require_once('database.php');

    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

//Get customerID
$customer_id = filter_input(INPUT_POST, 'customer_id');

//Insert the order into the database
if (isset($customer_id)){
    if (!(empty($_SESSION['cart']) || count($_SESSION['cart']) == 0)){
        foreach ($_SESSION['cart'] as $cartRow){
            $insert = 'INSERT INTO orders (customerID, productID, orderQuantity, orderPrice) 
                        VALUES (:customerID, :productID, :orderQuantity, :orderPrice)';
            $statement4 = $db->prepare($insert);
            $statement4->bindValue(':customerID', $customer_id);
            $statement4->bindValue(':productID', $cartRow['id']);
            $statement4->bindValue(':orderQuantity', $cartRow['quantity']);
            $statement4->bindValue(':orderPrice', ($cartRow['price']*$cartRow['quantity']));
            $statement4->execute();
            $statement4->closeCursor();

            //Query the remaining stock of the specified product
            $queryProduct = 'SELECT * FROM products
                                    WHERE productID = :product_ID';
            $statement8 = $db->prepare($queryProduct);
            $statement8->bindValue(':product_ID', $cartRow['id']);
            $statement8->execute();
            $productArray = $statement8->fetch();
            $statement8->closeCursor();

            //Update the stock availability
            $update = 'UPDATE products 
                        SET productStockQuantity = :productStockQuantity
                        WHERE productID = :productID';
            $statement7 = $db->prepare($update);
            $statement7->bindValue(':productStockQuantity', ($productArray['productStockQuantity']-$cartRow['quantity']));
            $statement7->bindValue(':productID', $cartRow['id']);
            $statement7->execute();
            $statement7->closeCursor();
        }

        //Emppty the cart items after the order is placed
        unset($_SESSION['cart']);
        //Go to order history
        header("Location: ./order_history.php"); /* Redirect browser */
        //exit();
        //include('order_history.php');
    }
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
            <h1 align="center">Place Order</h1>
           <aside>
                <nav>
                    <ul>
                        <hr>
                        <li><a href="search_form.php">Search</a></li>
                        <li><a href="order_history.php">Order History</a></li>
                        <li><a href="cart_view.php">Cart</a></li>
                        <li><a href="index.php">Add More Items</a></li>
                        <li><a href=".?action=empty_cart">Empty Cart</a></li>
                        <li><a href="order.php">Place Order</a></li>
                        <hr>
                        <li><a href="index.php">Customer Home</a></li>
                    </ul>
                </nav>          
            </aside>

            <table border="1">
                <tr>
                    <th align="center">Product ID</th>
                    <th align="center">Product Name</th>
                    <th align="center">Quantity</th>
                    <th align="center">Price</th>
                </tr>
                
                <!--Print out the items in the cart-->
                <?php 
                $sum = 0;
                if (!(empty($_SESSION['cart']) || count($_SESSION['cart']) == 0))
                foreach ($_SESSION['cart'] as $cartRow) : ?>
                <tr>
                    <td align="center"><?php echo $cartRow['id']; ?></td>
                    <td align="center"><?php echo $cartRow['name']; ?></td>
                    <td align="center"><?php echo $cartRow['quantity']; ?></td>
                    <td align="center"><?php echo "$".$cartRow['price']; ?></td>
                    <?php $sum+= $cartRow['price']; ?>
                </tr>
                <?php endforeach; ?>

                <tr>
                    <td></td>
                    <td></td>
                    <td align="center">Subtotal</td>
                    <td align="center"><?php echo "$".$sum; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td align="center">Handling</td>
                    <td align="center">Free</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td align="center">Shipping</td>
                    <td align="center">Free</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td align="center">Total</td>
                    <td align="center"><?php echo "$".$sum; ?></td>
                </tr>
            </table>
            <p></p>

            <!--Place Order-->
            <form align="center" action="order.php" method="post">
                <input type="number" name="customer_id" placeholder="Customer ID">
                <input type="submit" value="Place Order">
            </form>
        </main>
        <footer>
            <p>&copy; <?php echo date("Y"); ?> Henry Wang</p>
        </footer>
    </body>
</html>