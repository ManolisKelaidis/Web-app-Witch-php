<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hy360_project";
    
    
     if (isset($_POST["BadCustomers"])) {            
        //Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if(!$conn){
            die("Connection failed: " . mysqli_connect_error());
        }
        
        
        $sql = "SELECT individuals.current_debt,individuals.name FROM individuals WHERE individuals.current_debt>0 union SELECT merchant.current_debt,merchant.name FROM merchant WHERE merchant.current_debt>0 ORDER BY current_debt DESC ";
        $result = $conn->query($sql); 
        //(mysqli_query($conn, $sql))>0
        if ($result->num_rows > 0) {
            echo"Here is a list with the Bad customers:";
            
        // output data of each row
            while($row = $result->fetch_assoc()) {
                echo  "<br>". $row["name"].  " | "." curent debt: " . $row["current_debt"]. "<br>";
            }
        } else {
            echo "0 results";
        }

$conn->close();
     }