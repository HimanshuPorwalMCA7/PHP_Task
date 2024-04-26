<?php 
$servername="localhost";
$username="root";
$password="";
$dbname="task";

$con=mysqli_connect($servername,$username,$password,$dbname);
if($con->connect_error){
    die("connection Failed".$con->connect_error);
}