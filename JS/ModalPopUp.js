function InfoModalPopUP(id,day)
{
   let modal = document.getElementById("infoModal");
   modal.className+=" active orangeBorder";

    let modalBack = document.getElementById("modalBackground");
    modalBack.className+= " active"


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
function FormModalPopUP(id,day)
{
    let modal = document.getElementById("formModal");
    modal.className+=" active greenBorder";
    let modalBack = document.getElementById("modalBackground");
    modalBack.className+=" active"
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
function  DisableModal()
{
    let imodal = document.getElementById("infoModal");
    let fmodal = document.getElementById("formModal");
    let modalBack = document.getElementById("modalBackground");
    modalBack.className="modalBackground";
    imodal.className="modal";
    fmodal.className="modal";

}