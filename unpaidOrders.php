<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hy360_project";
session_start();

$conn = mysqli_connect($servername, $username, $password, $dbname);
$conn->set_charset("utf8");


if (!$conn) {
    die('cannot connect to server');
}

$name = $_SESSION['user'];
$query = "SELECT Oid,content,cost FROM orders WHERE name='$name' and status='unpaid' ";

$data = mysqli_query($conn, $query);

$results = array();

while ($object = mysqli_fetch_object($data)) {
    $results[] = $object;
}

foreach ($results as $result) {
    $oid = $result->Oid;
    $content = $result->content;
    $cost = $result->cost;
}

$queryx = "SELECT current_debt FROM individuals WHERE name='$name'"
        . "UNION SELECT current_debt FROM merchant WHERE name='$name'";
$datax = mysqli_query($conn, $queryx);
$debt_temp = mysqli_fetch_assoc($datax);
$debtA = $debt_temp['current_debt'];

if($debtA <= 0) {
    header("Location: thanks.html");
}


?>

<!DOCTYPE html>
    <html>
    <head>
    <meta http-equiv = "Content-Type" content = "text/html; charset=UTF-8">
    <link rel = "stylesheet" type = "text/css" href = "table.css">
    <script src = "buy.js"></script>
    <title>UnpaidOrder</title>
    </head>
    <body>
        
    <?php echo "<b>Order Id= </b>".$oid." <b>Content= <b>".$content." <b>Cost= <b>".$cost."$"; ?>
                            
    <form action="pay.php" method="post">
        Amount to pay: <input type="text" name="amount"><br>
        Bank Accounts: <input type="text" name="bank"><br>
        <input type="submit" name="pay" value="Pay">
    </form>
        
    </body>
    </html>
    