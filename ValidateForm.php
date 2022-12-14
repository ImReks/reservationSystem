<?php
$type= $_POST["type"];
switch ($type)
{
    case "string": ValidateStringForm($_POST["value"]);
    break;
    case "number": ValidateNumberForm($_POST["value"]);
}
function ValidateStringForm($value)
{
    if($value == "")
    {
        echo"false";
    }
    else
    {
    echo"true";
    }
}
function  ValidateNumberForm($value)
{
    if(!is_numeric($value))
    {
        echo"false";
    }
    else
    {
        echo"true";
    }
}