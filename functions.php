<?php 
include_once('dbconnection.php');


$ResultType=$_POST["RESULT_TYPLE"];

switch($ResultType){
    case "LOGIN":
        $result=login($_POST["usarid"],$_POST["password"]);
        break;
}


function login(){
    
}
?>