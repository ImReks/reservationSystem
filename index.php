<?php
require_once "dbConnect.php";
/**@var  mysqli $db**/
//when user make's a reservation its data is stored in database
if(isset($_POST["update"])){

    $id = $_POST["id"];
    $day = $_POST["day"];

    $user = $_POST["user"];
    $descriptions = mysqli_escape_string($db,$_POST["description"]);
    mysqli_query($db,"UPDATE reservations SET user='$user', description='$descriptions' WHERE id ='$id'");
    }
//when user wants to cancel the reservation it he gets removed from the data of this reservation.
    if(isset($_POST["cancel"]))
    {
        $id = $_POST["id"];
        $day = $_POST["day"];
        mysqli_query($db,"UPDATE reservations SET user=null WHERE id='$id'");
    }
    mysqli_close($db);
    //redirect to reservation display.
    session_start();
    if(isset($_SESSION["Teacher"])) {
        $currentDocent = $_SESSION["Teacher"];
        header("Location:reservationDisplay.php?Teacher=$currentDocent");
        exit();
    }
    else {
        //check is the user session exist and if so redirect them to reservation display
        if(isset($_SESSION["user"])) {
            header("Location:reservationDisplay.php");
            exit();
        }
        //otherwise reddirect them to login page
        else
        {
            header("Location:LogIn.php");
            exit();
        }
    }
?>
