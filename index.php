<?php 
    include("header1.php");
    //port changed to 3307 in xampp, please change accordingly if your port is 3306 or others to:-> "$servername = "localhost:3306 or other";
    $servername = "localhost:3307";
    $username = "root";
    $password = "";
    $dbname = "classicmodels";
    //create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    //check connection
    if (!$conn) {
        die("Connection failed: ".mysqli_connect_error());
    }
    //executing the queries to get the productline table and products table
    $query_productline = "SELECT productLine, textDescription FROM productlines";
    $result = mysqli_query($conn, $query_productline);
    $prod_description = "";
    //if statement to check that the number of rows from the table is parsed
    if (mysqli_num_rows($result) > 0) {
    //creating a dropdown menu above the descriptions that users can choose to display
    $form = "<form action='index.php#product_call' method='post' id='select' style='margin-top: 30px;'>
            <label for='productlines'>Choose a product line:</label>
            <select id='productline' name='productline'>";
    //while loop to go through the associative array
    while($value = mysqli_fetch_assoc($result)) {
        $form .= "<option value=".$value['productLine'].">".$value['productLine']."</option>";
        //adding the heading and descriptions by using globals to access it across different scopes
        $prod_description .= "<h2><span>".$value['productLine']."</span></h2>";
        $prod_description .= "<p>".$value['textDescription']."</p><br>";
        }
    //closing form and printing it..
    $form .= "</select><input type='submit'></form>";
    echo $form;
    echo "<h2 style='font-size:29px; text-align:center; margin-top:50px;'><span>Product Line Information</span></h2>";
    echo $prod_description; 
    echo "<br><br>";
        //section to display the information on the products when submit button is clicked 
        }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //echo "in the if statement..";
        $query_products = "SELECT * FROM products";
        $result2 = mysqli_query($GLOBALS['conn'], $query_products);
        //echo "function has been executed";
        $products = "<table class='line'><tr><th>Product Code</th><th>Product Name</th>
        <th>Product Line</th><th>Product Scale</th><th>Product Vendor</th>
        <th>Product Description</th><th>Quantity in Stock</th><th>Buy Price</th>
        <th>MSRP</th></tr>";
        //collects value of what was selected
        $selected = $_REQUEST['productline'];
        //echo $selected;
        while($value = mysqli_fetch_assoc($result2)) {
            $productLine = $value['productLine'];
            //checks first string of $productLine is equal to the selected option
            //only returns one word ($select - Classic instead of Classic Cars) so strtok has to be used
            if (strtok($productLine, " ") == $selected) {
                $products .= "<tr><td>".$value['productCode']."</td><td>".$value['productName']."</td><td>".$value['productLine']."</td><td>"
                .$value['productScale']."</td><td>".$value['productVendor']."</td><td>".$value['productDescription']."</td><td>"
                .$value['quantityInStock']."</td><td>".$value['buyPrice']."</td><td>".$value['MSRP']."</td><tr>";
                }
              }
            $products .= "</table>";
            echo "<h2 id='product_call'><span>Product Line Information</span></h2>";
            echo $products;
          }
        //includes the footer file to display the footer of the webpage
        include("footer.php");
        ?>