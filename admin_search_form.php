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
                        OR productDescription LIKE :searchValue1
                        OR productDescription LIKE :searchValue2
                        OR productDescription LIKE :searchValue3
                        ORDER BY productID';
$statement9 = $db->prepare($searchProducts);
//I tried to use different search patterns 
$statement9->bindValue(':searchValue1', "% ".$searchValue." %");
$statement9->bindValue(':searchValue2', $searchValue." %");
$statement9->bindValue(':searchValue3', "% ".$searchValue);
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

            <section>
                <!--Search a product-->
                <form action="admin_search_form.php" method="post">
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
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>

                    <?php foreach ($searchResults as $productRow) : ?>
                    <tr>
                        <td align="center"><?php echo $productRow['productName']; ?></td>
                        <td align="center"><?php echo $productRow['productDescription']; ?></td>
                        <td align="center"><?php echo "$".$productRow['productPrice']; ?></td>
                        <td align="center"><?php echo $productRow['productStockQuantity']; ?></td>

                        <!--Update the product-->
                        <td>
                            <form action="update_product.php" method="post">
                                <input type="text" name="product_name" placeholder="Name">
                                <input type="hidden" name="product_id"
                                    value="<?php echo $productRow['productID']; ?>">
                                <input type="submit" value="Update">
                            </form>
                            <form action="update_product.php" method="post">
                                <input type="text" name="product_description" placeholder="Description">
                                <input type="hidden" name="product_id"
                                    value="<?php echo $productRow['productID']; ?>">
                                <input type="submit" value="Update">
                            </form>
                            <form action="update_product.php" method="post">
                                <input type="number" name="product_price" placeholder="Price">
                                <input type="hidden" name="product_id"
                                    value="<?php echo $productRow['productID']; ?>">
                                <input type="submit" value="Update">
                            </form>
                            <form action="update_product.php" method="post">
                                <input type="number" name="product_stock_quantity" placeholder="Quantity">
                                <input type="hidden" name="product_id"
                                    value="<?php echo $productRow['productID']; ?>">
                                <input type="submit" value="Update">
                            </form>
                        </td>

                        <!--delete the product-->
                        <td>
                            <form action="delete_product.php" method="post">
                                <input type="hidden" name="product_id"
                                    value="<?php echo $productRow['productID']; ?>">
                                <input type="hidden" name="category_id"
                                    value="<?php echo $productRow['productCategory']; ?>">
                                <input type="submit" value="Delete">
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