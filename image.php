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




$sql = "SELECT photo FROM product WHERE Pid=".$pid;
$data = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($data);

$path = $row['photo'];

$img = "<img src='$path'>";
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php echo $img ?>
    </body>
</html>

