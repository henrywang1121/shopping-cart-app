<!DOCTYPE html>
<html>
    <head>
        <title>My Online Store</title>
    </head>

    <body>
        <header><h1>My Online Store</h1></header>

        <main>
            <h1>Database Error</h1>
            <p>There was an error connecting to the database.</p>
            <p>Error message: <?php echo $error_message; ?></p>
            <p>&nbsp;</p>
        </main>

        <footer>
            <p>&copy; <?php echo date("Y"); ?> Henry Wang</p>
        </footer>
    </body>
</html>