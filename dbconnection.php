<?php
    $servername= "localhost";
    $username = "root";
    $password = "";
    $dbname = "yashcoldrinks";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if($conn->connect_error){
        echo "Connection failed!";
        die("Connection failed".$conn->connect_error);
    } else{
        // echo "Connection Successfull!";  
    }
?>