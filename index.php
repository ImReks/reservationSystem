<?php
require_once "dbConnect.php";
/**@var  mysqli $db**/
if(isset($_POST["submit"])){

    $id = $_POST["id"];
    $day = $_POST["day"];

    $email = $_POST["email"];
    $descriptions = $_POST["description"];
    mysqli_query($db,"UPDATE $day SET email='$email', description='$descriptions' WHERE id ='$id'");
    }
    if(isset($_POST["cancel"]))
    {
        $id = $_POST["id"];
        $day = $_POST["day"];
        mysqli_query($db,"UPDATE $day SET email=null WHERE id='$id'");
    }
    mysqli_close($db);
    session_start();
    if(isset($_SESSION["Teacher"])) {
        $currentDocent = $_SESSION["Teacher"];
        header("Location:reservationDisplay.php?Teacher=$currentDocent");
        exit();
    }
    else {

        header("Location:reservationDisplay.php");
        exit();
    }
?>
