<?php
require_once('database.php');

if(!isset($_SESSION)) 
{ 
    session_start(); 
}

//Retrive the search value
$searchValue = filter_input(INPUT_POST, 'search_value');

//Obtain an array of products with the specified search value
//Search only in productName and productDescription
$searchProducts = 'SELECT * FROM products 
                        WHERE productName LIKE :searchValue1
                        OR productName LIKE :searchValue2
                        OR productName LIKE :searchValue3
                        OR productName LIKE :searchValue4
                        OR productDescription LIKE :searchValue1
                        OR productDescription LIKE :searchValue2
                        OR productDescription LIKE :searchValue3
                        OR productDescription LIKE :searchValue4
                        ORDER BY productID';
$statement9 = $db->prepare($searchProducts);
//I tried to use different search patterns 
$statement9->bindValue(':searchValue1', "% ".$searchValue." %");
$statement9->bindValue(':searchValue2', $searchValue." %");
$statement9->bindValue(':searchValue3', "% ".$searchValue);
$statement9->bindValue(':searchValue4', $searchValue);
$statement9->execute();
$searchResults = $statement9->fetchAll();
$statement9->closeCursor();

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
            <h1 align="center">Product Search</h1>
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

            <section>
                <!--Search a product-->
                <form action="search_form.php" method="post">
                    <input type="text" name="search_value" placeholder="Search for Anything">
                    <input type="submit" value="Search Order">
                </form>
                <br>
                <!-- display a table of products -->
                <table border="1">
                    <tr>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Available</th>
                        <th>Add</th>
                    </tr>

                    <?php foreach ($searchResults as $productRow) : ?>
                    <tr>
                        <td align="center"><?php echo $productRow['productName']; ?></td>
                        <td align="center"><?php echo $productRow['productDescription']; ?></td>
                        <td align="center"><?php echo "$".$productRow['productPrice']; ?></td>
                        <td align="center"><?php echo $productRow['productStockQuantity']; ?></td>

                        <!--Add the product to the cart-->
                        <td>
                            <form action="cart.php" method="post">
                                <input type="hidden" name="product_id"
                                    value="<?php echo $productRow['productID']; ?>">
                                <input type="hidden" name="product_name"
                                    value="<?php echo $productRow['productName']; ?>">
                                <input type="hidden" name="product_price"
                                    value="<?php echo $productRow['productPrice']; ?>">
                                <input type="hidden" name="category_id"
                                    value="<?php echo $productRow['productCategory']; ?>">
                                <input type="number" name="quantity" placeholder="Quantity">
                                <input type="submit" value="Add">
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </section>
        </main>
        <footer>
            <p>&copy; <?php echo date("Y"); ?> Henry Wang</p>
        </footer>
    </body>
</html>