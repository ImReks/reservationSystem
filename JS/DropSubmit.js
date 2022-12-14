function submitForm(sumbitID)
{
    document.getElementById(sumbitID.toString()).submit();
}
function formmodalSubmitForm(submitID)
{
    let modal = document.getElementById("formModal");
    let email = document.getElementById("email").value;
    let emailResult="";
    let emailRequest = new XMLHttpRequest();
    emailRequest.onreadystatechange= function ()
    {
        if(this.readyState==4 && this.status==200)
        {

            emailResult=this.responseText;
            console.log(this.responseText);
            console.log(emailResult);
            if(emailResult=="true")
            {
                document.getElementById(submitID.toString()).submit();
            }
            else
            {
                document.getElementById("emailMessage").innerText = "Voer email adress in"
            }
        }
    };
    emailRequest.open("POST","ValidateForm.php",true);
    emailRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    emailRequest.send("type=email&value="+email.toString());
}