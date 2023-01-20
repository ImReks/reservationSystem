
//enable the info modal.
function InfoModalPopUP(id,day)
{
    //make the modal visible
   let modal = document.getElementById("infoModal");
   modal.className+=" active orangeBorder";

    let modalBack = document.getElementById("modalBackground");
    modalBack.className+= " active"

    //make a AJAX request to display content of infomodal.php inside the modal element.
    let xhtml = new XMLHttpRequest();
    xhtml.onreadystatechange= function ()
    {
      if(this.readyState==4 && this.status==200)
      {
        modal.innerHTML = this.responseText;
      }
    };
    //console.log("infomodal.php?id="+id.toString()+"&day="+day);
    xhtml.open("GET", "infomodal.php?id="+id.toString()+"&day="+day,true);
    xhtml.send();
}

//enable the form modal.
function FormModalPopUP(id,day)
{
    //make the modal visible
    let modal = document.getElementById("formModal");
    modal.className+=" active greenBorder";
    let modalBack = document.getElementById("modalBackground");
    modalBack.className+=" active"

    //make a AJAX request to display content of formmodal.php inside the modal element.
    let xhtml = new XMLHttpRequest();
    xhtml.onreadystatechange= function ()
    {
        if(this.readyState==4 && this.status==200)
        {
            modal.innerHTML = this.responseText;
        }
    };
    xhtml.open("GET", "formmodal.php?id="+id.toString()+"&day="+day,true);
    xhtml.send();
}
//remove css classes from the modal elemnts that make them display on the screen
function  DisableModal()
{
    let imodal = document.getElementById("infoModal");
    let fmodal = document.getElementById("formModal");
    let modalBack = document.getElementById("modalBackground");
    modalBack.className="modalBackground";
    imodal.className="modal";
    fmodal.className="modal";

}