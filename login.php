<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hy360_project";
session_start();

if (isset($_POST["login"])) {
    $name = $_POST['un'];
    $pw = $_POST['pw'];
}
//Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql1 = "SELECT name FROM individuals WHERE name='$name' and password='$pw'";
$sql2 = "SELECT name FROM merchant WHERE name='$name' and password='$pw'";


if (mysqli_num_rows(mysqli_query($conn, $sql1)) > 0) {
    $_SESSION["user"] = $name;
    echo $_SESSION["user"];
    echo"WELCOME TO OUR SITE";
    header("Location: home.html");
} else if (mysqli_num_rows(mysqli_query($conn, $sql2)) > 0) {
    $_SESSION["user"] = $name;
    echo $_SESSION["user"];
    echo"WELCOME TO OUR SITE";
    header("Location: home.html");
} else {
    echo"Do not exist Please Sign Up first.";
    header("Location: login.html");
}

mysqli_close($conn);
?>