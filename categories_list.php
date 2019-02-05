<?php
require_once('database.php');

// Get all categories
$query = 'SELECT * FROM categories
                       ORDER BY categoryID';
$statement = $db->prepare($query);
$statement->execute();
$categories = $statement->fetchAll();
$statement->closeCursor();
?>

<!DOCTYPE html>
<html>
    <!-- the head section -->
    <head>
        <title>My Online Store</title>
        <link rel="stylesheet" type="text/css" href="main.css" />
    </head>

    <!-- the body section -->
    <body>
    <header><h1>My Online Store</h1></header>
    <main>
        <h1 align="center">Add Category</h1>
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
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                </tr>
                
                <!-- add code for the rest of the table here -->
                <?php foreach ($categories as $categoryRow) : ?>
                    <tr>
                    <td><?php echo $categoryRow['categoryID']; ?></td>
                    <td><?php echo $categoryRow['categoryName']; ?></td>
                    </tr>
                <?php endforeach; ?>
            
            </table>
            <p></p>
            <!-- add code for the form here -->
            <form action="add_category.php" method="post" id="add_category_form">
                <label>Category ID:</label>
                <input type="text" name="category_id"><br>
                <p>
                <label>Category Name:</label>
                <input type="text" name="category_name"><br>
                <p>
                <input type="submit" value="Add Category"><br>
            </form>
        </section>
        </main>
        <footer>
            <p>&copy; <?php echo date("Y"); ?> Henry Wang</p>
        </footer>
    </body>
</html>