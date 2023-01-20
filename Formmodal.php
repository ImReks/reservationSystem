<?php
/**@var  mysqli $db**/
//get the data of the reservation you want to make(//It schould be made more secure because it allow now easy acces from the url)
if(isset($_GET["id"])) {
    $id = $_GET["id"];
    $day = $_GET["day"];
}
//data base connection
require_once "dbConnect.php";

//get teacher name using join query.
$result = mysqli_query($db,"SELECT * FROM reservations INNER JOIN teachers_list ON teachers_list.id=reservations.teacher WHERE reservations.id='$id'");
$reservation = mysqli_fetch_row($result);
session_start();
$user = $_SESSION["user"];
//$teacherId = $reservation[1];
//$result = mysqli_query($db,"SELECT * FROM teachers_list WHERE id='$teacherId'");
//$teacherData = mysqli_fetch_row($result);
$teacher =htmlentities($reservation[8]);



mysqli_close($db);
//echo  $day;
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
<div class="modalPadding">
    <h1>Maak afspraak met <?=$teacher?></h1>
    <form action="index.php" method="post" id="1">
        <div class="infoPanel">
            <div class="FlexRow">
                <div>
                <input type="hidden" id="email" name="email" value="remove this">
                <p style="color: red" id="emailMessage"></p>
                </div>
            </div>
        </div>
        <div class="FlexColum">
            <label for="description">Rede voor afspraak</label>

            <textarea name="description" id="description" placeholder="Schrijf hier waarom u een afspraak wil maken" rows="20" cols="70"> </textarea>
        </div>
        <input type="hidden" name="id" value="<?=$id?>">
        <input type="hidden" name="day" value="<?=$day?>">
        <input type="hidden" name="update" value="update">
        <input type ="hidden" name="user" value="<?=$user?>">
        <input type = "submit" name="submit" class="DragDown ActieButton modalMargin Green" value="maak afspraak">

    </form>

</div>

</body>

</html>

