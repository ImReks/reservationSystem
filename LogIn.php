<?php
 session_start();
$emailMessage="";
if(isset($_POST["user"]))
{
    if($_POST["user"]!="") {
        $_SESSION["user"] = $_POST["user"];
        Header("Location:reservationDisplay.php");
        exit();
    }
    else
    {
        $emailMessage="voer email in";
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
    <link rel="stylesheet" href="CSS/style.css">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <input type="email" name="user" id="email">
        <p style="color: red"><?=$emailMessage?></p>
        <input type="submit" name="submit" value="log in">
    </form>
</body>
</html>

