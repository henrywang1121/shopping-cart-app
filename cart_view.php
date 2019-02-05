<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title>My Online Store</title>
        <link rel="stylesheet" type="text/css" href="main.css">
    </head>
    <body>
        <header>
            <h1>My Online Store</h1>
        </header>
        <main>
            <h1 align="center">Your Cart</h1>
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
            <?php if ((empty($_SESSION['cart']) || count($_SESSION['cart']) == 0))
                    echo "<p>There are no items in your cart.</p>";
            ?>
            <table border="1">
                <tr>
                    <th align="center">Product ID</th>
                    <th align="center">Product Name</th>
                    <th align="center">Quantity</th>
                    <th align="center">Price</th>
                </tr>
                
                <?php 
                $sum = 0;
                $counter = -1;
                if (!(empty($_SESSION['cart']) || count($_SESSION['cart']) == 0))
                foreach ($_SESSION['cart'] as $cartRow) : ?>
                <tr>
                    <?php $counter++ ?>
                    <td align="center"><?php echo $cartRow['id']; ?></td>
                    <td align="center"><?php echo $cartRow['name']; ?></td>
                    <td align="center">
                        <form action="update_cart.php" method="post">
                            <input type="hidden" name="product_id"
                                value="<?php echo $cartRow['id'];?>">
                            <input type="number" name="quantity"
                                value="<?php echo $cartRow['quantity'];?>">
                            <input type="hidden" name="session_array_index"
                                value="<?php echo $counter ?>">  
                            <input type="submit" value="Update">
                        </form>
                    </td>
                    <td align="center"><?php echo "$".$cartRow['price']; ?></td>
                    <?php $sum+= ($cartRow['quantity']*$cartRow['price']); ?>
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
            <form align="center">
                <input type="button" value="Place Order" 
                onclick="window.location.href='order.php'"/>
            </form>
        </main>
        <footer>
            <p>&copy; <?php echo date("Y"); ?> Henry Wang</p>
        </footer>
    </body>
</html>