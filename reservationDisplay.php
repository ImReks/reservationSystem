<?php
session_start();
//$db = $_SESSION["db"];
//$reservationList = [];
//require_once 'dbConnect.php';
/**@var  mysqli $db**/
if(isset($_SESSION["user"])) {
    $currentUser =$_SESSION["user"];
}
else
{
    Header("Location:LogIn.php");
    exit;
}
if(!isset($_GET["Teacher"])) {
    $currentTeacher = 1;
}
else
{
    $currentTeacher  =  (int)$_GET["Teacher"];
}
$_SESSION["Teacher"]=$currentTeacher;

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



    function  displayBoxes($dayOfWeek, $week)
    {
        //@VAR $db;
        require'dbConnect.php';
        global $currentUser,$currentTeacher;
        $reservationList=[];
        $dbGetReservationQuerry = "SELECT * FROM $dayOfWeek WHERE teacher ='$currentTeacher' AND week ='$week'";
        $dbQuerryResult = mysqli_query($db,$dbGetReservationQuerry);

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
        foreach ($reservationList as $reservation) {
           // $resDate = $reservation['date'];
            $restime =  mb_strimwidth($reservation['time'],0,5);

            $resDuration = ($reservation['duration']/900)*6.6;
            $resDurationMult = $resDuration/6.6;
            $resDurationGap = max($resDurationMult-1,0)*5;
            $resDurationVW = "$resDuration"."vh";
            $resDurationPX = "$resDurationGap"."px";
            $resDurationString = "Calc($resDurationVW + $resDurationPX)";

            // $formatedDate = strtotime($resDate);
            //  $resDay = date("w",$formatedDate);
            //if($resDay==$dayOfWeek) {
            $dayOfWeek = json_encode($dayOfWeek);
           // print_r($dayOfWeek);
                $id = $reservation['id'];
                if ($reservation['email'] == null) {
                    $jsFunction = "FormModalPopUP($id,$dayOfWeek)";
                    echo "<div onclick='$jsFunction' class='available reservationElement' style='height:$resDurationString;'><p>avaiable $restime</p></div>";
                } else {
                    if ($reservation['email'] == $currentUser) {
                        $jsFunction = "InfoModalPopUP($id,$dayOfWeek)";
                        echo "<div onclick='$jsFunction' class='reservedByUser reservationElement' style='height:$resDurationString;'><p>your appoitment $restime</p></div>";
                    } else {
                        echo "<div class='reserved reservationElement' style='height:$resDurationString;'><p>reserved $restime </p></div>";
                    }
                }
                $dayOfWeek = json_decode($dayOfWeek);
           // }
        }
        mysqli_close($db);
    }
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
<script src="JS/DropSubmit.js"></script>
<header>
    <a href="https://www.devosvlaardingen.nl/" id="HeaderLogo" class="logo header-logo"></a>
    <div class="bannerPane"></div>
</header>
<div onclick="DisableModal()" id="modalBackground" class="modalBackground"></div>
<div id="infoModal" class="modal orangeBorder"></div>
<div id="formModal" class="modal greenBorder"></div>



<div class="Center FlexColum">
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
        <?php displayBoxes("monday", $currentWeek);?>
    </div>
    <div class="resColumn">
        <p class="day">Dinsdag</p>
        <?php displayBoxes("tuesday",$currentWeek);?>
    </div>
    <div class="resColumn">
        <p class="day">Woensdag</p>
        <?php displayBoxes("wednesday",$currentWeek);?>
    </div>
    <div class="resColumn">
        <p class="day">Donderdag</p>
        <?php displayBoxes("thursday",$currentWeek);?>
    </div>
    <div class="resColumn">
        <p class="day">Vrijdag</p>
        <?php displayBoxes("friday",$currentWeek);?>
    </div>
    </div>
</div>



</body>
</html>
