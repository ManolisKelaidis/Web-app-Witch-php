<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hy360_project";

$conn = mysqli_connect($servername, $username, $password, $dbname);
$conn->set_charset("utf8");


if (!$conn) {
    die('cannot connect to server');
}


$query = "SELECT name FROM individuals WHERE current_debt='0' UNION SELECT name FROM merchant WHERE current_debt='0'";

$data = mysqli_query($conn, $query);

$peoples = array();

while ($object = mysqli_fetch_object($data)) {
    $peoples[] = $object;
}
echo"<h1>A Big Thanks To Our Most Active Customers For All The Support</h1>";
foreach ($peoples as $people) {
    $query = "SELECT SUM(amount) AS temp FROM transactions WHERE name='$people->name'";
    $data2 = mysqli_query($conn, $query);
    
    
    $a= mysqli_fetch_assoc($data2);
    $aa = $a['temp'];
    if($aa > 0) { 
    echo"<br />";
    echo 'Name: '. $people->name; 
    echo '<br /> Amount: ' .$aa."$"; 
    echo"<br />";
    }
}


