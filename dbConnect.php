<?php
$password ="";
$username = "root";
$database = "reservation_system";
$server ="localhost";

$db=mysqli_connect($server,$username,$password,$database);
if(!$db)
{
    die("Connection failed: " . mysqli_connect_error());
}
?>
