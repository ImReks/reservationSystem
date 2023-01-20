<?php
session_start();
//$db = $_SESSION["db"];
//$reservationList = [];
require_once 'dbConnect.php';
/**@var  mysqli $db**/




//retrives userdata from session
if(isset($_SESSION["user"])) {
    $currentUser =$_SESSION["user"];
    $userTeacherID = $_SESSION["userTeacherID"];
}
//if there is no user data redirects to login page
else
{
    Header("Location:LogIn.php");
    exit;
}
//retrives which teacher is currently set if none is set use teacher with id 1 (it can be done cleaner)
if(!isset($_GET["Teacher"])) {
    $currentTeacher = 1;
}
else
{
    $currentTeacher  =  (int)$_GET["Teacher"];
}
$_SESSION["Teacher"]=$currentTeacher;

//retrives which week number to use defaults to current week number (it can be done cleaner)
if(isset($_GET["week"])) {
    $currentWeek = max($_GET["week"] % 53,1);
    $_SESSION["week"]=$currentWeek;
}
else
{
    if (isset($_SESSION["week"]))
    {
        $currentWeek = $_SESSION["week"];
    } else {
        $currentWeek = date("W");
    }
}



//used when teacher creates a new reservation possibility
if(isset($_POST["create"]))
{
    $date = mysqli_escape_string($db,$_POST["date"]);
    $time = mysqli_escape_string($db,$_POST["time"]);
    $duration = $_POST["duration"]*60;
    $location = mysqli_escape_string($db,$_POST["location"]);
  //validate if everything was filled in correctly
    $validation=true;
    if($date=="")
    {
        $validation=false;
    }
    if($time=="")
    {
        $validation=false;
    }
    if(!is_numeric($duration)&&$duration<=0)
    {
        $validation=false;
    }
    if($location=="")
    {
        $validation=false;
    }
    //create reservation when validation is succesful.
    if($validation)
    {
        mysqli_query($db,"INSERT INTO reservations (teacher,date,time,duration,location) VALUES ('$currentTeacher','$date','$time','$duration','$location')");
    }
}
//used when teacher wants to remove reservation possibility
if(isset($_POST["remove"]))
{

    $date = mysqli_escape_string($db,$_POST["date"]);
    $time = mysqli_escape_string($db,$_POST["time"]);
    //validate if everthing was filled correctly
    $validation=true;
    if($date=="")
    {
        $validation=false;
    }
    if($time=="")
    {
        $validation=false;
    }
    //delete reservation if validation is succesful
    if($validation)
    {
        mysqli_query($db,"DELETE FROM reservations WHERE date='$date' AND time='$time' AND teacher='$currentTeacher' ");
    }
}
    mysqli_close($db);

