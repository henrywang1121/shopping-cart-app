<?php 
require_once('database.php');

/*
the REST APIs (XML & JSON) for the list of products,
products matching the specified name, and products within the specified price
range.

rest.php?format=xml&product=products
rest.php?format=json&product=products

rest.php?format=xml&product=productName
rest.php?format=json&product=productName

rest.php?format=xml&minprice=price&maxprice=price
rest.php?format=json&minprice=price&maxprice=price
*/

//Obtain the parameters
if(isset($_GET['format'])){
    $formatParam = $_GET['format'];
}
if(isset($_GET['product'])){
    $productParam = $_GET['product'];
}
if(isset($_GET['minprice'])){
    $minPriceParam = $_GET['minprice'];
}
if(isset($_GET['maxprice'])){
    $maxPriceParam = $_GET['maxprice'];
}

if(isset($_GET['format']) && isset($_GET['product'])){
    // Get all products
    $query = 'SELECT * FROM products
                ORDER BY productID';
    $statement = $db->prepare($query);
    $statement->execute();
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
}

if(isset($_GET['format']) && isset($_GET['product']) && ($_GET['product'] != "products")){
    //Get the specified product
    $queryProduct = 'SELECT * FROM products
                        WHERE productName = :product_name
                        ORDER BY productID';
    $statement2 = $db->prepare($queryProduct);
    $statement2->bindValue(':product_name', $productParam);
    $statement2->execute();
    $product = $statement2->fetchAll(PDO::FETCH_ASSOC);
    $statement2->closeCursor();
}

if(isset($_GET['format']) && isset($_GET['minprice']) && ($_GET['maxprice'])){
    //Get the products within the specified price range
    $queryProductsGivenPriceRange = 'SELECT * FROM products
                        WHERE productPrice >= :min_price AND productPrice <= :max_price
                        ORDER BY productID';
    $statement3 = $db->prepare($queryProductsGivenPriceRange);
    $statement3->bindValue(':min_price', $minPriceParam);
    $statement3->bindValue(':max_price', $maxPriceParam);
    $statement3->execute();
    $productsGivenPriceRange = $statement3->fetchAll(PDO::FETCH_ASSOC);
    $statement3->closeCursor();
}


//rest.php?format=xml&product=products
//rest.php?format=json&product=products
if(isset($_GET['product'])){
    if ($productParam == 'products'){
        //Output the json data
        if ($formatParam == 'json'){
            echo "<pre>";
            echo json_encode($products, JSON_PRETTY_PRINT);
            echo "</pre>";
        }
        //Output the xml data
        if ($formatParam == 'xml'){
            // Create new DOMDocument object (PHP feature) and set options
            $doc = new DOMDocument('1.0');
            $doc->preserveWhiteSpace = false;
            $doc->formatOutput = true;

            //Create the root element
            $root = $doc->createElement('products');
            $root = $doc->appendChild($root);

            // Create the element and append the child element one by one
            foreach($products as $productRow) {
                $productNode = $doc->createElement('product');
                $productNode = $root->appendChild($productNode);
                $i1 = $doc->createElement('productID', $productRow['productID']);
                $i2 = $doc->createElement('productName', $productRow['productName']);
                $i3 = $doc->createElement('productDescription', $productRow['productDescription']);
                $i4 = $doc->createElement('productPrice', $productRow['productPrice']);
                $i5 = $doc->createElement('productStockQuantity', $productRow['productStockQuantity']);
                $i6 = $doc->createElement('productCategory', $productRow['productCategory']);
                $productNode->appendChild($i1);
                $productNode->appendChild($i2);
                $productNode->appendChild($i3);
                $productNode->appendChild($i4);
                $productNode->appendChild($i5);
                $productNode->appendChild($i6);
            }

            //Output the xml data
            echo $doc->saveXML();
            header('Content-type: application/xml; charset=utf-8');

        }
    }
}

//rest.php?format=xml&product=productName
//rest.php?format=json&product=productName
if(isset($_GET['product'])){
    if ($productParam != 'products'){
        //Output the json data
        if ($formatParam == 'json'){
            echo "<pre>";
            echo json_encode($product, JSON_PRETTY_PRINT);
            echo "</pre>";
        }
        //Output the xml data
        if ($formatParam == 'xml'){
            // Create new DOMDocument object (PHP feature) and set options
            $doc = new DOMDocument('1.0');
            $doc->preserveWhiteSpace = false;
            $doc->formatOutput = true;

            //Create the root element
            $root = $doc->createElement('products');
            $root = $doc->appendChild($root);

            // Create the element and append the child element one by one
            foreach($product as $productRow) {
                $productNode = $doc->createElement('product');
                $productNode = $root->appendChild($productNode);
                $i1 = $doc->createElement('productID', $productRow['productID']);
                $i2 = $doc->createElement('productName', $productRow['productName']);
                $i3 = $doc->createElement('productDescription', $productRow['productDescription']);
                $i4 = $doc->createElement('productPrice', $productRow['productPrice']);
                $i5 = $doc->createElement('productStockQuantity', $productRow['productStockQuantity']);
                $i6 = $doc->createElement('productCategory', $productRow['productCategory']);
                $productNode->appendChild($i1);
                $productNode->appendChild($i2);
                $productNode->appendChild($i3);
                $productNode->appendChild($i4);
                $productNode->appendChild($i5);
                $productNode->appendChild($i6);
            }

            //Output the xml data
            echo $doc->saveXML();
            header('Content-type: application/xml; charset=utf-8');

        }
    }
}

//rest.php?format=xml&minprice=price&maxprice=price
//rest.php?format=json&minprice=price&maxprice=price
if (isset($minPriceParam) && isset($maxPriceParam)){
    //Output the json data
    if ($formatParam == 'json'){
        echo "<pre>";
        echo json_encode($productsGivenPriceRange, JSON_PRETTY_PRINT);
        echo "</pre>";
    }
     //Output the xml data
     if ($formatParam == 'xml'){
        // Create new DOMDocument object (PHP feature) and set options
        $doc = new DOMDocument('1.0');
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;

        //Create the root element
        $root = $doc->createElement('products');
        $root = $doc->appendChild($root);

        // Create the element and append the child element one by one
        foreach($productsGivenPriceRange as $productRow) {
            $productNode = $doc->createElement('product');
            $productNode = $root->appendChild($productNode);
            $i1 = $doc->createElement('productID', $productRow['productID']);
            $i2 = $doc->createElement('productName', $productRow['productName']);
            $i3 = $doc->createElement('productDescription', $productRow['productDescription']);
            $i4 = $doc->createElement('productPrice', $productRow['productPrice']);
            $i5 = $doc->createElement('productStockQuantity', $productRow['productStockQuantity']);
            $i6 = $doc->createElement('productCategory', $productRow['productCategory']);
            $productNode->appendChild($i1);
            $productNode->appendChild($i2);
            $productNode->appendChild($i3);
            $productNode->appendChild($i4);
            $productNode->appendChild($i5);
            $productNode->appendChild($i6);
        }

        //Output the xml data
        echo $doc->saveXML();
        header('Content-type: application/xml; charset=utf-8');
    }
}

?> 