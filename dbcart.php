<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hy360_project";

$conn = mysqli_connect($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$pid = $_POST['pid'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];
$f = $quantity*$price;

$sql = "INSERT INTO cart (pid,quantity,price) VALUES (".$pid.",".$quantity.",".$f.")";
mysqli_query($conn,$sql);
$sql2 = "UPDATE popular SET frequency = frequency + '$quantity' WHERE pid = '$pid'";
mysqli_query($conn,$sql2);



mysqli_close($conn);

?>