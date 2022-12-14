function submitForm(sumbitID)
{
    document.getElementById(sumbitID.toString()).submit();
}
function formmodalSubmitForm(id,day,submitID)
{
    let modal = document.getElementById("formModal");
    let email = document.getElementById("email").value;
    let emailResult ="";
    let emailRequest = new XMLHttpRequest();
    emailRequest.onreadystatechange= function ()
    {
        if(this.readyState==4 && this.status==200)
        {
            emailResult = this.responseText;
        }
    };
    emailRequest.open("POST","ValidateForm.php",true);
    emailRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    emailRequest.send("type=string&value="+email.toString());
    console.log(emailResult);
    if(emailResult=="true")
    {
        document.getElementById(submitID.toString()).submit();
    }
    else
    {
        let description = document.getElementById("description").value;
        document.getElementById("formModal").innerHTML="";
        //  console.log(email.toString()+"_"+description.toString());
        let parameters = "email="+email.toString()+"&description="+description.toString()+"&id="+id.toString()+"&day="+day.toString();
        let xhtml = new XMLHttpRequest();
        xhtml.onreadystatechange= function ()
        {
            if(this.readyState==4 && this.status==200)
            {
                modal.innerHTML = this.responseText;
            }
        };
        xhtml.open("POST", "formmodal.php?id="+id.toString()+"&day="+day,true);
        xhtml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhtml.send(parameters);
    }


}