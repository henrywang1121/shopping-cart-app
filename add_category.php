<?php
// Get the category data
$categoryID = filter_input(INPUT_POST, 'category_id');
$categoryName= filter_input(INPUT_POST, 'category_name');

// Validate inputs
if ($categoryID == null || $categoryName == null) {
    $error = "Invalid course data. Check all fields and try again.";
    include('error.php');
} else {
    require_once('database.php');

    // Add the category to the database  
    $query = 'INSERT INTO categories
                 (categoryID, categoryName)
              VALUES
                 (:categoryID, :categoryName)';
    $statement = $db->prepare($query);
    $statement->bindValue(':categoryID', $categoryID);
    $statement->bindValue(':categoryName', $categoryName);
    $statement->execute();
    $statement->closeCursor();

    // Display the Category List page
    include('categories_list.php');
}
?>