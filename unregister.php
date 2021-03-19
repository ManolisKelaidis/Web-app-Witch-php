<?php

session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hy360_project";
$conn = mysqli_connect($servername, $username, $password, $dbname);
$name = $_SESSION["user"];

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql1 = "SELECT name FROM individuals WHERE name='$name' and current_debt > 0";
$sql2 = "SELECT name FROM merchant WHERE name='$name' and current_debt > 0";
if (mysqli_num_rows(mysqli_query($conn, $sql1)) > 0) {
    sleep(3);
    header("Location: unregisterMessage.html");
} else {
    $sql3 = "DELETE FROM individuals WHERE name = '$name'";
    $sql4 = "DELETE FROM `cart`  WHERE 1=1 ";;
    session_destroy();
    mysqli_query($conn, $sql3);
    mysqli_query($conn, $sql4);
    sleep(3);
    header("Location: login.html");
}

if (mysqli_num_rows(mysqli_query($conn, $sql2)) > 0) {
    sleep(3);
    header("Location: unregisterMessage.html");
} else {
    $sql4 = "DELETE FROM merchant WHERE name = '$name'";
    session_destroy();
    mysqli_query($conn, $sql4);
    sleep(3);
    header("Location: login.html");
    
}
?>