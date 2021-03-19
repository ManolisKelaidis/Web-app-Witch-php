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

/******************************************************/

if (isset($_POST["pay"])) {
    
    
    $amount = $_POST['amount'];
    $bank = $_POST['bank'];
    
    $query = "SELECT current_debt,balance FROM individuals WHERE bank_account='$bank' union SELECT current_debt,balance FROM merchant WHERE bank_account='$bank'";

    $data = mysqli_query($conn, $query);
    
    $results = array();

    while ($object = mysqli_fetch_object($data)) {
        $results[] = $object;
    }

   
    foreach ($results as $result) {
        $balance = $result->balance;
        $cdebt = $result->current_debt;
    }
   
    
    
    $temp0 = $cdebt - $amount;
    $temp1 = $balance - $amount;
    
    
    if($balance >= $amount) {
        if($amount > $cdebt){
        $temp0=0;
        $temp1 = $balance - $cdebt;
        $amount = $cdebt;
        }
        $query = "UPDATE merchant SET current_debt='$temp0', balance='$temp1' WHERE bank_account = '$bank'";
        $query2 = "UPDATE individuals SET current_debt='$temp0', balance='$temp1' WHERE bank_account = '$bank'";
                
        mysqli_query($conn, $query);
        mysqli_query($conn, $query2);
        
        
        
        $query3 = "UPDATE orders SET cost= $temp0 WHERE name='$name'";
        mysqli_query($conn, $query3);
        
        $query4 = "SELECT cost FROM orders WHERE name='$name'";
        $a = mysqli_query($conn, $query4);
        
        $b = mysqli_fetch_assoc($a);
        $cost = $b['cost'];
       
        /*pare to OrderId tis paraggelias gia na to baleis ston pinaka transactions*/
        $sql7 = "SELECT Oid FROM orders WHERE name='$name'";
        $datax = mysqli_query($conn,$sql7);
        $oid = mysqli_fetch_assoc($datax);
       
        $kati = $oid['Oid'];
        
        $sqlxx = "INSERT INTO transactions (id,name,amount) VALUES('$kati','$name','$amount')";
         mysqli_query($conn,$sqlxx);
        
        if($cost <= 0) {
            $query = "UPDATE orders SET status='paid' WHERE name='$name'";
            mysqli_query($conn, $query);
        }
        
        header("Location: home.html");


        
    }else{
        header("Location: nomoney.html");
    }
    

}
