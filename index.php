<?php
require_once('database.php');

//Start a session
if(!isset($_SESSION)) 
{ 
    $lifetime = 60 * 60 * 24 * 14;    // 2 weeks in seconds
    session_set_cookie_params($lifetime, '/');
    session_start();
} 

$_SESSION['sessionStatus'] ="In Session";
if(!isset($_SESSION['sessionStatus'])){
    echo "Session Status: Not in Session";
} else {
    echo "Session Status: ".$_SESSION['sessionStatus'];
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
                            <li><a href="./index.php?product_id=<?php echo $categoryRow['categoryID']; ?>">
                                    <?php echo $categoryRow['categoryName']; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                        <hr>
                        <li><a href="search_form.php">Search</a></li>
                        <li><a href="order_history.php">Order History</a></li>
                        <li><a href="cart_view.php">Cart</a></li>
                        <li><a href="index.php">Add More Items</a></li>
                        <li><a href=".?action=empty_cart">Empty Cart</a></li>
                        <li><a href="order.php">Place Order</a></li>
                        <hr>
                        <li><a href="admin.php">Admin Home</a></li>
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
                        <th>Add</th>
                    </tr>

                    <?php foreach ($products as $productRow) : ?>
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