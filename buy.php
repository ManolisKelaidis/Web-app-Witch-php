<?php

function get_products() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hy360_project";
    
    //session_start();
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $conn->set_charset("utf8");
    
    
    if(!$conn){
        die('cannot connect to server');
    }
    $query = "select* from product";
    $data = mysqli_query($conn,$query);
    
    $products = array();
    
    while($object=mysqli_fetch_object($data)){
        $products[] = $object;
    }
    
    mysqli_close($conn);
    return $products;
}

function get_cart() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hy360_project";
    
    //session_start();
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $conn->set_charset("utf8");
    
    
    if(!$conn){
        die('cannot connect to server');
    }
    $query = "select* from cart";
    $data = mysqli_query($conn,$query);
    
    $products = array();
    
    while($object=mysqli_fetch_object($data)){
        $products[] = $object;
    }
    
    mysqli_close($conn);
    return $products;
}

function get_table() {
//create table
    $table_str ='<table id="product_table" class="blueTable" align="center">';
    $products = get_products();
    $table_str .= '<tr>';
    $table_str .= '<th>Name</th><th>Producer</th><th>Varieries</th><th>Color</th><th>Date</th><th>Price</th><th>Quantity</th></tr><br>';
    foreach($products as $product) {

        $table_str .='<tr>';
        $table_str .='<td>'.$product->name.'</td><td>'. $product->producer . '</td><td>' .$product->varieties.'</td><td>'.$product->color.'</td><td>'.$product->date.'</td>' .
                '<td>'. $product->price.'</td>'.'<td>'. ' <input type="text"'. 'id="quantity'.$product->Pid. '">'.'</td>'.
                '<td>' .'<button id="'.$product->Pid . '" onclick="addToCart('.$product->Pid.','.$product->price.')" type="button">Add to cart</button>'. '</td>'
                . '<td>' .'<button id="'.$product->Pid . '" onclick="image('.$product->Pid.')" type="button">Show image</button>'. '</td>'.
                "<div id='image_div'></div>";
        $table_str .= '</tr>';
    }
    $table_str.='</table>';
    return $table_str;
}

function print_cart() {
//create table
    $table_str ='<table id="cart_table" class="blueTable" align="center">';
    $pids = get_cart();
    $table_str .= '<tr>';
    $table_str .= '<th>Name</th><th>Producer</th><th>Varieries</th><th>Color</th><th>Date</th><th>Price</th><th>Quantity</th></tr><br>';
    foreach($pids as $pid) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hy360_project";
    
    //session_start();
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $conn->set_charset("utf8");
    
    
    if(!$conn){
        die('cannot connect to server');
    }
        $query = "select*  from product WHERE Pid=".$pid->pid;
        $data = mysqli_query($conn,$query);
       
        $products = array();
    
        while($object=mysqli_fetch_object($data)){
            $products[] = $object;
        }
        
        foreach($products as $product) {
        $table_str .='<tr>';
        $table_str .='<td>'.$product->name.'</td><td>'. $product->producer . '</td><td>' .$product->varieties.'</td><td>'.$product->color.'</td><td>'.$product->date.'</td>' .
                '<td>'. $product->price.'</td>'. '<td>'. $pid->quantity.'</td>';
        $table_str .= '</tr>';
    }
    }
    $table_str.='</table>';
    return $table_str;
}
?>



<!DOCTYPE html>
<html>
    <head>
         <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
         <link rel="stylesheet" type="text/css" href="table.css">
         <script src="buy.js"></script>
         <script src="image.js"></script>
        <title>Buy</title>
 </head>
    <body>


        <?php 
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "hy360_project";
            session_start();

            $conn = mysqli_connect($servername, $username, $password, $dbname);
            $conn->set_charset("utf8");


            if(!$conn){
                die('cannot connect to server');
            }
            
            $name = $_SESSION['user'];
            $query = "SELECT current_debt FROM individuals WHERE name='$name'"
                        . " UNION SELECT current_debt FROM merchant WHERE name='$name'";
            
            $data = mysqli_query($conn,$query);
            $debt= mysqli_fetch_assoc($data);
            
            
             $debt = $debt['current_debt'];
            if($debt > 0 ) {
                header("Location: debtMessage.html");
            }else{
                echo get_table();
            }
        
   
        ?>

        <h2>Cart</h2>
     <table class="blueTable" id="totalPrice">
           <?php echo print_cart(); echo "<br>"; ?>
        </table>
   

<table class="blueTable" id="MyCartTable"> 

    <th>NAME</th>
    <th>PRODUCER</th> 
    <th>VARIETY</th>
    <th>COLOR</th>
    <th>DATE</th>
    <th>PRICE</th>
   <th>QUANTITY</th>
   <th>Total Price</th>


</table>

        
            
            
        <button onclick="hideCart()">Buy</button>
       
        
        <script>
        function hideCart(){
            var a = document.getElementById("product_table");
                a.style.display = "none";
            location.href ="http://localhost/hy360_Proect/completeBuy.php";
            
                
        }
        </script>
        
    </body>
</html>