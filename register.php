<?php


        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "hy360_project";
        session_start();
       if (isset($_POST["register"])) {
           
             //Create connection
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            if(!$conn){
                die("Connection failed: " . mysqli_connect_error());
            }
           $name = $_POST['n'];
           $pn = $_POST['num'];
           $adr = $_POST['ad'];
           $bank = $_POST['ba'];
           $pw = $_POST['pw'];
           $cpw = $_POST['cpw'];
           $radio = $_POST['radio'];
           $_SESSION["user"] = $name;
           
           
           if($pw == $cpw) {
               if($radio == "merchant"){
                   echo $name;
           echo $pn;
           echo $adr;
           echo $bank;
           echo $pw;
           echo $cpw;
           echo $radio;
                   $sql = "INSERT INTO merchant (name,phone,address,bank_account,password) VALUES ('$name', '$pn','$adr','$bank', '$pw')";
                   
                    if(mysqli_query($conn, $sql)) {
                        echo "welcome to our site mister merchant";
                        //--home page
                        header("Location: home.html");
                    }
               }else if($radio == "individual") {
                   echo $pn;
           echo $adr;
           echo $bank;
           echo $pw;
           echo $cpw;
           echo $radio;
                             $sql = "INSERT INTO individuals (name,phone,address,bank_account,password) VALUES ('$name', '$pn','$adr','$bank', '$pw')";
                             if(mysqli_query($conn, $sql)) {
                                 echo "welcome to our site mister individual";
                                 //--home page
                                 header("Location: home.html");
                             }
                    }else{
                        echo "pes mas ti eisai individual H merchant?!";   
                    }  
               }else{
                echo "ERROR...The passwords are not same";
                header("Location: login.html");
                }
        
                
       // mysqli_close($conn);
       }
        ?>
