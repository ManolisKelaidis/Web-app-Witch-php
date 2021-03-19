<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hy360_project";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

 $sql3 = "DELETE FROM `cart`  WHERE 1=1 ";
mysqli_query($conn, $sql3);
mysqli_close($conn);
header("Location: logoutMessage.html");
 