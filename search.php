<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>search</title>
    </head>
    <body>
<form action="" method="post">  
Search: <input type="text" name="term" />
<input type="submit" value="search" />  
</form> 
        
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

if (!empty($_REQUEST['term'])) {

$term = mysqli_real_escape_string($conn,$_REQUEST['term']);     

$sql = "SELECT * FROM product WHERE name LIKE '%".$term."%' union SELECT * FROM product WHERE color LIKE '%".$term."%' "
        . "union SELECT * FROM product WHERE producer LIKE '%".$term."%'"
        . "union SELECT * FROM product WHERE varieties LIKE '%".$term."%'"
        . "union SELECT * FROM product WHERE date LIKE '%".$term."%'"; 
$query = mysqli_query($conn,$sql); 

while ($row = mysqli_fetch_array($query)){
    echo"<br />";
    echo 'Name: ' .$row['name']; 
    echo '<br /> Producer: ' .$row['producer']; 
    echo '<br /> Varieties: '.$row['varieties']; 
    echo '<br /> color: '.$row['color']; 
    echo '<br /> date: '.$row['date'];
    echo"<br />";
}  

}
?>
                
    </body>
</html>