//display all reservation for given day.
    function  displayBoxes($dayOfWeek, $week)
    {
        //@VAR $db;
        //retrive reservations for given day
        require'dbConnect.php';
        global $currentUser,$currentTeacher,$userTeacherID;
        $reservationList=[];
        $dbGetReservationQuerry =  "SELECT * FROM reservations WHERE teacher ='$currentTeacher' AND WEEK(date) = '$week' AND DAYOFWEEK(date)='$dayOfWeek'";
        $dbQuerryResult = mysqli_query($db,$dbGetReservationQuerry);
        //create list of all reservations and sort them based on time.
        while ($row = mysqli_fetch_assoc($dbQuerryResult))
        {
            $reservationList[] = $row;
            if(count($reservationList)>1)
            {
                $i = count($reservationList)-1;
                $continue=true;
                while ($continue && $i>0)
                {
                    if(strtotime($reservationList[$i]['time'])<strtotime($reservationList[$i-1]['time']))
                    {
                        $r1 = $reservationList[$i];
                        $r2 = $reservationList[$i-1];
                        $reservationList[$i]=$r2;
                        $reservationList[$i-1]=$r1;
                    }
                    else
                    {
                        $continue=false;
                    }
                    $i--;
                }
            }
        }
        //loop through all reservation and sets their interaction buttons
        foreach ($reservationList as $reservation) {
           // $resDate = $reservation['date'];
            $location = htmlentities($reservation['location']);
            $restime =  mb_strimwidth(htmlentities($reservation['time']),0,5);
            //sets height of the box based on reservation duration


            $resDuration = ($reservation['duration']/900)*6.6;
            $resDurationMult = $resDuration/6.6;
            $resDurationGap = max($resDurationMult-1,0)*5;
            $resDurationVW = "$resDuration"."vh";
            $resDurationPX = "$resDurationGap"."px";
            $resDurationString = "Calc($resDurationVW + $resDurationPX)";


            //sets what schould happen when the user click on the box

            //this is here to use $dayOfWeek as a javascript parameter
            $dayOfWeek = json_encode($dayOfWeek);
           // print_r($dayOfWeek);
                $id = $reservation['id'];
                //when there is no user sets the box to be able to make its reservation.
                if ($reservation['user'] == null) {
                    $jsFunction = "FormModalPopUP($id,$dayOfWeek)";
                    echo "<div onclick='$jsFunction' class='available reservationElement' style='height:$resDurationString;'><p>$restime $location<br> open</p></div>";
                } else {
                    //when the user is the same as current user or you are the corresponding teacher make the box view reservation info when clicked on
                    if ($reservation['user'] == $currentUser || $currentTeacher==$userTeacherID) {
                        $jsFunction = "InfoModalPopUP($id,$dayOfWeek)";
                        echo "<div onclick='$jsFunction' class='reservedByUser reservationElement' style='height:$resDurationString;'><p>$restime $location<br> uw afspraak</p></div>";
                    //otherwise make it do nothing
                    } else {
                        echo "<div class='reserved reservationElement' style='height:$resDurationString;'><p>$restime $location<br> bezet </p></div>";
                    }
                }
                $dayOfWeek = json_decode($dayOfWeek);
           // }
        }
        mysqli_close($db);
    }
    //create teacher select dropdown menu from database teachers list.
    function changeTeacher()
    {
        global $currentTeacher;
        require 'dbConnect.php';
        $result = mysqli_query($db,"SELECT id,prefix FROM teachers_list");

        while ($row = mysqli_fetch_assoc($result))
        {
            $tid = $row["id"];
            $tpr = $row["prefix"];
            if($currentTeacher==$tid){
             echo "<option selected='selected' value='$tid'>$tpr</option>";
            }
            else
            {
                echo "<option value='$tid'>$tpr</option>";
            }
        }
        mysqli_close($db);
    }
    //view a sidemenu with the ability to create and remove reservation possibilities if you are a teacher and are viewing yours reservations
    function sideMenu()
    {
        $user = $_SESSION["user"];
        global $currentTeacher, $userTeacherID;
        if($currentTeacher==$userTeacherID)
        {
            echo "
            <div class='sideMenu'>
    <h2>Maak afspraak plek</h2>
    <form method='post' action=''>
        <label for='date'>datum</label>
        <input type='date' id='date' name='date'>
        <label for='time'>tijd</label>
        <input type='time' id='time' name='time'>
        <label for='duration'>afspraak lenghte</label>
        <input type='number' id='duration' name='duration'>
        <label for='location'>plek</label>
        <input type='text' id='location' name='location'>
        <input type='submit' name='create' value='maak plek'>
    </form>
    <h2>Verwijder afspraak plek</h2>
    <form method='post' action=''>
        <label for='date'>datum</label>
        <input type='date' id='date' name='date'>
        <label for='time'>tijd</label>
        <input type='time' id='time' name='time'>
        <input type='submit' name='remove' value='verwijder'>
    </form>
    </div>";
        }
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="Css/style.css">
    <title>Document</title>
</head>
<body>
<script src="JS/ModalPopUp.js"></script>
<script src="JS/SubmitForm.js"></script>
<div onclick="DisableModal()" id="modalBackground" class="modalBackground"></div>
<div id="infoModal" class="modal orangeBorder"></div>
<div id="formModal" class="modal greenBorder"></div>
<header>
    <div class="headerFlex">
    <a href="https://www.devosvlaardingen.nl/" id="HeaderLogo" class="logo header-logo"></a>
    <a href="LogOut.php">uitmelden</a>
    </div>
    <div class="bannerPane"></div>

</header>


<div class="Center FlexRow flexCenter">
<?php sideMenu();?>
<div class="FlexColum Shadow">

    <div class="tableNavPanel FlexRow">
        <div class="FlexRow week">
        <a class="weekToggle" href="?Teacher=<?=$currentTeacher?>&week=<?=$currentWeek-1?>"> < </a>
        <p> Week <?=$currentWeek?> </p>
        <a class="weekToggle" href="?Teacher=<?=$currentTeacher?>&week=<?=$currentWeek+1?>"> > </a>
        </div>
        <form action="" method="get" id="0">
            <select name="Teacher" id="Teacher" onchange="submitForm(0)">
                <?php
                changeTeacher();
                ?>
            </select>
            <input type="hidden" name="week" value="<?=$currentWeek?>">
        </form>

    </div>
    <div class="Table FlexRow">
    <div class="resColumn">
        <p class="day">Maandag</p>
        <?php displayBoxes("2", $currentWeek);?>
    </div>
    <div class="resColumn">
        <p class="day">Dinsdag</p>
        <?php displayBoxes("3",$currentWeek);?>
    </div>
    <div class="resColumn">
        <p class="day">Woensdag</p>
        <?php displayBoxes("4",$currentWeek);?>
    </div>
    <div class="resColumn">
        <p class="day">Donderdag</p>
        <?php displayBoxes("5",$currentWeek);?>
    </div>
    <div class="resColumn">
        <p class="day">Vrijdag</p>
        <?php displayBoxes("6",$currentWeek);?>
    </div>
    </div>
</div>
</div>
<footer>
    <p style="color:white"> footer </p>
</footer>
</body>
</html>
