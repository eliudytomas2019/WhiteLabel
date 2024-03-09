function Kwanzar(){
    var name = document.getElementById("name").value;
    var RemitenteEmail = document.getElementById("RemitenteEmail").value;
    var subject = document.getElementById("subject").value;
    var message = document.getElementById("message").value;


    $.ajax({
        url: "./Website/SystemApp.inc.php",
        type: "POST",
        data: "acao=Kwanzar"+
            "&name="+name+
            "&RemitenteEmail="+RemitenteEmail+
            "&subject="+subject+
            "&message="+message,
        success: function(eu){
            $('#getResult').html(eu);
        }
    });

    return false;
}