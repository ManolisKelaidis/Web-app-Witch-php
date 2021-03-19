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


$query = "SELECT t.* FROM popular t ORDER BY t.frequency DESC LIMIT 10";

$data = mysqli_query($conn, $query);

$results = array();

while ($object = mysqli_fetch_object($data)) {
    $results[] = $object;
}

foreach ($results as $result) {
    
    
    $query = "select* from product WHERE pid=".$result->pid;
    $data = mysqli_query($conn,$query);
    
    $products = array();
    
    while($object=mysqli_fetch_object($data)){
        $products[] = $object;
    }
    foreach ($products as $product) {
    echo "<b>Product Id: </b>".$result->pid." <b>Times Sold: </b>".$result->frequency."<br>";
    echo 'Name: ' .$product->name; 
    echo '<br /> Producer: ' .$product->producer; 
    echo '<br /> Varieties: '.$product->varieties; 
    echo '<br /> Color: '.$product->color; 
    echo '<br /> Date: '.$product->date;
    echo '<br /> Price: '.$product->price."$";
    echo"<br />";
    echo"<br />";
    }
}