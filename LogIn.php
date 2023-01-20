<?php
/**@var  mysqli $db**/
//Start session on database connection
 session_start();

require_once'dbConnect.php';

//Validation fout messages
 $emailMessage="";
 $passwordMessage="";
 $nameMessage="";
 //Form that will be displayed
 $form="";

 //This is used when user registers a new account
if(isset($_GET["register"]))
{
    if(isset($_POST["submit"]))
    {
        //Get the user name and email from POST.
        $name = mysqli_escape_string($db,$_POST["name"]);
        $email =mysqli_escape_string($db, $_POST["user"]);
        //Check validation
        $correct=true;
        if($_POST["user"]=="") {
            $correct=false;
            $emailMessage="voer email in";
        }
        if($_POST["password"]=="")
        {
            $correct=false;
            $passwordMessage="voer wachtwoord in";
        }
        if($_POST["password"] !=$_POST["conPassword"])
        {
            $correct=false;
            $passwordMessage="de ingevoerde wachtwoord komt niet overeen met controlle wachtword";
        }
        if($_POST["name"]="")
        {
            $correct=false;
            $nameMessage ="voer naam in";
        }
        //add acount to database if the vorm is valid.
        if($correct==true)
        {
            //check if the is already an acount with the same email
            $searchForAccount = mysqli_query($db,"SELECT email FROM users WHERE email='$email'");
            //add acount to dabase if there is no duplicate
            if(mysqli_num_rows($searchForAccount)==0)
            {
                //hash password
                $hashedPassword = password_hash($_POST["password"],PASSWORD_DEFAULT);

                //insert data into database and redirect to log in page.
                mysqli_query($db,"INSERT INTO users (name,email,password) VALUES ('$name','$email','$hashedPassword')");
                mysqli_close($db);
                header("Location:LogIn.php");
                exit;

            }
            //show duplicate message if this account already exists
            else
            {
                $emailMessage="er bestaat er al een account voor deze email";
            }
        }
    }
    else
    {
        $email="";
        $name="";
    }

    //This is the form that you see when the user registers new account.
    $form="    <form action='' method='post' class='FlexColum'>
    <label class='blueText' for='name'>name</label>
    <input type='text' name='name' id='name' value='$name'>
    <p style='color: red'>$nameMessage</p>
    <label class='blueText' for='email'>email</label>
    <input type='email' name='user' id='email' value='$email'>
    <p style='color: red'>$emailMessage</p>
    <label class='blueText' for='password'>password</label>
    <input type='password' name='password' id='password'>
    <p style='color: red'>$passwordMessage</p>

    <label class='blueText' for='conPassword'>confirm password</label>
    <input type='password' name='conPassword' id='conPassword'>
   
    <input type='submit' name='submit' value='register'>
    <a href='?'>heb je er al een account click hier om in te loggen</a>
</form>";
   
}
//this is used when user wants to log in
else
{
    if(isset($_POST["user"]))
    {
        //get user email from POST
        $email =mysqli_escape_string($db, $_POST["user"]);
        if($_POST["user"]!="") {
            if($_POST["password"]!="")
            {
                //retrive hashed password
                $result = mysqli_query($db,"SELECT * FROM users WHERE email='$email'");
                $row =mysqli_fetch_assoc($result);
                $retrivedPassword="";
                $retrivedPassword = $row["password"];
                //check if the Form password is corresponds to the hashed password
                if(password_verify($_POST["password"],$retrivedPassword))
                {
                    //store user data in session and redirect to reservation display.
                    $_SESSION["user"]=$row["id"];
                    $_SESSION["userTeacherID"]=$row['teacherID'];
                    mysqli_close($db);
                    header("Location:reservationDisplay.php");
                    exit;
                }
                //view message if password or email are not correct.
                else
                {
                    $emailMessage="de email en/of wachtwoord kloppen niet";
                }
            }
            //view message if there is no password filled in
            else
            {
                $passwordMessage="voer wachtwoord in";
            }
        }
        //view message if there is no email filled in.
        else
        {
            $emailMessage="voer email in";
        }
    }
    else
    {
        $email="";
    }

//this is the form that is used for log in.
    $form = "          <form action='' method='post' class='FlexColum'>
    <label class='blueText' for='email'>email</label>
    <input type='email' name='user' id='email' value='$email'>
    <p style='color: red'>$emailMessage</p>
    <label class='blueText' for='password'>password</label>
    <input type='password' name='password' id='password'>
    <p style='color: red'>$passwordMessage</p>
    <input type='submit' name='submit' value='log in'>
    <a href='?register'>nog geen account click hier om een te maken</a>";
 
}
mysqli_close($db);



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
<header>
    <a href="https://www.devosvlaardingen.nl/" id="HeaderLogo" class="logo header-logo"></a>
    <div class="bannerPane"></div>
</header>
    <div class="Center FlexRow flexCenterRow">

        <?=$form?>
    </div>   
</body>
</html>

