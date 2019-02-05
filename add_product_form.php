<?php
require('database.php');
$query = 'SELECT *
          FROM categories
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
    <link rel="stylesheet" type="text/css" href="main.css">
</head>

<!-- the body section -->
<body>
    <header><h1>My Online Store</h1></header>

    <main>
        <h1 align="center">Add Product</h1>
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
            <form action="add_product.php" method="post" id="add_product_form">
                <label>Category:</label>
                <select name="category_id">
                <?php foreach ($categories as $categoryRow) : ?>
                    <option value="<?php echo $categoryRow['categoryID']; ?>">
                        <?php echo $categoryRow['categoryID'].'-'.$categoryRow['categoryName']; ?>
                    </option>
                <?php endforeach; ?>
                </select><br>
                <label>Product Name: </label>
                <input type="text" name="product_name"><br>
                <label>Product Description: </label>
                <input type="text" name="product_description"><br>
                <label>Product Price: </label>
                <input type="number" name="product_price"><br>
                <label>Product Stock Quantity: </label>
                <input type="number" name="product_stock_quantity"><br>
                <input type="submit" value="Add Product"><br>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Henry Wang</p>
    </footer>
</body>
</html>