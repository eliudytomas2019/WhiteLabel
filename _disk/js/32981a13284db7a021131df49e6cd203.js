$(document).ready(function() {
    var id_user        = $('#id_user').val();
    var level          = $("#level").val();

    $("body").on('keyup', '#FormEmpresas', function () {
        var value = $(this).val();

        if(value != ''){
            $.ajax({
                url: '_disk/_help/9e581bf659daf84b4f20a873cecdb47f.inc.php',
                type: 'POST',
                data: 'acao=01'+
                    "&value="+value+
                    "&id_user="+id_user+
                    "&level="+level,
                success: function(r){
                    $("#WriteT").html(r);
                }
            });
        }
    });

    $("body").on('keyup', '#FormAdminUsers', function () {
        var value = $(this).val();

        if(value != ''){
            $.ajax({
                url: '_disk/_help/9e581bf659daf84b4f20a873cecdb47f.inc.php',
                type: 'POST',
                data: 'acao=05'+
                    "&value="+value+
                    "&id_user="+id_user+
                    "&level="+level,
                success: function(r){
                    $("#WriteF").html(r);
                }
            });
        }
    });
});

function Licenca(id){
    var times   = document.getElementById('times').value;
    //var postos  = document.getElementById('postos').value;
    //var users   = document.getElementById('users').value;
    var ps3     = document.getElementById('ps3').value;
    var id_user = document.getElementById('id_user').value;

    if(confirm('deseja salvar/alterar a presente licença?')){
        $.ajax({
            url: '_disk/_help/9e581bf659daf84b4f20a873cecdb47f.inc.php',
            type: 'POST',
            data: 'acao=02'+
                "&id_db_kwanzar="+id+
                "&times="+times+
                //"&postos="+postos+
                //"&users="+users+
                "&id_user="+id_user+
                "&ps3="+ps3,
            success: function(r){
                $("#getResult").html(r);
            }
        });
    }
}

function Linc(id){
    var id_user = document.getElementById('id_user').value;

    if(confirm('Deseja repor as vendas da presente empresa?')){
        $.ajax({
            url: '_disk/_help/9e581bf659daf84b4f20a873cecdb47f.inc.php',
            type: 'POST',
            data: 'acao=03'+
                "&id_user="+id_user+
                "&id_db_settings="+id,
            success: function(r){
                $("#getError").html(r);
            }
        });
    }
}

function WSAlerts(){
    var email_settings = document.getElementById("email_settings").value;
    var email_suppliers = document.getElementById("email_suppliers").value;
    var email_customers = document.getElementById("email_customers").value;
    var email_users = document.getElementById("email_users").value;

    if(confirm("Desejas salvar/alterar o corpo do email?")){
        $.ajax({
            url: '_disk/_help/9e581bf659daf84b4f20a873cecdb47f.inc.php',
            type: 'POST',
            data: 'acao=04'+
                "&email_settings="+email_settings+
                "&email_suppliers="+email_suppliers+
                "&email_customers="+email_customers+
                "&email_users="+email_users,
            success: function(r){
                $("#getAlert").html(r);
            }
        });
    }
}

function MailCustomers(){
    if(confirm("Desejas Enviar email aos clientes?")){
        $.ajax({
            url: 'KwanzarApp/SystemApp/Configurations.inc.php',
            type: 'POST',
            data: 'acao=05',
            success: function(r){
                $("#getError01").html(r);
            }
        });
    }
}

function MailSuppliers(){
    if(confirm("Desejas Enviar email aos fornecedores?")){
        $.ajax({
            url: 'KwanzarApp/SystemApp/Configurations.inc.php',
            type: 'POST',
            data: 'acao=06',
            success: function(r){
                $("#getError01").html(r);
            }
        });
    }
}

function MailUsers(){
    if(confirm("Desejas Enviar email aos usuários?")){
        $.ajax({
            url: 'KwanzarApp/SystemApp/Configurations.inc.php',
            type: 'POST',
            data: 'acao=07',
            success: function(r){
                $("#getError01").html(r);
            }
        });
    }
}

function MailSettings(){
    if(confirm("Desejas Enviar email ao empresas?")){
        $.ajax({
            url: 'KwanzarApp/SystemApp/Configurations.inc.php',
            type: 'POST',
            data: 'acao=08',
            success: function(r){
                $("#getError01").html(r);
            }
        });
    }
}

function AdminSusPassword(id){
    if(confirm("Desejas repor a password do usuário?")){
        $.ajax({
            url: '_disk/_help/9e581bf659daf84b4f20a873cecdb47f.inc.php',
            type: 'POST',
            data: 'acao=06'+
                "&id="+id,
            success: function(r){
                $("#getFake").html(r);
            }
        });
    }
}

function AdminSusUsers(id){
    if(confirm("Desejas suspender o usuário?")){
        $.ajax({
            url: '_disk/_help/9e581bf659daf84b4f20a873cecdb47f.inc.php',
            type: 'POST',
            data: 'acao=07'+
                "&id="+id,
            success: function(r){
                $("#getFake").html(r);
            }
        });
    }
}

function EliminarFactura(){
    if(confirm("Desejas eliminar a presente factura?")){
        if(confirm("Att.: tens a certeza que a presente factura não chegou a sair da empresa/negócio?")){
            var EliminarFacturaID = document.getElementById('EliminarFacturaID').value;

            if(EliminarFacturaID != ''){
                $.ajax({
                    url: '_disk/_help/9e581bf659daf84b4f20a873cecdb47f.inc.php',
                    type: 'POST',
                    data: 'acao=08'+
                        "&EliminarFacturaID="+EliminarFacturaID,
                    success: function(r){
                        $("#AnaJulia").html(r);
                    }
                });
            }else{
                alert("Preecha o campo acima com o ID da factura!");
            }
        }
    }
}

function FACE(){
    if(confirm("Alert: Desejas salvar a operação?")){
        var t     = document.getElementById('tp').value;
        var value = document.getElementById('value').value;

        $.ajax({
            url: '_disk/_help/9e581bf659daf84b4f20a873cecdb47f.inc.php',
            type: 'POST',
            data: 'acao=09'+
                "&tp="+t+
                "&value="+value,
            success: function(r){
                $("#getError").html(r);
            }
        });

    }
}

function Excluded(id){
    if(confirm('Deseja apagar permanentemente apresente empresa do software?')){
        if(confirm('Estás consciênte dos riscos que essa ação poderá causar!?')){
            $.post('./KwanzarApp/SystemApp/Configurations.inc.php', {
                acao: 'Excluded',
                id: id
            }, function(ret){
                $("#Farao").html(ret);
                joaoTomas();
            });
        }
    }
}

function joaoTomas(){
    $.post('./KwanzarApp/SystemApp/Configurations.inc.php', {
        acao: 'ReadExluded'
    }, function(ret){
        $("#IsabelDavid").html(ret);
        joaoTomas();
    });
}