<?php
/**@var  mysqli $db**/


//make connection with database
require_once "dbConnect.php";
//get the data of the reservation you want to view(//It schould be made more secure because it allow now easy acces from the url)
$id=$_GET["id"];
$day = $_GET["day"];
//get info about this reservation out of the database
$result = mysqli_query($db,"SELECT * FROM reservations INNER JOIN teachers_list ON teachers_list.id=reservations.teacher WHERE reservations.id='$id'");
$reservation = mysqli_fetch_row($result);
$time = mb_strimwidth(htmlentities($reservation[3]),0,5);
$teacher =htmlentities($reservation[8]);
$description =htmlentities($reservation[6]);
mysqli_close($db);
?>
<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="Css/style.css">
    <title>Document</title>
</head>
<body>
<div class="modalPadding">
<h1>Afspraak met <?=$teacher?></h1>
<div class="infoPanel">
<div class="FlexColum">
    <h2>Datum</h2>
    <p><?=""?></p>
</div>
<div class="FlexColum">
    <h2>Time</h2>
    <p><?=$time?></p>
</div>
<div class="FlexColum">
    <h2>Student</h2>
    <p><?=""?></p>
</div>
</div>
<div class="textFieldDescription">
    <h2>Rede voor afspraak<h2>
            <p><?=$description?></p>
</div>
</div>
<form action="index.php" method="post">
    <input type="hidden" name="id" value="<?=$id?>">
    <input type="hidden" name="day" value="<?=$day?>">
    <input class="DragDown ActieButton modalMargin Orange" type="submit" value="cancel" name="cancel">

</form>
</body>
</html>
