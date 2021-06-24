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
    //executing the queries to get the offices
    $query_offices = "SELECT * FROM offices";
    $result_offices = mysqli_query($conn, $query_offices);
    //creating a table to represent the different offices in the table offices
    $table_offices = "<table class='office-tab'><tr><th>City</th><th>Address</th><th>Phone Number</th><th></th></tr>";
    $radioButton = "<form action='offices.php#employee_info' id='office-form' method='post'><p>See more information on Employees by clicking below</p>";
    //while loop to go through the associative array
     while ($value = mysqli_fetch_assoc($result_offices)) {
        $table_offices .= "<tr><td>".$value['city']."</td><td>"
        .$value['addressLine1'].", ".$value['addressLine2']."</td><td>"
        .$value['phone']."</td></tr>"; 
        $radioButton .= "<input type='radio' name='office' value=".$value['officeCode'].">
        <label for=".$value['officeCode']." >".$value['city']."</label>";            
        }
    $table_offices .= "</table>
                           <br><br>";
    $radioButton .= "<br><input type='submit' value='Submit' onload=showEmployeeHead()></form>";
    //printing the table
    echo "<h2 style='font-size:29px; margin-top:50px;'><span>Offices Information</span></h2>";
    echo $table_offices;
    echo $radioButton;
    //if statement..
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //making a query
        $query_employee = "SELECT * FROM employees ORDER BY jobTitle ";
        //executing query
        $result_employee = mysqli_query($GLOBALS['conn'], $query_employee);
        //making a table - ***change the variable name
        $products = "<table class='line'><tr><th>Name</th><th>Job Title</th>
        <th>E-mail Address</th></tr>";
        //gets the selected value
        $selected = ($_REQUEST['office']);
        while($value = mysqli_fetch_assoc($result_employee)) {
            if ($value['officeCode'] == $selected) {
                $products .= "<tr><td>".$value['firstName']." ".$value['lastName']."</td><td>".$value['jobTitle']."</td><td>"
                .$value['email']."</td><tr>";
            }
        }
        $products .= "</table>";
        echo "<h2 id='employee_info'><span>Employee Information</span></h2>";
        echo $products;
        } 
    include("footer.php");
?>