<?php
$servername="localhost";
$username="root";
$password="";
$dbname="one_network";
$conn=new mysqli($servername , $username , $password , $dbname);
if($conn->connect_errno){
    die("Connection failed:" . $conn->connect_errno);
}

?>