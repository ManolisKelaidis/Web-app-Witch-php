<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hy360_project";

$conn = mysqli_connect($servername, $username, $password, $dbname);
$conn->set_charset("utf8");


if(!$conn){
    die('cannot connect to server');
}

session_start();
$sql = "SELECT SUM(price) AS total_sum FROM cart";
$data = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($data);
$sum = $row['total_sum'];
 


$sql2 = "SELECT pid,quantity FROM cart";
$data2 = mysqli_query($conn,$sql2);
//$row2 = mysqli_fetch_assoc($data2);
$products = array();

 while($object=mysqli_fetch_object($data2)){
        $products[] = $object;
    }

    $table_str ='<table class="blueTable">';
    $table_str .= '<tr>';
    $table_str .= '<th>Name</th><th>Producer</th><th>Varieries</th><th>Color</th><th>Date</th><th>Quantity</th><th>Price</th></tr>';
foreach($products as $product){
    $query = "SELECT* FROM product WHERE Pid=".$product->pid;
    $data = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($data);
    
    $table_str .='<tr>';
    $table_str .= '<td>'.$row['name'].'</td><td>'.$row['producer'].'</td><td>'.$row['varieties'].'</td><td>'.$row['color'].'</td><td>'.$row['date']
            .'</td><td>'.$product->quantity.'</td><td>'.$row['price'].'</td>';
   $table_str .= '</tr>';
}
$table_str.='</table>';

?>
<!DOCTYPE html>
<html>
    <head>
         <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
         <link rel="stylesheet" type="text/css" href="table.css">
        <title>Complete Buy</title>
 </head>
    <body>

        <?php echo $table_str; echo "<h2>Total Price</h2>".$sum."$"; 
        
        if (isset($_GET["complete"])) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "hy360_project";

            $conn = mysqli_connect($servername, $username, $password, $dbname);
            $conn->set_charset("utf8");
            
            $content = "";
            $name = $_SESSION['user'];
            
            if(!$conn){
            die('cannot connect to server');
            }
            
            $query0 = "SELECT balance FROM merchant WHERE name='$name'"
                    . "UNION SELECT balance FROM individuals WHERE name='$name'";
            
            $data0 = mysqli_query($conn,$query0);

            $balance = mysqli_fetch_assoc($data0);
            echo "balance--->".$balance['balance'];
            $global = $balance['balance'];
            if($balance['balance'] < $sum) {
                $query = "SELECT pid FROM cart WHERE 1=1";
                $data = mysqli_query($conn,$query);
                $temps = array();

                while($object=mysqli_fetch_object($data)){
                       $temps[] = $object;
                }

                foreach($temps as $temp) {
                 //echo "pid: ".$temp->pid;
                 $content .= $temp->pid.",";
                }

                $content = substr($content, 0, -1);
                
                
                $new = $sum - $balance['balance'];
                $kappa = $balance['balance'];
                
                
                /*an den exei ola ta lefta gia tin paraggelia partou osa lefta exei kai these to current debt = me auta pou xrwstaei*/
                $sql3 = "UPDATE individuals SET current_debt='$new', balance='0' WHERE name='$name'";
                mysqli_query($conn,$sql3);
                
                $sqlx = "UPDATE merchant SET current_debt='$new', balance='0' WHERE name='$name'";
                mysqli_query($conn,$sqlx);
                
                /*apothikeuse ston oreders tin paraggelia pou ekane me cost: ta lefta pou xrwstaei*/
                $sql2 = "INSERT INTO orders (name,content,cost,status) VALUES('$name','$content','$new','unpaid')";
                mysqli_query($conn,$sql2);
                
                /*pare to OrderId tis paraggelias gia na to baleis ston pinaka transactions*/
                $sql5 = "SELECT Oid FROM orders WHERE name='$name'";
                $datax = mysqli_query($conn,$sql5);
                $oid = mysqli_fetch_assoc($datax);   
                
                echo $balance['balance'];
                /*enimerwse ton pinaka transactions*/
                $kati = $oid['Oid'];
                $sql6 = "INSERT INTO transactions (id,name,amount) VALUES('$kati','$name','$kappa')";
                echo "--->".$sql6;
                mysqli_query($conn,$sql6);
                
                /*adeiazoume to kalathi*/
                $sql3 = "DELETE FROM cart WHERE 1=1";
                mysqli_query($conn,$sql3);
                
               header("Location: home.html");
                
            }else{
                
                /*exei to poso tis paraggelias kai thetoume to state ston order--->paid*/
                $query = "SELECT pid,quantity FROM cart WHERE 1=1";
                $data = mysqli_query($conn,$query);
                $temps = array();
                
                
                
                while($object=mysqli_fetch_object($data)){
                       $temps[] = $object;
                }

                foreach($temps as $temp) {
                 //echo "pid: ".$temp->pid;
                 $content .= $temp->quantity.'*'.$temp->pid.",";
                }

                $content = substr($content, 0, -1);
                $sql2 = "INSERT INTO orders (name,content,cost,status) VALUES('$name','$content','0','paid')";
                echo "<br>1-->".$sql2;
                mysqli_query($conn,$sql2);
                
                /*enimerwnoume to neo balance meta tin plirwmi kai to debt=0*/
                $new =  $global - $sum;
                echo "global". $global;
                echo "global". $sum;
                $sqlx = "UPDATE individuals SET current_debt='0',balance='$new' WHERE name='$name'";
                echo "<br>sqlx-->".$sqlx;
                mysqli_query($conn,$sqlx);
                
                $sqly = "UPDATE merchant SET current_debt='0',balance='$new' WHERE name='$name'";
                echo "<br>sqly-->".$sqly;
                mysqli_query($conn,$sqly);

                
                /*pare to OrderId tis paraggelias gia na to baleis ston pinaka transactions*/
                $sql7 = "SELECT Oid FROM orders WHERE name='$name'";
                echo "<br>sql7-->".$sql7;
                $datax = mysqli_query($conn,$sql7);
                $oid = mysqli_fetch_assoc($datax); 
                
                /*enimerwse ton pinaka transactions*/
                $kati = $oid['Oid'];
                $kappa = $sum;
                $sql6 = "INSERT INTO transactions (id,name,amount) VALUES('$kati','$name','$kappa')";
                echo "<br>sql6-->".$sql6;
                mysqli_query($conn,$sql6);
                
                $sql3 = "DELETE FROM cart WHERE 1=1";
                mysqli_query($conn,$sql3);
                
                header("Location: home.html");
                
                mysqli_close($conn);
            }
            
        }
        
        
        ?>
        
        <form action="completeBuy.php" method="get">
        <input type="submit" name="complete" value="complete buy" />
        </form>

    </body>
</html>




