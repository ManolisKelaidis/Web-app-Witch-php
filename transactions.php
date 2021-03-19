<?php
session_start();
$from = $_POST['date1'];
$to = $_POST['date2'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hy360_project";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$name = $_SESSION["user"] ;
echo "<strong> Your Transactions : </strong>";
$sql = "SELECT name FROM merchant WHERE name='$name'"
                    . "UNION SELECT name FROM individuals WHERE name='$name'";
$result1 = mysqli_query($conn, $sql);
$row = $result1->fetch_assoc();
$name = $row["name"];

$sql = "SELECT id, amount, date FROM transactions WHERE name = '$name'
		AND date BETWEEN '$from' and '$to'";
$result2 = mysqli_query($conn, $sql);
if (mysqli_num_rows($result2) == 0) {
    echo "No transactions in this time period.";
} else {
    echo "<table border=1>";
    echo "<tr><th>Date</th><th>Account</th>";
    while ($new_row = mysqli_fetch_assoc($result2)) {
        echo "<tr>";
        echo "<td>" . $new_row["date"] . "</td>";
        echo "<td>" . $new_row["amount"] . "</td>";
        echo "</tr>";
    }
}

mysqli_close($conn);
?>
