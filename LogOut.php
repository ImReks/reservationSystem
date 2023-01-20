<?php
//Log out by destroying the session and sending user to log in page.
session_start();
session_destroy();
Header("Location:LogIN.php");
exit();
?>