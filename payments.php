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
    //executing query to get the first 20 rows ordered by paymentDate
    $query_payments = "SELECT * FROM `payments` ORDER BY `payments`.`paymentDate` DESC LIMIT 20";
    $result_payment = mysqli_query($conn, $query_payments);
    if (mysqli_num_rows($result_payment) > 0) {
        //making heading rows and initialising table 
        $tablePay = "<form method='post' action='payments.php?#customer_heading' id='form_submit'><table class='office-tab'><tr><th>Check Number</th><th>Payment Date</th><th>Amount</th><th>Customer Number</th></tr>";
        while($value = mysqli_fetch_assoc($result_payment)) {
            //used form to be able to make buttons inside the table
            //used input type radio buttons and made a submit button at the very end
            $tablePay .= "<tr><td>".$value['checkNumber']."</td>
            <td>".$value['paymentDate']."</td><td>".$value['amount']."</td>
            <td><input type='radio' onclick='work()' id=".$value['customerNumber']. " class='hide_button' value=".$value['customerNumber']." name='customer'>
            <label for=".$value['customerNumber'].">".$value['customerNumber'].
            "</label></td></tr>";
        }
        $tablePay .= "</table></form>";
         //<input type='submit' id='submit'>
        echo "<h2><span>Payment Information</span></h2>";
        echo $tablePay;
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //displayNone();
            $chosen = $_REQUEST['customer'];
            //error checking that $chosen went through..
            //echo $chosen;
            //query to get sum amount for each customer number
            $query_sumPay = "SELECT customerNumber, SUM(amount) AS sumPayments FROM payments WHERE customerNumber ='".$chosen."'";
            //query to get all rows of table payments (but only for the first 20 again)
            $query_customerInfo = "SELECT C.customerNumber, C.phone, C.salesRepEmployeeNumber, C.creditLimit, P.paymentDate FROM customers C, payments P WHERE C.customerNumber = P.customerNumber ORDER BY paymentDate DESC LIMIT 20";
            //query to get information on all of the customers listed
            $query_allPayments = "SELECT customerNumber, paymentDate, checkNumber, amount FROM payments ORDER BY paymentDate";
            //make result variable for all the queries to connect to the database
            $result_sumPay = mysqli_query($conn, $query_sumPay);
            $result_customerInfo = mysqli_query($conn, $query_customerInfo);
            $result_allPayments = mysqli_query($conn, $query_allPayments);
            //while loops for customerInfo and creating variable to display information about the customer
            $customerInfoTable = "<<table class='line'><tr><th>Phone Number</th><th>Payment Date</th><th>Credit Limit</th><th>Sales Rep</th></tr>";
            $customerInfoHeading = "<h2><span>Customer Information</span></h2>";
            while ($value_customer = mysqli_fetch_assoc($result_customerInfo)) {
                //echo "i'm in this loop.."
                if ($value_customer['customerNumber'] == $chosen) {
                    //displaying information about the customer
                    $customerInfoTable .= "<tr><td>".$value_customer['phone']."</td>
                    <td>".$value_customer['paymentDate']."</td>
                    <td>".$value_customer['creditLimit']."</td>
                    <td>".$value_customer['salesRepEmployeeNumber']."</td></tr>";
                }
            }
            $customerInfoTable .= "</table>";
            //printing results
            echo $customerInfoHeading;
            echo $customerInfoTable; 
            //while loop for allPayments and creating to display information about the customer
            $allPaymentsHeading = "<h3 id='customer_heading'><span>Summary of All Payments:</span></h3>";
            $allPaymentsTable = "<table class='line'><tr><th>Check Number</th><th>Payment Date</th><th>Payments</th></tr>";
            while ($value_allpay = mysqli_fetch_assoc($result_allPayments)) {
                //echo "i'm in this loop.."
                if ($value_allpay['customerNumber'] == $chosen) {
                    $allPaymentsTable .= "<tr><td>".$value_allpay['checkNumber']."</td>
                    <td>".$value_allpay['paymentDate']."</td>
                    <td>".$value_allpay['amount']."</td></tr>";
                    }
                }
                $allPaymentsTable .= "</table>";
                //printing results..
                echo $allPaymentsHeading;
                echo $allPaymentsTable;
                //while loop for sumPay and printing the total sum of payments made by the customer
                while ($value_sumPay = mysqli_fetch_assoc($result_sumPay)) {
                    //echoing results
                    echo "<h3><span>Total Payment made by Customer ".$value_sumPay['customerNumber'].":</span></h3>";
                    echo "<p>".$value_sumPay['sumPayments']."</p>";
                }
            }
        include("footer.php");
        ?>
    