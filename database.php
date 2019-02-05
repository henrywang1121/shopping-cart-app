<?php
    $dsn = 'mysql:host=localhost;dbname=cs602db';
    $username = 'cs602_user';
    $password = 'cs602_secret';

    try{
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e){
        $error_message = $e->getMessage();
        include('database_error.php');
        exit();
    }

    //"cs602db" is created using phpMyAdmin
    //The following code is inserted into the database directly using phpMyAdmin
    
    /*

    GRANT ALL PRIVILEGES ON cs602db.* TO cs602_user@localhost identified by 'cs602_secret';
    
    drop table categories;
    drop table products;
    drop table customers;
    drop table orders;

    CREATE TABLE categories(
        categoryID VARCHAR(255) NOT NULL,
        categoryName VARCHAR(255) NOT NULL,
        PRIMARY KEY (categoryID)
    );

    INSERT INTO categories VALUES
    ('laptop', 'Laptop'),
    ('desktop', 'Desktop'),
    ('smartphone', 'Smartphone');

    CREATE TABLE products(
        productID INT(11) NOT NULL AUTO_INCREMENT,
        productName VARCHAR(255) NOT NULL,
        productDescription VARCHAR(255) NOT NULL,
        productPrice INT(11)  NOT NULL,
        productStockQuantity INT(11) NOT NULL,
        productCategory VARCHAR(255) NOT NULL,
        PRIMARY KEY (productID)
    );

    INSERT INTO products VALUES
    (1, 'Macbook Pro', 'The MacBook Pro is a line of Macintosh portable computers introduced in January 2006 by Apple Inc.', '1299', '10', 'laptop'),
    (2, 'iPhone X', 'iPhone X is a smartphone designed, developed, and marketed by Apple Inc.', '999', '10', 'smartphone'),
    (3, 'iMac', 'iMac is a family of all-in-one Macintosh desktop computers designed and built by Apple Inc.', '1099', '10', 'desktop'),
    (4, 'Pixel 2', 'Pixel 2 and Pixel 2 XL are Android smartphones designed, developed and marketed by Google.', '649', '10', 'smartphone'),
    (5, 'Pixelbook', 'Google Pixelbook is a portable laptop / tablet hybrid computer developed by Google which runs Chrome OS.', '899', '10', 'laptop'),
    (6, 'Surface Book', 'The Surface Book is a 2-in-1 PC designed and produced by Microsoft, part of the company\'s Surface line of personal computing devices.', '1199', '10', 'laptop'),
    (7, 'Surface Studio', 'The Surface Studio is an all-in-one PC, designed and produced by Microsoft as part of its Surface series of Windows-based personal computing devices.', '2999', '10', 'desktop');

    CREATE TABLE customers(
        customerID INT(11) NOT NULL AUTO_INCREMENT,
        customerFirstName VARCHAR(255) NOT NULL,
        customerLastName VARCHAR(255) NOT NULL,
        PRIMARY KEY (customerID)
    );

    INSERT INTO customers VALUES
    (1, "Henry", "Wang"),
    (2, "John", "Doe"),
    (3, "Tom", "Smith");

    CREATE TABLE orders(
        orderID INT(11) NOT NULL AUTO_INCREMENT,
        customerID INT(11) NOT NULL,
        productID INT(11) NOT NULL,
        orderQuantity INT(11) NOT NULL,
        orderPrice INT(11) NOT NULL,
        PRIMARY KEY (orderID)
    )

    */
?>