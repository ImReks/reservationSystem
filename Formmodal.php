<?php
/**@var  mysqli $db**/

if(isset($_GET["id"])) {
    $id = $_GET["id"];
    $day = $_GET["day"];
}
require_once "dbConnect.php";

$result = mysqli_query($db,"SELECT * FROM $day WHERE id='$id'");
$reservation = mysqli_fetch_row($result);

$teacherId = $reservation[2];
$result = mysqli_query($db,"SELECT * FROM teachers_list WHERE id='$teacherId'");
$teacherData = mysqli_fetch_row($result);
$teacher = $teacherData[1];



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
    <form action="index.php" method="post">
        <div class="infoPanel">
            <div class="textField">
                <label for="email">Contact mail</label>
                <input type="email" id="email" name="email" value=>
                <p style="color: red"></p>
            </div>
        </div>
        <div class="textField">
            <label for="description">Rede voor afspraak</label>

            <textarea name="description" id="description" placeholder="Schrijf hier waarom u een afspraak wil maken"> </textarea>
        </div>
        <input type="hidden" name="id" value="<?=$id?>">
        <input type="hidden" name="day" value="<?=$day?>">
        <input type="submit" name="submit" value="maak afspraak">
    </form>
</div>
</body>
</html>

