<?php
require_once('database.php');

if(!isset($_SESSION)) 
{ 
    session_start(); 
}

// Get product ID
if (!isset($category_id)) {
    $category_id = filter_input(INPUT_GET, 'product_id');
    if ($category_id == NULL || $category_id == FALSE) {
        $category_id = "laptop";
    }
}

// Get name for selected category
$queryCategory = 'SELECT * FROM categories
                  WHERE categoryID = :category_id';
$statement1 = $db->prepare($queryCategory);
$statement1->bindValue(':category_id', $category_id);
$statement1->execute();
$category = $statement1->fetch();
$category_name = $category['categoryName'];
$statement1->closeCursor();

// Get all categories
$query = 'SELECT * FROM categories 
            ORDER BY categoryID';
$statement2 = $db->prepare($query);
$statement2->execute();
$categories = $statement2->fetchAll();
$statement2->closeCursor();

//Get products for selected category
$queryProducts = 'SELECT * FROM products
                  WHERE productCategory = :product_id
                  ORDER BY productID';
$statement3 = $db->prepare($queryProducts);
$statement3->bindValue(':product_id', $category_id);
$statement3->execute();
$products = $statement3->fetchAll();
$statement3->closeCursor();

// Get the action to perform
$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'show_add_item';
    }
}

switch($action) {
    case 'empty_cart':
        unset($_SESSION['cart']);
        include('cart_view.php');
        break;
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
            <h1 align="center">Product List</h1>
            <aside>
                <h2>Products</h2>
                <nav>
                    <ul>
                        <?php foreach ($categories as $categoryRow) : ?>
                            <li><a href="./admin.php?product_id=<?php echo $categoryRow['categoryID']; ?>">
                                    <?php echo $categoryRow['categoryName']; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                        <hr>
                        <li><a href="admin_search_form.php">Search</a></li>
                        <li><a href="add_product_form.php">Add Product</a></li>
                        <li><a href="categories_list.php">Add Category</a></li>
                        <li><a href="cart_view.php">Cart</a></li>
                        <li><a href="admin_order_history.php">Order History</a></li>
                        <li><a href="customers.php">Customers</a></li>
                        <hr>
                        <li><a href="index.php">Customer Home</a></li>
                    </ul>
                </nav>          
            </aside>

            <section>
                <!-- display a table of products -->
                <h2><?php echo $category_name; ?></h2>
                <table border="1">
                    <tr>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Available</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>

                    <?php foreach ($products as $productRow) : ?>
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