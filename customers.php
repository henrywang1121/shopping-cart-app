<?php
require_once('database.php');

if(!isset($_SESSION)) 
{ 
    session_start(); 
}

$queryCustomers = 'SELECT * FROM customers';
$statement10 = $db->prepare($queryCustomers);
$statement10->execute();
$customers = $statement10->fetchAll();
$statement10->closeCursor();

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
            <h1 align="center">Customer List</h1>
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
                <table border="1">
                    <tr>
                        <th>Customer ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Select</th>
                    </tr>

                    <?php foreach ($customers as $customerRow) : ?>
                    <tr>
                        <td align="center"><?php echo $customerRow['customerID']; ?></td>
                        <td align="center"><?php echo $customerRow['customerFirstName']; ?></td>
                        <td align="center"><?php echo $customerRow['customerLastName']; ?></td>

                        <!--select the customer-->
                        <td><form action="admin_order_history.php" method="post">
                            <input type="hidden" name="customer_id"
                                value="<?php echo $customerRow['customerID']; ?>">
                            <input type="submit" value="Select">
                        </form></td>
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