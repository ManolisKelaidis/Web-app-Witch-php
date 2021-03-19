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
/*
 * kaneis to query afou pareis tis times sosta
 * pairneis apo to query oti pliroforia 8es
 * stelneis tin pliroforia pou xreiazesai sto html san apantisi apo to php
 * 
 */

$sql3 = "SELECT SUM(price) AS total_sum FROM cart";
$data3 = mysqli_query($conn,$sql3);
$row3 = mysqli_fetch_assoc($data3);
$sum = $row3['total_sum'];

$sql = "SELECT* FROM product WHERE Pid=".$pid;
$data = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($data);


$sql2 = "SELECT SUM(price) AS total_sum FROM cart";
$data2 = mysqli_query($conn,$sql2);
$row2 = mysqli_fetch_assoc($data2);
$sum = $row2['total_sum'];

echo $row['name'];
echo '|';
echo $row['producer'];
echo '|';
echo $row['varieties'];
echo '|';
echo $row['color'];
echo '|';
echo $row['date'];
echo '|';
echo $row['price'];
echo '|';
echo $quantity;
echo '|';
echo $sum;




mysqli_close($conn);

?>