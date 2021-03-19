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
$query = "SELECT content FROM orders WHERE name='$name' and status='paid' ";

$data = mysqli_query($conn, $query);

$results = array();

while ($object = mysqli_fetch_object($data)) {
    $results[] = $object;
}


//create table

$table_str ='<table id="return" class="blueTable" align="center">';
    $table_str .= '<tr>';
    $table_str .= '<th>Name</th><th>Producer</th><th>Varieries</th><th>Color</th><th>Price</th></tr>';
foreach ($results as $result) {
    $result->
    $table_str .='<tr>';
        $table_str .='<td>'.$product->name.'</td><td>'. $product->producer . '</td><td>' .$product->varieties.'</td><td>'.$product->color.'</td><td>'.$product->date.'</td>' .
                '<td>'. $product->price.'</td>'.'<td>'. ' <input type="text"'. 'id="quantity'.$product->Pid. '">'.'</td>'.
                '<td>' .'<button id="'.$product->Pid . '" onclick="addToCart('.$product->Pid.','.$product->price.')" type="button">Add to cart</button>'. '</td>';
        $table_str .= '</tr>';
}
    $table_str.='</table>';
    return $table_str;