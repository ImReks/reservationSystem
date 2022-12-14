<?php
header("Content-Type: text/plain");
$type= $_POST["type"];
switch ($type)
{
    case "string": ValidateStringForm($_POST["value"]);
    break;
    case "number": ValidateNumberForm($_POST["value"]);
    break;
    case "email": ValidateEmailForm($_POST["value"]);
        break;
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
function ValidateEmailForm($value)
{
    if(filter_var($value,FILTER_VALIDATE_EMAIL))
    {
        echo"true";
    }
    else
    {
        echo"false";
    }
}